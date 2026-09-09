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

require_once 'includes/VSInit.php';

$id = $oPage->getRequestValue('id', 'int');

// Fetch title/text/DatCreate directly (qualified columns -- News::listingQuery()
// left-joins user, so an unqualified 'id' condition would be ambiguous).
$articleRows = $id ? (new News())->getColumnsFromSQL(
    ['news.title', 'news.text', 'news.DatCreate'],
    ['news.id' => $id],
) : [];
$articleData = $articleRows[0] ?? null;

$pageTitle = $articleData['title'] ?? _('Article');
$ogUrl = 'https://vitexsoftware.com/article.php?id='.$id;
$ogDescription = $articleData ? trim(preg_replace('/\s+/', ' ', strip_tags((string) $articleData['text']))) : '';
$ogDescription = $ogDescription !== '' ? mb_substr($ogDescription, 0, 200) : '';
$ogImage = null;

if ($articleData && preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', (string) $articleData['text'], $imgMatch)) {
    $ogImage = str_starts_with($imgMatch[1], 'http') ? $imgMatch[1] : 'https://vitexsoftware.com/'.ltrim($imgMatch[1], '/');
} else {
    $ogImage = 'https://vitexsoftware.com/img/vitexsoftwarelogo.png';
}

$oPage->setPageTitle($pageTitle);

$oPage->head->addItem('<meta property="og:type" content="article">');
$oPage->head->addItem('<meta property="og:url" content="'.htmlspecialchars($ogUrl).'">');
$oPage->head->addItem('<meta property="og:title" content="'.htmlspecialchars($pageTitle).'">');
$oPage->head->addItem('<meta property="og:image" content="'.htmlspecialchars($ogImage).'">');

if ($ogDescription !== '') {
    $oPage->head->addItem('<meta property="og:description" content="'.htmlspecialchars($ogDescription).'">');
}

if (!empty($articleData['DatCreate']) && !str_starts_with((string) $articleData['DatCreate'], '0000')) {
    $publishedTime = date('c', strtotime((string) $articleData['DatCreate']));
    $oPage->head->addItem('<meta property="article:published_time" content="'.htmlspecialchars($publishedTime).'">');
}

$oPage->head->addItem('<meta name="twitter:card" content="summary'.($ogImage ? '_large_image' : '').'">');
$oPage->head->addItem('<meta name="twitter:title" content="'.htmlspecialchars($pageTitle).'">');

if ($ogDescription !== '') {
    $oPage->head->addItem('<meta name="twitter:description" content="'.htmlspecialchars($ogDescription).'">');
}

if ($ogImage) {
    $oPage->head->addItem('<meta name="twitter:image" content="'.htmlspecialchars($ogImage).'">');
}

$oPage->addItem(new ui\PageTop($pageTitle));

$oPage->container->addItem(<<<'EOD'
<style>
.blog-header{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%);padding:3rem 0 2.5rem;margin:-12px -12px 0;border-bottom:3px solid #0d6efd}
.blog-header h1{font-size:2.2rem;font-weight:700;color:#fff;margin:0}
.article-content img{max-width:100%;height:auto;border-radius:.375rem}
.article-content pre{background:#f8f9fa;padding:1rem;border-radius:.375rem;overflow-x:auto;font-size:.875rem}
.article-content code{background:#f8f9fa;padding:.1em .3em;border-radius:.2rem;font-size:.9em}
.article-content pre code{background:none;padding:0}
.article-content blockquote{border-left:4px solid #0d6efd;padding:.5rem 1rem;margin:1rem 0;color:#6c757d;background:#f8f9fa;border-radius:0 .375rem .375rem 0}
.article-content h2,.article-content h3{margin-top:2rem}
.article-content a{color:#0d6efd}
</style>
EOD);

$oPage->container->addItem(new ui\NewsShow(new News(), $id));

$footerButtons = new \Ease\Html\DivTag(null, ['class' => 'container pb-4 d-flex gap-2']);
$footerButtons->addItem(new \Ease\TWB5\LinkButton(
    'articles.php?locale='.rawurlencode(\Ease\Locale::singleton()->getLocaleUsed() ?? 'en_US'),
    '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg> '._('Back to articles'),
    'outline-secondary',
));

// Read-only admin check: pass an empty candidate class so an anonymous
// visitor with no session entry gets null back instead of Shared::user()
// trying to instantiate a nonexistent global "User" class.
$currentUser = \Ease\Shared::user(null, '');

if ($id && $currentUser && $currentUser->getSettingValue('admin')) {
    $footerButtons->addItem(new \Ease\TWB5\LinkButton(
        'newsedit.php?id='.$id,
        '<i class="fa fa-pencil me-1"></i> '._('Edit'),
        'outline-primary',
    ));
}

$oPage->container->addItem($footerButtons);

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
