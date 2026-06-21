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
 * Provides GitHub repository metadata from a pre-fetched static data file.
 *
 * To refresh: run src/data/fetch_github.sh and commit the result.
 */
class GitHubInfo
{
    private static ?array $data = null;

    private static function load(): array
    {
        if (self::$data !== null) {
            return self::$data;
        }

        $file = \dirname(__DIR__, 2).'/data/github_repos.php';
        self::$data = file_exists($file) ? (require $file) : [];

        return self::$data;
    }

    public static function get(string $repoPath): array
    {
        return self::load()[$repoPath] ?? [];
    }

    public static function description(string $repoPath): string
    {
        return self::get($repoPath)['description'] ?? '';
    }

    public static function topics(string $repoPath): array
    {
        return self::get($repoPath)['topics'] ?? [];
    }

    public static function language(string $repoPath): string
    {
        return self::get($repoPath)['language'] ?? '';
    }

    public static function stars(string $repoPath): int
    {
        return (int) (self::get($repoPath)['stars'] ?? 0);
    }
}
