<?php

declare(strict_types=1);

/**
 * This file is part of the VitexSoftware package
 *
 * https://vitexsoftware.com/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VSCZ\ui;

/**
 * Coding activity for the homepage: WakaTime (week + languages) and public GitHub events.
 *
 * WakaTime publishes the shared charts only as SVG, so the values are read from them.
 * Results are cached in the temp directory for an hour; on a failed fetch the stale
 * cache is used, so a slow API never breaks the page.
 */
class Activity
{
    public const WAKATIME_LANGUAGES = 'https://wakatime.com/share/@Vitex/f11768fc-15a3-4bdb-a419-32c058346b7e.svg';
    public const WAKATIME_DAYS = 'https://wakatime.com/share/@Vitex/5c5862c7-25c7-452d-a381-591ba73f9501.svg';
    public const GITHUB_USER = 'Vitexus';
    private const TTL = 3600;

    /**
     * Minutes of coding per day of the last week, oldest first.
     *
     * @return array<string, int> day label => minutes
     */
    public static function days(): array
    {
        return self::cached('wakatime-days', static function (): array {
            $svg = self::fetch(self::WAKATIME_DAYS);
            $days = [];

            if ($svg && preg_match_all('~<desc class="value">([^<]*)</desc>.*?<desc class="x_label">([^<]+)</desc>~s', $svg, $m, \PREG_SET_ORDER)) {
                foreach ($m as [, $value, $label]) {
                    $hours = preg_match('/(\d+)\s*hr/', $value, $h) ? (int) $h[1] : 0;
                    $mins = preg_match('/(\d+)\s*min/', $value, $mm) ? (int) $mm[1] : 0;
                    $days[$label] = $hours * 60 + $mins;
                }
            }

            return $days;
        });
    }

    /**
     * Languages of the last week.
     *
     * @return array<string, float> language => percent, biggest first
     */
    public static function languages(): array
    {
        return self::cached('wakatime-languages', static function (): array {
            $svg = self::fetch(self::WAKATIME_LANGUAGES);
            $langs = [];

            if ($svg && preg_match_all('~<text[^>]*>([^<(]+?) \((\d+(?:\.\d+)?)%\)</text>~', $svg, $m, \PREG_SET_ORDER)) {
                foreach ($m as [, $name, $percent]) {
                    $langs[html_entity_decode(trim($name))] = (float) $percent;
                }
            }

            arsort($langs);

            return $langs;
        });
    }

    /**
     * Public GitHub activity without dependabot branch noise.
     *
     * @return array{repos: list<array{name: string, pushes: int, last: int}>, daily: array<string, int>} daily = last 7 days
     */
    public static function github(): array
    {
        return self::cached('github-events', static function (): array {
            $json = self::fetch('https://api.github.com/users/'.self::GITHUB_USER.'/events/public?per_page=100', [
                'Accept: application/vnd.github+json',
            ]);
            $events = json_decode((string) $json, true);

            if (!\is_array($events) || !array_is_list($events)) {
                return [];
            }

            $weekAgo = time() - 7 * 86400;
            $repos = [];
            $daily = [];

            for ($i = 6; $i >= 0; --$i) {
                $daily[date('Y-m-d', strtotime("-{$i} days"))] = 0;
            }

            foreach ($events as $event) {
                $ref = (string) ($event['payload']['ref'] ?? '');

                if (str_contains($ref, 'dependabot/')) {
                    continue;
                }

                $when = strtotime((string) ($event['created_at'] ?? ''));
                $day = date('Y-m-d', $when);

                if (isset($daily[$day])) {
                    ++$daily[$day];
                }

                if (($event['type'] ?? '') === 'PushEvent' && $when >= $weekAgo) {
                    $name = (string) $event['repo']['name'];
                    $repos[$name] ??= ['name' => $name, 'pushes' => 0, 'last' => 0];
                    ++$repos[$name]['pushes'];
                    $repos[$name]['last'] = max($repos[$name]['last'], $when);
                }
            }

            usort($repos, static fn (array $a, array $b): int => [$b['pushes'], $b['last']] <=> [$a['pushes'], $a['last']]);

            return ['repos' => \array_slice($repos, 0, 6), 'daily' => $daily];
        });
    }

    /**
     * "2 h ago" style time.
     */
    public static function ago(int $timestamp): string
    {
        $diff = max(0, time() - $timestamp);

        if ($diff < 3600) {
            return sprintf(_('%d min ago'), max(1, intdiv($diff, 60)));
        }

        if ($diff < 86400) {
            return sprintf(_('%d h ago'), intdiv($diff, 3600));
        }

        if ($diff < 2 * 86400) {
            return _('yesterday');
        }

        return sprintf(_('%d d ago'), intdiv($diff, 86400));
    }

    /**
     * @param callable(): array $loader
     */
    private static function cached(string $key, callable $loader): array
    {
        $file = sys_get_temp_dir().'/vscz-activity-'.$key.'.json';
        $cached = is_readable($file) ? json_decode((string) file_get_contents($file), true) : null;

        if (\is_array($cached) && filemtime($file) > time() - self::TTL) {
            return $cached;
        }

        $fresh = $loader();

        if (!empty($fresh)) {
            @file_put_contents($file, json_encode($fresh));

            return $fresh;
        }

        if (\is_array($cached)) {
            @touch($file); // keep the stale data and try again in an hour

            return $cached;
        }

        return [];
    }

    private static function fetch(string $url, array $headers = []): ?string
    {
        $token = \Ease\Shared::cfg('GITHUB_TOKEN');

        if ($token && str_starts_with($url, 'https://api.github.com/')) {
            $headers[] = 'Authorization: Bearer '.$token;
        }

        $context = stream_context_create(['http' => [
            'timeout' => 4,
            'header' => implode("\r\n", array_merge(['User-Agent: vitexsoftware.cz'], $headers)),
            'ignore_errors' => false,
        ]]);
        $body = @file_get_contents($url, false, $context);

        return $body === false ? null : $body;
    }
}
