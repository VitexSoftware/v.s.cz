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

$oPage->addItem(new ui\PageTop(_('Article')));

$oPage->container->addItem('<style>
.blog-header{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%);padding:3rem 0 2.5rem;margin:-12px -12px 0;border-bottom:3px solid #0d6efd}
.blog-header h1{font-size:2.2rem;font-weight:700;color:#fff;margin:0}
.article-content img{max-width:100%;height:auto;border-radius:.375rem}
.article-content pre{background:#f8f9fa;padding:1rem;border-radius:.375rem;overflow-x:auto;font-size:.875rem}
.article-content code{background:#f8f9fa;padding:.1em .3em;border-radius:.2rem;font-size:.9em}
.article-content pre code{background:none;padding:0}
.article-content blockquote{border-left:4px solid #0d6efd;padding:.5rem 1rem;margin:1rem 0;color:#6c757d;background:#f8f9fa;border-radius:0 .375rem .375rem 0}
.article-content h2,.article-content h3{margin-top:2rem}
.article-content a{color:#0d6efd}
</style>');

$oPage->container->addItem(new ui\NewsShow(new News(), $oPage->getRequestValue('id', 'int')));

$oPage->container->addItem(
    new \Ease\Html\DivTag(
        new \Ease\TWB5\LinkButton(
            'articles.php',
            '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg> '._('Back to articles'),
            'outline-secondary',
        ),
        ['class' => 'container pb-4'],
    ),
);

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
