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
 * Parses the apt Packages file for repo.vitexsoftware.com (trixie main)
 * and provides per-package metadata: version, description, homepage.
 */
class DebPackages
{
    private static array $index  = [];
    private static bool $loaded  = false;

    private static function load(): void
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        $file = self::findPackagesFile();

        if ($file === null) {
            return;
        }

        $content = file_get_contents($file);

        if ($content === false) {
            return;
        }

        // Split on blank lines between stanzas
        $stanzas = preg_split('/\n\n+/', $content);

        foreach ($stanzas as $stanza) {
            if (!$stanza) {
                continue;
            }

            $pkg = self::parseStanza($stanza);

            if (isset($pkg['Package'])) {
                self::$index[$pkg['Package']] = $pkg;
            }
        }
    }

    private static function findPackagesFile(): ?string
    {
        $candidates = glob('/var/lib/apt/lists/repo.vitexsoftware.com_dists_trixie_main_binary-amd64_Packages');

        return $candidates ? $candidates[0] : null;
    }

    private static function parseStanza(string $stanza): array
    {
        $result    = [];
        $lines     = explode("\n", $stanza);
        $lastKey   = null;
        $descLines = [];

        foreach ($lines as $line) {
            if ($line === '') {
                continue;
            }

            if ($line[0] === ' ' || $line[0] === "\t") {
                // Continuation line (description body)
                if ($lastKey === 'Description') {
                    $stripped = ltrim($line);
                    $descLines[] = $stripped === '.' ? '' : $stripped;
                }

                continue;
            }

            $colon = strpos($line, ': ');

            if ($colon === false) {
                continue;
            }

            $key     = substr($line, 0, $colon);
            $value   = substr($line, $colon + 2);
            $lastKey = $key;

            if ($key === 'Description') {
                $result['ShortDescription'] = $value;
                $descLines                  = [];
            } else {
                $result[$key] = $value;
            }
        }

        if ($descLines) {
            $result['LongDescription'] = trim(implode(' ', array_filter($descLines, fn ($l) => $l !== '')));
        }

        return $result;
    }

    public static function get(string $package): ?array
    {
        self::load();

        return self::$index[$package] ?? null;
    }

    public static function version(string $package): string
    {
        $pkg = self::get($package);

        if (!$pkg) {
            return '';
        }

        // Strip epoch and distro suffix (e.g. "2.0.0.230~trixie" → "2.0.0.230")
        $v = preg_replace('/~[a-z]+$/', '', $pkg['Version'] ?? '');
        $v = preg_replace('/^\d+:/', '', (string) $v);

        return $v;
    }

    public static function description(string $package): string
    {
        $pkg = self::get($package);

        return $pkg['LongDescription'] ?? $pkg['ShortDescription'] ?? '';
    }

    public static function homepage(string $package): string
    {
        return self::get($package)['Homepage'] ?? '';
    }

    public static function has(string $package): bool
    {
        self::load();

        return isset(self::$index[$package]);
    }
}
