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

namespace VSCZ;

/**
 * Reads AppStream DEP-11 YAML from the apt cache for repo.vitexsoftware.com
 * and provides per-package metadata (icon, summary, description, categories, URLs).
 */
class AppStream
{
    private static array $index = [];
    private static string $mediaBaseUrl = '';
    private static bool $loaded = false;

    private static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        $gz = self::findYamlGz();

        if ($gz === null || !file_exists($gz)) {
            return;
        }

        $content = gzdecode(file_get_contents($gz));

        if ($content === false) {
            return;
        }

        $docs = \yaml_parse($content, -1);

        if (!\is_array($docs)) {
            return;
        }

        foreach ($docs as $doc) {
            if (!\is_array($doc)) {
                continue;
            }

            // Header document — grab MediaBaseUrl
            if (isset($doc['MediaBaseUrl'])) {
                self::$mediaBaseUrl = rtrim($doc['MediaBaseUrl'], '/');

                continue;
            }

            // Component document — index by Package name
            if (isset($doc['Package'])) {
                self::$index[$doc['Package']] = $doc;
            }
        }
    }

    private static function findYamlGz(): ?string
    {
        // Search apt lists for the vitexsoftware DEP-11 Components file
        $candidates = glob('/var/lib/apt/lists/repo.vitexsoftware.com_dists_*_dep11_Components-amd64.yml.gz');

        if ($candidates) {
            // Prefer trixie; sort so newer distros come last
            sort($candidates);

            return end($candidates);
        }

        return null;
    }

    public static function get(string $package): ?array
    {
        self::load();

        return self::$index[$package] ?? null;
    }

    public static function has(string $package): bool
    {
        self::load();

        return isset(self::$index[$package]);
    }

    public static function all(): array
    {
        self::load();

        return self::$index;
    }

    /**
     * Returns the full HTTPS URL for the 128×128 icon, or null if unavailable.
     */
    public static function iconUrl(string $package): ?string
    {
        $comp = self::get($package);

        if (!$comp) {
            return null;
        }

        $remote = $comp['Icon']['remote'] ?? [];

        foreach ($remote as $r) {
            if (($r['width'] ?? 0) >= 128) {
                return self::$mediaBaseUrl.'/'.$r['url'];
            }
        }

        // Fall back to first remote icon
        if (!empty($remote)) {
            return self::$mediaBaseUrl.'/'.$remote[0]['url'];
        }

        return null;
    }

    public static function mediaBaseUrl(): string
    {
        self::load();

        return self::$mediaBaseUrl;
    }

    /**
     * Returns the VCS (GitHub) browser URL from AppStream Url section.
     */
    public static function vcsBrowserUrl(string $package): ?string
    {
        $comp = self::get($package);

        return $comp['Url']['vcs-browser'] ?? null;
    }
}
