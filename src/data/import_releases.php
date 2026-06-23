#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Import GitHub release notes as blog articles (EN + CS via Claude translation).
 *
 * Usage:
 *   php src/data/import_releases.php [--dry-run] [--repo VitexSoftware/name] [--limit N] [--prereleases]
 *
 * Requires:
 *   ANTHROPIC_API_KEY env var for Czech translation.
 *   Authenticated gh CLI for GitHub access.
 */

namespace VSCZ;

require_once __DIR__.'/../includes/VSInit.php';

use League\CommonMark\GithubFlavoredMarkdownConverter;

// --- CLI argument parsing ---
$opts       = getopt('', ['dry-run', 'repo:', 'limit:', 'prereleases']);
$dryRun     = isset($opts['dry-run']);
$onlyRepo   = $opts['repo'] ?? null;
$releaseLimit = (int) ($opts['limit'] ?? 20);
$includePre = isset($opts['prereleases']);
$apiKey     = getenv('ANTHROPIC_API_KEY') ?: '';

if ($dryRun) {
    echo "[DRY-RUN] No DB writes will happen.\n";
}

if (!$apiKey) {
    echo "[WARN] ANTHROPIC_API_KEY not set — Czech translations will fall back to English body.\n";
}

// --- Setup ---
$converter = new GithubFlavoredMarkdownConverter(['html_input' => 'allow', 'allow_unsafe_links' => true]);
$newsModel = new News();
$pdo       = $newsModel->getFluentPDO()->getPdo();

$allRepos = require __DIR__.'/github_repos.php';
$repos    = array_filter(
    $allRepos,
    static fn (string $k): bool => str_starts_with($k, 'VitexSoftware/'),
    \ARRAY_FILTER_USE_KEY,
);

if ($onlyRepo) {
    $key   = str_starts_with($onlyRepo, 'VitexSoftware/') ? $onlyRepo : 'VitexSoftware/'.$onlyRepo;
    $repos = isset($repos[$key]) ? [$key => $repos[$key]] : [];

    if (empty($repos)) {
        echo "[ERROR] Repo '{$key}' not found in github_repos.php\n";
        exit(1);
    }
}

$totalInserted = 0;
$totalSkipped  = 0;
$totalErrors   = 0;

// --- Helpers ---

function resolveLogoUrl(string $repoName): string
{
    $base = __DIR__.'/..';

    foreach ([
        "img/{$repoName}.svg",
        "img/deb/{$repoName}.svg",
        "img/{$repoName}.png",
        "img/deb/{$repoName}.png",
    ] as $path) {
        if (file_exists("{$base}/{$path}")) {
            return $path;
        }
    }

    return 'img/github.svg';
}

function translateToCs(string $text, string $apiKey, string $context = 'body'): string
{
    if (!$apiKey || !trim($text)) {
        return $text;
    }

    $system = $context === 'title'
        ? 'Translate the following GitHub release title to Czech. Keep version numbers, project names, and technical identifiers unchanged. Return only the translated title, nothing else.'
        : 'Translate the following GitHub release notes from English to Czech. Keep ALL Markdown formatting, code blocks, commands, URLs, package names, and technical identifiers exactly as-is. Only translate prose text. Return only the translated text.';

    $payload = json_encode([
        'model'      => 'claude-haiku-4-5-20251001',
        'max_tokens' => 4096,
        'system'     => $system,
        'messages'   => [['role' => 'user', 'content' => $text]],
    ]);

    $ch = curl_init('https://api.anthropic.com/v1/messages');
    curl_setopt_array($ch, [
        \CURLOPT_RETURNTRANSFER => true,
        \CURLOPT_HTTPHEADER     => [
            'x-api-key: '.$apiKey,
            'anthropic-version: 2023-06-01',
            'content-type: application/json',
        ],
        \CURLOPT_POSTFIELDS => $payload,
        \CURLOPT_TIMEOUT    => 30,
    ]);
    $raw  = curl_exec($ch);
    $code = curl_getinfo($ch, \CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200 || !$raw) {
        return $text;
    }

    $resp = json_decode($raw, true);

    return $resp['content'][0]['text'] ?? $text;
}

function buildArticleHtml(
    string $repoName,
    string $tagName,
    string $logoUrl,
    string $bodyHtml,
    string $githubUrl,
    string $btnLabel,
): string {
    return <<<HTML
<div class="release-info d-flex align-items-center gap-3 mb-4">
  <img src="{$logoUrl}" alt="{$repoName}" style="height:48px;object-fit:contain;flex-shrink:0">
  <div>
    <h4 class="mb-0">{$repoName}</h4>
    <span class="badge bg-secondary">{$tagName}</span>
  </div>
</div>
{$bodyHtml}
<div class="mt-3">
  <a href="{$githubUrl}" class="btn btn-sm btn-outline-dark" target="_blank" rel="noopener">
    {$btnLabel}
  </a>
</div>
HTML;
}

