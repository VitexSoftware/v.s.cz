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

$package = trim($oPage->getRequestValue('package', 'string'));

if (empty($package)) {
    header('Location: debs.php');
    exit;
}

$comp     = AppStream::get($package);
$iconUrl  = AppStream::iconUrl($package);
$vcsUrl   = AppStream::vcsBrowserUrl($package);

// Page title & OG tags
$pageTitle = $comp ? ($comp['Name']['C'] ?? $package) : $package;
$oPage->addItem(new ui\PageTop($pageTitle));

if ($iconUrl) {
    $oPage->head->addItem('<meta property="og:image" content="'.htmlspecialchars($iconUrl).'"/>');
} elseif (file_exists('img/deb/'.$package.'.png')) {
    $oPage->head->addItem('<meta property="og:image" content="img/deb/'.$package.'.png"/>');
}

$oPage->head->addItem('<meta property="og:title" content="'.htmlspecialchars($pageTitle).'"/>');

if ($comp) {
    $summary = $comp['Summary']['C'] ?? '';
    $oPage->head->addItem('<meta property="og:description" content="'.htmlspecialchars(strip_tags($summary)).'"/>');
}

$container = new \Ease\TWB5\Container();

// ── Hero header ──────────────────────────────────────────────────────────────
if ($comp) {
    $hero = new \Ease\TWB5\Row();
    $hero->addTagClass('align-items-center mb-4 mt-2');

    // Icon column
    if ($iconUrl) {
        $hero->addColumn(
            1,
            '<img src="'.htmlspecialchars($iconUrl).'" alt="'.htmlspecialchars($pageTitle).'"'
            .' style="width:96px;height:96px;object-fit:contain;">',
        );
    }

    // Title + summary + badges column
    $titleCol = new \Ease\Html\DivTag();
    $titleCol->addItem(new \Ease\Html\H1Tag($pageTitle));

    $summary = $comp['Summary']['C'] ?? '';

    if ($summary) {
        $titleCol->addItem(new \Ease\Html\PTag($summary, ['class' => 'lead']));
    }

    // Type badge
    $type = $comp['Type'] ?? '';

    if ($type) {
        $titleCol->addItem(new \Ease\Html\SpanTag(
            htmlspecialchars(str_replace('-', ' ', $type)),
            ['class' => 'badge bg-secondary me-1'],
        ));
    }

    // Category badges
    foreach ($comp['Categories'] ?? [] as $cat) {
        $titleCol->addItem(new \Ease\Html\SpanTag(
            htmlspecialchars($cat),
            ['class' => 'badge bg-primary me-1'],
        ));
    }

    $hero->addColumn($iconUrl ? 11 : 12, $titleCol);
    $container->addItem($hero);

    // ── Install command ───────────────────────────────────────────────────────
    $container->addItem(new \Ease\TWB5\Card(
        '<h5>'._('Install').'</h5>'
        .'<div class="input-group mb-2">'
        .'<code class="form-control bg-dark text-light" id="install-cmd">'
        .'apt install '.htmlspecialchars($package)
        .'</code>'
        .'<button class="btn btn-outline-secondary" type="button" '
        .'onclick="navigator.clipboard.writeText(\'apt install '.htmlspecialchars($package).'\')">📋</button>'
        .'</div>',
    ));

    // ── Description ──────────────────────────────────────────────────────────
    $description = $comp['Description']['C'] ?? '';

    if ($description) {
        $container->addItem(new \Ease\TWB5\Card(
            '<h5>'._('Description').'</h5>'.$description,
        ));
    }

    // ── Links ─────────────────────────────────────────────────────────────────
    $links = new \Ease\Html\DivTag(null, ['class' => 'mb-3 d-flex flex-wrap gap-2']);
    $urls  = $comp['Url'] ?? [];

    if (!empty($urls['homepage'])) {
        $links->addItem(new \Ease\Html\ATag(
            $urls['homepage'],
            '🌐 '._('Homepage'),
            ['class' => 'btn btn-outline-primary btn-sm', 'target' => '_blank'],
        ));
    }

    $vcsUrl = $vcsUrl ?? ($urls['vcs-browser'] ?? null);

    if ($vcsUrl) {
        $links->addItem(new \Ease\Html\ATag(
            $vcsUrl,
            '📦 GitHub',
            ['class' => 'btn btn-outline-dark btn-sm', 'target' => '_blank'],
        ));
    }

    if (!empty($urls['bugtracker'])) {
        $links->addItem(new \Ease\Html\ATag(
            $urls['bugtracker'],
            '🐛 '._('Issues'),
            ['class' => 'btn btn-outline-danger btn-sm', 'target' => '_blank'],
        ));
    }

    $links->addItem(new \Ease\Html\ATag(
        'package.php?package='.urlencode($package),
        '📋 '._('Package details'),
        ['class' => 'btn btn-outline-secondary btn-sm'],
    ));

    $container->addItem($links);

    // ── Screenshots ───────────────────────────────────────────────────────────
    $screenshots = $comp['Screenshots'] ?? [];

    if ($screenshots) {
        $mediaBase = AppStream::mediaBaseUrl();
        $gallery   = new \Ease\Html\DivTag(null, [
            'class' => 'd-flex flex-wrap gap-2 mb-4',
        ]);

        foreach ($screenshots as $ss) {
            // Pick the 752×455 thumbnail if available, else source-image
            $thumbUrl = null;

            foreach ($ss['thumbnails'] ?? [] as $t) {
                if (($t['width'] ?? 0) === 752) {
                    $thumbUrl = $mediaBase.'/'.$t['url'];

                    break;
                }
            }

            if (!$thumbUrl && isset($ss['source-image']['url'])) {
                $thumbUrl = $mediaBase.'/'.$ss['source-image']['url'];
            }

            if ($thumbUrl) {
                $gallery->addItem(
                    '<img src="'.htmlspecialchars($thumbUrl).'"'
                    .' class="img-thumbnail" style="max-width:400px;" alt="screenshot">',
                );
            }
        }

        $container->addItem($gallery);
    }
}

// ── Tabs: README + package info ───────────────────────────────────────────────
$tabItems = [];

// README tab — prefer vcs-browser, fall back to AppStream homepage, then DB
$readmeUrl = $vcsUrl ?? ($comp['Url']['homepage'] ?? null);

if (!$readmeUrl) {
    try {
        $pkgObj = new Packages($package);
        $props  = $pkgObj->getData();

        if ($props && str_contains((string) ($props['Homepage'] ?? ''), 'github.com')) {
            $readmeUrl = $props['Homepage'];
        }
    } catch (\Throwable $e) {
        // DB unavailable — skip README URL detection
    }
}

if ($readmeUrl && str_contains($readmeUrl, 'github.com')) {
    $tabItems[_('README')] = new ui\HtmlMarkdownReadme($readmeUrl, '');
}

try {
    $tabItems[_('Package info')] = new ui\PackageInfo(urlencode($package));
} catch (\Throwable $e) {
    $tabItems[_('Package info')] = new \Ease\Html\DivTag(
        _('Package database temporarily unavailable.'),
        ['class' => 'alert alert-warning'],
    );
}

$tabs = new \Ease\TWB5\Tabs($tabItems, ['id' => 'debtabs']);
$container->addItem($tabs);

$oPage->addItem($container);
$oPage->addItem(new ui\PageBottom());
$oPage->draw();
