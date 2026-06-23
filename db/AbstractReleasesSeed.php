<?php

declare(strict_types=1);

/**
 * Base class for per-project GitHub release import seeds.
 *
 * Subclasses only need to define REPO:
 *
 *   class MultifleximReleases extends AbstractReleasesSeed
 *   {
 *       protected const REPO = 'VitexSoftware/MultiFlexi';
 *   }
 *
 * Usage:
 *   vendor/bin/phinx seed:run -c phinx.php -s MultifleximReleases
 *   ANTHROPIC_API_KEY=sk-... vendor/bin/phinx seed:run -c phinx.php -s MultifleximReleases
 */

use League\CommonMark\GithubFlavoredMarkdownConverter;
use Phinx\Seed\AbstractSeed;

require_once __DIR__.'/../vendor/autoload.php';

abstract class AbstractReleasesSeed extends AbstractSeed
{
    protected const REPO          = '';
    protected const RELEASE_LIMIT = 20;

    private GithubFlavoredMarkdownConverter $converter;
    private string $apiKey;

    public function run(): void
    {
        if (!static::REPO) {
            $this->output->writeln('<error>REPO constant not defined in '.static::class.'</error>');

            return;
        }

        $this->converter = new GithubFlavoredMarkdownConverter([
            'html_input'         => 'allow',
            'allow_unsafe_links' => true,
        ]);

        $this->apiKey = (string) (getenv('ANTHROPIC_API_KEY') ?: '');

        if (!$this->apiKey) {
            $this->output->writeln('<comment>ANTHROPIC_API_KEY not set — CS articles will copy EN body.</comment>');
        }

        $repoPath = static::REPO;
        $repoName = (string) substr($repoPath, (int) strrpos($repoPath, '/') + 1);

        $this->output->writeln("<info>[{$repoPath}]</info>");

        $listJson = shell_exec(sprintf(
            'gh release list --repo %s --json tagName,publishedAt,isPrerelease --limit %d 2>/dev/null',
            escapeshellarg($repoPath),
            static::RELEASE_LIMIT,
        ));

        if (!$listJson) {
            $this->output->writeln('  No releases or error.');

            return;
        }

        $releases = json_decode($listJson, true);

        if (empty($releases)) {
            $this->output->writeln('  No releases.');

            return;
        }

        $inserted = 0;
        $skipped  = 0;
        $errors   = 0;

        foreach ($releases as $rel) {
            if ($rel['isPrerelease']) {
                continue;
            }

            $tag      = $rel['tagName'];
            $enSrcUrl = "https://github.com/{$repoPath}/releases/tag/{$tag}#en";
            $csSrcUrl = "https://github.com/{$repoPath}/releases/tag/{$tag}#cs";

            $enExists = $this->sourceExists($enSrcUrl);
            $csExists = $this->sourceExists($csSrcUrl);

            if ($enExists && $csExists) {
                $this->output->writeln("  SKIP {$tag} (already imported)");
                ++$skipped;

                continue;
            }

            $viewJson = shell_exec(sprintf(
                'gh release view %s --repo %s --json name,tagName,body,url,publishedAt 2>/dev/null',
                escapeshellarg($tag),
                escapeshellarg($repoPath),
            ));

            if (!$viewJson) {
                $this->output->writeln("  ERROR fetching {$tag}");
                ++$errors;

                continue;
            }

            $data        = json_decode($viewJson, true);
            $body        = $data['body'] ?? '';
            $githubUrl   = $data['url'] ?? "https://github.com/{$repoPath}/releases/tag/{$tag}";
            $publishedAt = substr($data['publishedAt'] ?? date('Y-m-d H:i:s'), 0, 19);
            $publishedAt = str_replace('T', ' ', $publishedAt);

            $logoUrl  = $this->resolveLogoUrl($repoName);
            $bodyHtml = $body ? $this->converter->convert($body)->getContent() : '';

            if (!$enExists) {
                $ok = $this->insertArticle([
                    'title'      => "{$repoName} {$tag} released",
                    'text'       => $this->buildHtml($repoName, $tag, $logoUrl, $bodyHtml, $githubUrl, 'View release on GitHub →'),
                    'DatCreate'  => $publishedAt,
                    'author'     => 0,
                    'language'   => 'en',
                    'source_url' => $enSrcUrl,
                ]);

                if ($ok) {
                    $this->output->writeln("  + EN {$tag}");
                    ++$inserted;
                } else {
                    ++$errors;
                }
            }

            if (!$csExists) {
                $csBody  = $this->translateToCs($body ?: $repoName.' '.$tag, 'body');
                $csTitle = $this->translateToCs("{$repoName} {$tag} released", 'title');
                $ok      = $this->insertArticle([
                    'title'      => $csTitle,
                    'text'       => $this->buildHtml(
                        $repoName,
                        $tag,
                        $logoUrl,
                        $body ? $this->converter->convert($csBody)->getContent() : '',
                        $githubUrl,
                        'Zobrazit vydání na GitHub →',
                    ),
                    'DatCreate'  => $publishedAt,
                    'author'     => 0,
                    'language'   => 'cs',
                    'source_url' => $csSrcUrl,
                ]);

                if ($ok) {
                    $this->output->writeln("  + CS {$tag}");
                    ++$inserted;
                } else {
                    ++$errors;
                }
            }
        }

        $this->output->writeln("Done. Inserted: {$inserted} | Skipped: {$skipped} | Errors: {$errors}");
    }

    private function sourceExists(string $url): bool
    {
        $rows = $this->fetchAll(
            'SELECT id FROM news WHERE source_url = '.
            $this->getAdapter()->getConnection()->quote($url).
            ' LIMIT 1',
        );

        return !empty($rows);
    }

    private function sanitize(string $text): string
    {
        // Strip 4-byte Unicode (emoji, etc.) — news table uses utf8mb3 charset
        return (string) preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $text);
    }

    private function insertArticle(array $data): bool
    {
        $data['title'] = $this->sanitize(mb_substr($data['title'], 0, 128));
        $data['text']  = $this->sanitize($data['text']);

        try {
            $this->table('news')->insert($data)->saveData();

            return true;
        } catch (\Throwable $e) {
            $this->output->writeln('  <error>INSERT failed: '.$e->getMessage().'</error>');

            return false;
        }
    }

    private function resolveLogoUrl(string $repoName): string
    {
        $base = __DIR__.'/../../src';

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

    private function buildHtml(
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

    private function translateToCs(string $text, string $context = 'body'): string
    {
        if (!$this->apiKey || !trim($text)) {
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
                'x-api-key: '.$this->apiKey,
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
}
