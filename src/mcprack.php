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

// ── SEO / Open Graph ────────────────────────────────────────────────────────
$ogTitle = _('MCPRack — MCP Self-Service Server Catalog & Config Generator');
$ogDesc = _('Centralizovaná správa a distribuce konfigurací MCP serverů pro Claude Desktop, GitHub Copilot a další MCP klienty. Katalog, self-service výběr, bezpečné credentials ve Vaultwardenu.');
$oPage->head->addItem('<meta name="description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta property="og:type" content="website">');
$oPage->head->addItem('<meta property="og:title" content="'.htmlspecialchars($ogTitle).'">');
$oPage->head->addItem('<meta property="og:description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta property="og:url" content="https://vitexsoftware.com/mcprack.php">');
$oPage->head->addItem('<meta property="og:image" content="https://vitexsoftware.com/img/mcprack-social-preview.png">');
$oPage->head->addItem('<meta name="twitter:card" content="summary_large_image">');
$oPage->head->addItem('<meta name="twitter:title" content="'.htmlspecialchars($ogTitle).'">');
$oPage->head->addItem('<meta name="twitter:description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta name="twitter:image" content="https://vitexsoftware.com/img/mcprack-social-preview.png">');

$oPage->addItem(new ui\PageTop(_('MCPRack — Vitex Software')));

// ── HERO ─────────────────────────────────────────────────────────────────────
$hero = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center py-5']));
$hero->addItem(new \Ease\Html\ImgTag('img/mcprack.svg', 'MCPRack', ['style' => 'height: 90px', 'class' => 'mb-3']));
$hero->addItem(new \Ease\Html\H1Tag(_('MCPRack')));
$hero->addItem(new \Ease\Html\PTag(
    _('MCP Self-Service Server Catalog & Config Generator'),
    ['class' => 'lead'],
));
$hero->addItem(new \Ease\Html\PTag(
    _('Bezpečně naservírujte AI klientům (Claude Desktop, GitHub Copilot, další MCP nástroje) přístup ke všem backendovým službám — bez tvrdě zadrátovaných secretů a bez ruční konfigurace na každém stroji.'),
    ['class' => 'text-muted'],
));
$hero->addItem(new \Ease\Html\DivTag([
    new \Ease\TWB5\LinkButton('https://mcprack.vitexsoftware.com/login?username=demo&password=demo', '▶ '._('Vyzkoušet živé demo'), 'primary', ['class' => 'btn-lg mt-2 me-2']),
    new \Ease\TWB5\LinkButton('https://github.com/VitexSoftware/mcprack', '↗ '._('Zobrazit na GitHubu'), 'outline-secondary', ['class' => 'btn-lg mt-2']),
]));

$oPage->container->addItem(new \Ease\Html\DivTag(
    new \Ease\Html\ImgTag('img/mcprack-catalog-screenshot.png', _('MCPRack — katalog MCP serverů'), ['class' => 'img-fluid rounded shadow-sm', 'style' => 'max-width: 720px;']),
    ['class' => 'text-center mb-5'],
));

// ── CO TO UMÍ ────────────────────────────────────────────────────────────────
$oPage->container->addItem(new \Ease\Html\H2Tag(_('Co to umí'), ['class' => 'text-center mt-4']));

$schopnosti = [
    [
        'ico' => 'fa-user-shield',
        'nadpis' => _('Admin UI'),
        'body' => [
            _('Registrace MCP serverů, proměnné prostředí a výchozí hodnoty'),
            _('Secrety uloženy ve Vaultwardenu, ne v databázi'),
        ],
    ],
    [
        'ico' => 'fa-list-check',
        'nadpis' => _('Katalog pro uživatele'),
        'body' => [
            _('Procházení dostupných serverů'),
            _('Self-service výběr podle potřeby, volba cílového klienta'),
        ],
    ],
    [
        'ico' => 'fa-gears',
        'nadpis' => _('Generátor konfigurace'),
        'body' => [
            _('Automatické sestavení .json/.env konfigurace na míru uživateli'),
            _('Podpora Claude Desktop, GitHub Copilot a dalších MCP klientů'),
        ],
    ],
    [
        'ico' => 'fa-network-wired',
        'nadpis' => _('HTTP proxy'),
        'body' => [
            _('Každý stdio MCP server je defaultně dostupný přes HTTP'),
            _('Žádná nutnost lokálního spouštění ani samostatné proxy služby'),
        ],
    ],
];

$schopnostiRow = $oPage->container->addItem(new \Ease\TWB5\Row(null, 0, ['class' => 'g-3 mt-1']));

foreach ($schopnosti as $s) {
    $telo = new \Ease\Html\DivTag(null, ['class' => 'card-body']);
    $telo->addItem(new \Ease\Html\DivTag(
        '<i class="fas '.$s['ico'].' fa-2x text-secondary"></i>',
        ['class' => 'text-center mb-2'],
    ));
    $telo->addItem(new \Ease\Html\H3Tag($s['nadpis'], ['class' => 'h5 text-center']));
    $ul = $telo->addItem(new \Ease\Html\UlTag());

    foreach ($s['body'] as $li) {
        $ul->addItemSmart($li);
    }

    $col = $schopnostiRow->addColumn(6);
    $col->addTagClass('col-lg-3');
    $col->addItem(new \Ease\TWB5\Card($telo, ['class' => 'h-100 shadow-sm']));
}

// ── KLÍČOVÉ VLASTNOSTI ───────────────────────────────────────────────────────
$oPage->container->addItem(new \Ease\Html\H2Tag(_('Klíčové vlastnosti'), ['class' => 'text-center mt-5']));

$vlastnosti = [
    _('Secrety ve Vaultwardenu, ostatní konfigurace přímo v DB'),
    _('Uživatelský přepis credentials pro jakýkoli server'),
    _('Podpora více klientů (Claude Desktop, GitHub Copilot, …)'),
    _('Admin může za uživatele vygenerovat a předat konfiguraci'),
    _('Izolovaná proxy instance pro každou dvojici uživatel/server'),
    _('Funguje i bez Vaultwardenu (lokální šifrovaný fallback)'),
    _('Volitelná LDAP/AD autentizace'),
    _('JSON REST API /api/v1 pro skripty a CI'),
];
$badges = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center mb-3']));

foreach ($vlastnosti as $v) {
    $badges->addItem(new \Ease\Html\SpanTag($v, ['class' => 'badge text-bg-secondary fs-6 me-2 mb-2']));
}

// ── ZÁVĚREČNÉ CTA ────────────────────────────────────────────────────────────
$cta = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center py-5']));
$cta->addItem(new \Ease\Html\H2Tag(_('Chcete MCPRack nasadit u sebe?')));
$cta->addItem(new \Ease\Html\PTag(
    _('Balíček .deb, systemd hardening a ukázková konfigurace reverzní proxy jsou součástí instalace. Ozvěte se, pomůžeme s nasazením.'),
    ['class' => 'lead'],
));
$cta->addItem(new \Ease\TWB5\LinkButton('kontakt.php', _('Nezávazně poptat').' →', 'primary', ['class' => 'btn-lg']));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
