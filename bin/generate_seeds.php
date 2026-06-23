#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Generate one Phinx seed file per VitexSoftware GitHub repo.
 * Output goes to db/seeds/releases/
 *
 * Usage: php bin/generate_seeds.php
 */

$allRepos = require __DIR__.'/../src/data/github_repos.php';
$repos    = array_filter(
    $allRepos,
    static fn (string $k): bool => str_starts_with($k, 'VitexSoftware/'),
    \ARRAY_FILTER_USE_KEY,
);

$outDir = __DIR__.'/../db/seeds/releases';

if (!is_dir($outDir)) {
    mkdir($outDir, 0755, true);
}

$generated = 0;

foreach (array_keys($repos) as $repoPath) {
    $repoName  = substr($repoPath, strlen('VitexSoftware/'));
    $className = repoToClassName($repoName).'Releases';
    $file      = "{$outDir}/{$className}.php";

    if (file_exists($file)) {
        continue; // don't overwrite existing customised seeds
    }

    file_put_contents($file, <<<PHP
<?php

declare(strict_types=1);

require_once __DIR__.'/../../AbstractReleasesSeed.php';

class {$className} extends AbstractReleasesSeed
{
    protected const REPO = '{$repoPath}';
}
PHP);

    echo "Generated: {$className}.php\n";
    ++$generated;
}

echo "\nTotal: {$generated} new seed files in db/seeds/releases/\n";

function repoToClassName(string $name): string
{
    // abraflexi-backup → AbrafleximBackup
    // MultiFlexi → Multiflexi
    $words = preg_split('/[-_]/', $name);

    return implode('', array_map('ucfirst', array_map('strtolower', $words)));
}
