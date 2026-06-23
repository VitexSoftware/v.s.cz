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

/**
 * VitexSoftware - titulní strana.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2022 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';
$oPage->addItem(new ui\PageTop(_('Debian Repository')));
$repodir = 'repo';

// ── How to use card ───────────────────────────────────────────────────────────
$reposinfo = new \Ease\TWB5\Card(new \Ease\Html\H3Tag(_('How to use repository')));
$reposinfo->addItem(new \Ease\Html\EmTag(_('On current debian or ubuntu')));
$steps = $reposinfo->addItem(new \Ease\Html\UlTag(
    null,
    ['class' => 'list-group'],
));
$steps->addItemSmart(
    'echo "deb http://repo.vitexsoftware.com $(lsb_release -sc) main" | sudo tee /etc/apt/sources.list.d/vitexsoftware.list',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart(
    'sudo wget -O /etc/apt/trusted.gpg.d/vitexsoftware.gpg https://repo.vitexsoftware.com/KEY.gpg',
    ['class' => 'list-group-item'],
);
$steps->addItemSmart('sudo apt update', ['class' => 'list-group-item']);
$steps->addItemSmart(
    'sudo apt install <em>package(s)</em>',
    ['class' => 'list-group-item'],
);

// ── VitexSoftware projects card grid ─────────────────────────────────────────
$components = AppStream::all();
uasort($components, fn($a, $b) => strcasecmp(
    $a['Name']['C'] ?? $a['Package'] ?? '',
    $b['Name']['C'] ?? $b['Package'] ?? '',
));

$grid = new \Ease\Html\DivTag(null, ['class' => 'row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 mt-1']);

foreach ($components as $pkg => $comp) {
    $name    = $comp['Name']['C'] ?? $pkg;
    $summary = $comp['Summary']['C'] ?? '';
    $iconUrl = AppStream::iconUrl($pkg);

    $icon = $iconUrl
        ? '<img src="'.htmlspecialchars($iconUrl).'" alt="" style="width:48px;height:48px;object-fit:contain;" class="mb-2">'
        : '<img src="img/deb-package.png" alt="" style="width:48px;height:48px;object-fit:contain;" class="mb-2">';

    $card = '<div class="card h-100 text-decoration-none">'
        .'<a href="deb.php?package='.urlencode($pkg).'" class="text-decoration-none text-reset">'
        .'<div class="card-body d-flex flex-column align-items-start">'
        .$icon
        .'<h6 class="card-title mb-1">'.htmlspecialchars($name).'</h6>'
        .($summary ? '<p class="card-text small text-muted mb-0">'.htmlspecialchars($summary).'</p>' : '')
        .'</div>'
        .'<div class="card-footer">'
        .'<code class="small">'.htmlspecialchars($pkg).'</code>'
        .'</div>'
        .'</a>'
        .'</div>';

    $grid->addItem(new \Ease\Html\DivTag($card, ['class' => 'col']));
}

$pTabs = new \Ease\TWB5\Tabs([
    _('VitexSoftware') => $grid,
    _('All packages')  => new ui\Repositor($repodir),
    _('How to use')    => $reposinfo,
]);
$oPage->container->addItem($pTabs);
$oPage->addItem(new \VSCZ\ui\PageBottom());
$oPage->draw();
