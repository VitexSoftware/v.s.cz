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

class NewsListing extends \Ease\Container
{
    public function __construct($datasource, $authorId = null, $language = null)
    {
        parent::__construct();

        $news = $datasource->listingQuery()->orderBy('DatCreate DESC, id DESC');

        if (null !== $authorId) {
            $news->where('author.id', $authorId);
        }

        if (null !== $language) {
            $news->where('language', $language);
        }

        $articles = $news->fetchAll();

        if (\count($articles)) {
            foreach ($articles as $article) {
                $this->addItem($this->renderCard($article));
            }
        } else {
            $this->addItem(new \Ease\TWB5\Alert('info', _('No articles')));
        }
    }

    private function excerpt(string $html, int $maxLen = 260): string
    {
        $text = html_entity_decode(strip_tags($html), \ENT_QUOTES | \ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', trim($text));

        return mb_strlen($text) > $maxLen ? mb_substr($text, 0, $maxLen).'…' : $text;
    }

    private function renderCard(array $article): string
    {
        $id      = (int) $article['id'];
        $title   = htmlspecialchars($article['title'], \ENT_QUOTES, 'UTF-8');
        $excerpt = htmlspecialchars($this->excerpt($article['text']), \ENT_QUOTES, 'UTF-8');
        $author  = htmlspecialchars($article['login'] ?? '', \ENT_QUOTES, 'UTF-8');
        $lang    = htmlspecialchars(strtoupper($article['language'] ?? ''), \ENT_QUOTES, 'UTF-8');

        $rawDate = $article['DatCreate'] ?? '';
        if (!$rawDate || str_starts_with($rawDate, '0000')) {
            $rawDate = $article['DatSave'] ?? '';
        }
        $ts   = ($rawDate && !str_starts_with($rawDate, '0000')) ? strtotime($rawDate) : false;
        $date = ($ts !== false && $ts > 0) ? date('j M Y', $ts) : '';
        $url     = 'article.php?id='.$id;
        $readMore = _('Read more');

        $langBadge = $lang
            ? '<span class="badge rounded-pill bg-secondary ms-2 fw-normal" style="font-size:.7rem">'.$lang.'</span>'
            : '';

        $meta = $author
            ? '<span class="me-3"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4"/></svg>'.$author.'</span>'
            : '';

        return <<<HTML
<article class="blog-card mb-4">
  <div class="card border-0 shadow-sm h-100">
    <div class="card-body pb-2">
      <div class="d-flex align-items-start justify-content-between mb-2">
        <h2 class="card-title h5 mb-0 lh-sm">
          <a href="{$url}" class="text-decoration-none blog-title-link">{$title}</a>
        </h2>
        {$langBadge}
      </div>
      <p class="card-text text-muted small mb-3">{$excerpt}</p>
    </div>
    <div class="card-footer bg-transparent border-top-0 d-flex justify-content-between align-items-center pt-0">
      <small class="text-muted">
        {$meta}<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/></svg>{$date}
      </small>
      <a href="{$url}" class="btn btn-sm btn-outline-primary">{$readMore} &rarr;</a>
    </div>
  </div>
</article>
HTML;
    }
}