function sourceExists(\PDO $pdo, string $url): bool
{
    $stmt = $pdo->prepare('SELECT id FROM news WHERE source_url = ? LIMIT 1');
    $stmt->execute([$url]);

    return (bool) $stmt->fetch();
}

function insertArticle(\PDO $pdo, array $data, bool $dryRun): bool
{
    if ($dryRun) {
        echo "  [DRY] Would insert: [{$data['language']}] {$data['title']}\n";

        return true;
    }

    $stmt = $pdo->prepare(
        'INSERT INTO news (title, text, DatCreate, author, language, source_url) VALUES (?, ?, ?, 0, ?, ?)',
    );

    return $stmt->execute([
        $data['title'],
        $data['text'],
        $data['DatCreate'],
        $data['language'],
        $data['source_url'],
    ]);
}

// --- Main loop ---
foreach ($repos as $repoPath => $_meta) {
    $repoName = substr($repoPath, strlen('VitexSoftware/'));
    $logoUrl  = resolveLogoUrl($repoName);

    echo "\n[{$repoPath}]\n";

    $listJson = shell_exec(
        sprintf(
            'gh release list --repo %s --json tagName,name,publishedAt,isPrerelease --limit %d 2>/dev/null',
            escapeshellarg($repoPath),
            $releaseLimit,
        ),
    );

    if (!$listJson) {
        echo "  No releases or error.\n";

        continue;
    }

    $releases = json_decode($listJson, true);

    if (empty($releases)) {
        echo "  No releases.\n";

        continue;
    }

    foreach ($releases as $rel) {
        if ($rel['isPrerelease'] && !$includePre) {
            continue;
        }

        $tag      = $rel['tagName'];
        $enSrcUrl = "https://github.com/{$repoPath}/releases/tag/{$tag}#en";
        $csSrcUrl = "https://github.com/{$repoPath}/releases/tag/{$tag}#cs";

        // Skip if both versions already exist
        $enExists = sourceExists($pdo, $enSrcUrl);
        $csExists = sourceExists($pdo, $csSrcUrl);

        if ($enExists && $csExists) {
            echo "  SKIP {$tag} (already imported)\n";
            ++$totalSkipped;

            continue;
        }

        // Fetch full release details
        $viewJson = shell_exec(
            sprintf(
                'gh release view %s --repo %s --json name,tagName,body,url,publishedAt 2>/dev/null',
                escapeshellarg($tag),
                escapeshellarg($repoPath),
            ),
        );

        if (!$viewJson) {
            echo "  ERROR fetching {$tag}\n";
            ++$totalErrors;

            continue;
        }

        $data        = json_decode($viewJson, true);
        $body        = $data['body'] ?? '';
        $githubUrl   = $data['url'] ?? "https://github.com/{$repoPath}/releases/tag/{$tag}";
        $publishedAt = substr($data['publishedAt'] ?? date('Y-m-d H:i:s'), 0, 19);
        $publishedAt = str_replace('T', ' ', $publishedAt);

        // Convert markdown to HTML
        $bodyHtml = $body ? $converter->convert($body)->getContent() : '';

        // --- English article ---
        if (!$enExists) {
            $enTitle = "{$repoName} {$tag} released";
            $enHtml  = buildArticleHtml($repoName, $tag, $logoUrl, $bodyHtml, $githubUrl, 'View release on GitHub →');
            $ok      = insertArticle($pdo, [
                'title'      => $enTitle,
                'text'       => $enHtml,
                'DatCreate'  => $publishedAt,
                'language'   => 'en',
                'source_url' => $enSrcUrl,
            ], $dryRun);

            if ($ok) {
                echo "  + EN {$tag}\n";
                ++$totalInserted;
            } else {
                echo "  ! EN {$tag} insert failed\n";
                ++$totalErrors;
            }
        }

        // --- Czech article ---
        if (!$csExists) {
            $csBody  = translateToCs($body ?: $repoName.' '.$tag, $apiKey, 'body');
            $csTitle = translateToCs("{$repoName} {$tag} released", $apiKey, 'title');
            $csHtml  = buildArticleHtml(
                $repoName,
                $tag,
                $logoUrl,
                $body ? $converter->convert($csBody)->getContent() : '',
                $githubUrl,
                'Zobrazit vydání na GitHub →',
            );
            $ok = insertArticle($pdo, [
                'title'      => $csTitle,
                'text'       => $csHtml,
                'DatCreate'  => $publishedAt,
                'language'   => 'cs',
                'source_url' => $csSrcUrl,
            ], $dryRun);

            if ($ok) {
                echo "  + CS {$tag}\n";
                ++$totalInserted;
            } else {
                echo "  ! CS {$tag} insert failed\n";
                ++$totalErrors;
            }
        }
    }
}

echo "\nDone. Inserted: {$totalInserted} | Skipped: {$totalSkipped} | Errors: {$totalErrors}\n";
