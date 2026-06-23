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

$oPage->addItem(new ui\PageTop(_('Articles')));

// Inject blog styles directly — addCss/includeCSS don't reach <head> in this framework version
$oPage->container->addItem('<style>
.blog-header{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 60%,#0f3460 100%);padding:3rem 0 2.5rem;margin:-12px -12px 2rem;border-bottom:3px solid #0d6efd}
.blog-header h1{font-size:2.4rem;font-weight:700;letter-spacing:-.5px;color:#fff;margin:0 0 .5rem}
.blog-header p{color:rgba(255,255,255,.65);font-size:1.05rem;margin:0}
.blog-header .inner{padding:0 12px}
.blog-title-link{color:#1a1a2e;text-decoration:none;transition:color .15s}
.blog-title-link:hover{color:#0d6efd}
.blog-card .card{transition:box-shadow .2s,transform .2s}
.blog-card .card:hover{box-shadow:0 .5rem 1.5rem rgba(0,0,0,.12)!important;transform:translateY(-2px)}
</style>');

// Full-width blog header inside container-fluid
$oPage->container->addItem(new \Ease\Html\DivTag(
    new \Ease\Html\DivTag([
        new \Ease\Html\H1Tag(_('Articles')),
        new \Ease\Html\PTag(_('Notes, releases and thoughts from Vitex Software')),
    ], ['class' => 'inner']),
    ['class' => 'blog-header'],
));

try {
    $listing = new ui\NewsListing(new News());
    $oPage->container->addItem(
        new \Ease\Html\DivTag(
            $listing,
            ['class' => 'row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4'],
        ),
    );
} catch (\Throwable $e) {
    $oPage->container->addItem(new \Ease\TWB5\Alert(
        _('Articles temporarily unavailable.'),
        'warning',
    ));
}

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
