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

class NewsShow extends \Ease\Container
{
    public function __construct($datasource, $id = null, $authorId = null)
    {
        parent::__construct();
        $news = $datasource->listingQuery();

        if (null !== $authorId) {
            $news->where('author.id', $authorId);
        }

        if (null !== $id) {
            $news->where('news.id', $id);
        }

        $articles = $news->fetchAll();

        if (\count($articles)) {
            foreach ($articles as $article) {
                $this->addItem($this->renderArticle($article));
            }
        } else {
            $this->addItem(new \Ease\TWB5\Alert(_('No articles'), 'warning'));
        }
    }

    private function resolveDate(array $article): string
    {
        foreach (['DatCreate', 'DatSave'] as $col) {
            $raw = $article[$col] ?? '';

            if ($raw && !str_starts_with($raw, '0000')) {
                $ts = strtotime($raw);

                if ($ts !== false && $ts > 0) {
                    return date('j M Y', $ts);
                }
            }
        }

        return '';
    }

    private function renderArticle(array $article): string
    {
        $title  = htmlspecialchars($article['title'], \ENT_QUOTES, 'UTF-8');
        $author = htmlspecialchars($article['login'] ?? '', \ENT_QUOTES, 'UTF-8');
        $lang   = htmlspecialchars(strtoupper($article['language'] ?? ''), \ENT_QUOTES, 'UTF-8');
        $date   = $this->resolveDate($article);
        $body   = $article['text'];

        $langBadge = $lang
            ? '<span class="badge rounded-pill bg-secondary fw-normal ms-2" style="font-size:.75rem">'.$lang.'</span>'
            : '';

        $authorHtml = $author
            ? '<span class="me-3"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4"/></svg>'.$author.'</span>'
            : '';

        $dateHtml = $date
            ? '<span><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>'.$date.'</span>'
            : '';

        return <<<HTML
<div class="article-header blog-header">
  <div class="container">
    <div class="d-flex align-items-start gap-2 flex-wrap mb-2">
      <h1 class="mb-0 lh-sm">{$title}</h1>
      {$langBadge}
    </div>
    <div class="article-meta text-white-50 small">{$authorHtml}{$dateHtml}</div>
  </div>
</div>
<div class="article-body py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-9 col-xl-8 article-content">
        {$body}
      </div>
    </div>
  </div>
</div>
HTML;
    }
}
