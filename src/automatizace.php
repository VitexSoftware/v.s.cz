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

/*
 * ── CENÍK (uprav zde) ────────────────────────────────────────────────────────
 * Ceny bez DPH (VitexSoftware = neplátce → ceny jsou finální). CZK.
 */
$balicky = [
    [
        'nazev' => _('Start'),
        'pro' => _('vyzkoušet 1 automatizaci'),
        'setup' => '2 900',
        'mesic' => '290',
        'zvyraznit' => false,
        'featury' => [
            _('1 automatizace dle výběru'),
            _('hostování v ceně'),
            _('aktualizace nástroje'),
            _('podpora e-mailem'),
        ],
    ],
    [
        'nazev' => _('Provoz'),
        'pro' => _('běžná firma na AbraFlexi / Pohodě'),
        'setup' => '4 900',
        'mesic' => '690',
        'zvyraznit' => true,
        'featury' => [
            _('2–3 automatizace dle výběru'),
            _('hostování + monitoring'),
            _('automatické aktualizace'),
            _('přednostní podpora'),
        ],
    ],
    [
        'nazev' => _('Na klíč'),
        'pro' => _('složitější provoz a úpravy'),
        'setup' => _('od').' 9 900',
        'mesic' => _('od').' 1 490',
        'zvyraznit' => false,
        'featury' => [
            _('neomezeně automatizací'),
            _('úpravy na míru'),
            _('prioritní SLA + telefon'),
            _('měsíční report'),
        ],
    ],
];

// ── SEO / Open Graph (náhled při sdílení na sociálních sítích) ────────────────
$ogTitle = _('Automatizace účetnictví na klíč — VitexSoftware');
$ogDesc = _('Automatizace AbraFlexi i Pohody: import bankovních výpisů a párování plateb, přijaté faktury z e-mailu, rozesílání dokladů, digest stavu firmy. 78 hotových automatizací — nastavím a provozuji za vás.');
$oPage->head->addItem('<meta name="description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta property="og:type" content="website">');
$oPage->head->addItem('<meta property="og:title" content="'.htmlspecialchars($ogTitle).'">');
$oPage->head->addItem('<meta property="og:description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta property="og:url" content="https://vitexsoftware.cz/automatizace.php">');
$oPage->head->addItem('<meta property="og:image" content="https://vitexsoftware.cz/img/abra-flexibee.png">');
$oPage->head->addItem('<meta name="twitter:card" content="summary_large_image">');
$oPage->head->addItem('<meta name="twitter:title" content="'.htmlspecialchars($ogTitle).'">');
$oPage->head->addItem('<meta name="twitter:description" content="'.htmlspecialchars($ogDesc).'">');
$oPage->head->addItem('<meta name="twitter:image" content="https://vitexsoftware.cz/img/abra-flexibee.png">');

$oPage->addItem(new ui\PageTop(_('Automatizace na klíč — Vitex Software')));

// ── HERO ─────────────────────────────────────────────────────────────────────
$hero = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center py-5']));
$hero->addItem(new \Ease\Html\ImgTag('img/abraflexitools.svg', 'AbraFlexi automatizace', ['style' => 'height: 90px', 'class' => 'mb-3']));
$hero->addItem(new \Ease\Html\H1Tag(_('Automatizace účetnictví na klíč')));
$hero->addItem(new \Ease\Html\PTag(
    _('Přestaňte dělat ručně to, co zvládne stroj. Nastavím to a provozuji za vás — vy jen koukáte na výsledek.'),
    ['class' => 'lead'],
));
$hero->addItem(new \Ease\Html\PTag(
    '<strong>'._('78 hotových automatizací').'</strong> · '._('AbraFlexi i Pohoda').' · '._('hostováno na MultiFlexi'),
    ['class' => 'text-muted'],
));
$hero->addItem(new \Ease\TWB5\LinkButton('kontakt.php', _('Nezávazně poptat').' →', 'primary', ['class' => 'btn-lg mt-2']));

// ── SCHOPNOSTI ───────────────────────────────────────────────────────────────
$oPage->container->addItem(new \Ease\Html\H2Tag(_('Co to umí'), ['class' => 'text-center mt-4']));

$schopnosti = [
    [
        'ico' => 'fa-building-columns',
        'nadpis' => _('Banka → účetnictví'),
        'body' => [
            _('stažení výpisů: Fio, Raiffeisen, Česká spořitelna, Revolut'),
            _('import výpisů a transakcí do AbraFlexi i Pohody'),
            _('automatické párování plateb (VS, specifický symbol)'),
        ],
    ],
    [
        'ico' => 'fa-file-invoice',
        'nadpis' => _('AbraFlexi automatizace'),
        'body' => [
            _('digest stavu firmy (pohledávky, cashflow)'),
            _('import přijatých faktur z e-mailu'),
            _('rozesílání dokladů, opakovaná fakturace, upomínky'),
        ],
    ],
    [
        'ico' => 'fa-book',
        'nadpis' => _('Pohoda automatizace'),
        'body' => [
            _('digesty a přehledy stavu'),
            _('transakční reporty'),
            _('import bankovních výpisů'),
        ],
    ],
    [
        'ico' => 'fa-plug',
        'nadpis' => _('Další integrace'),
        'body' => [
            _('Office 365 / SharePoint'),
            _('Subreg, Discomp (ceníky, kredit)'),
            _('monitoring Zabbix, CRM Mailkit / Realpad'),
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

// ── PODPOROVANÉ SYSTÉMY ──────────────────────────────────────────────────────
$oPage->container->addItem(new \Ease\Html\H2Tag(_('Podporované systémy'), ['class' => 'text-center mt-5']));
$oPage->container->addItem(new \Ease\Html\PTag(
    _('Přístupy spravuje MultiFlexi bezpečně na jednom místě.'),
    ['class' => 'text-center text-muted'],
));
$systemy = [
    'AbraFlexi', 'Stormware Pohoda', 'Fio Bank', 'Raiffeisen Bank', 'IPEX', 'Subreg',
    'Discomp', 'Realpad', 'Office 365', 'SQL Server', _('databáze (PDO)'), _('SMTP mail'),
    'VaultWarden', '.env', 'Probe',
];
$badges = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center mb-3']));

foreach ($systemy as $sys) {
    $badges->addItem(new \Ease\Html\SpanTag($sys, ['class' => 'badge text-bg-secondary fs-6 me-2 mb-2']));
}

// ── CENÍK ────────────────────────────────────────────────────────────────────
$oPage->container->addItem(new \Ease\Html\H2Tag(_('Ceník'), ['class' => 'text-center mt-5']));
$oPage->container->addItem(new \Ease\Html\PTag(
    _('Roční platba předem = 2 měsíce provozu zdarma. Ceny jsou bez DPH (neplátce → finální).'),
    ['class' => 'text-center text-muted'],
));

$cenikRow = $oPage->container->addItem(new \Ease\TWB5\Row(null, 0, ['class' => 'g-3 justify-content-center']));

foreach ($balicky as $b) {
    $telo = new \Ease\Html\DivTag(null, ['class' => 'card-body text-center']);

    if ($b['zvyraznit']) {
        $telo->addItem(new \Ease\Html\SpanTag(_('nejoblíbenější'), ['class' => 'badge text-bg-warning mb-2']));
    }

    $telo->addItem(new \Ease\Html\H3Tag($b['nazev'], ['class' => 'h4']));
    $telo->addItem(new \Ease\Html\PTag($b['pro'], ['class' => 'text-muted small']));
    $telo->addItem(new \Ease\Html\DivTag(
        '<span class="display-6">'.$b['mesic'].' Kč</span><br><span class="text-muted">'._('měsíčně').'</span>',
        ['class' => 'my-2'],
    ));
    $telo->addItem(new \Ease\Html\PTag(
        _('nastavení').' <strong>'.$b['setup'].' Kč</strong> '._('jednorázově'),
    ));
    $ul = $telo->addItem(new \Ease\Html\UlTag(null, ['class' => 'list-unstyled']));

    foreach ($b['featury'] as $f) {
        $ul->addItem(new \Ease\Html\LiTag('<i class="fas fa-check text-success"></i> '.$f));
    }

    $telo->addItem(new \Ease\TWB5\LinkButton('kontakt.php', _('Mám zájem'), $b['zvyraznit'] ? 'primary' : 'outline-primary', ['class' => 'mt-2']));

    $col = $cenikRow->addColumn(12);
    $col->addTagClass('col-md-4');
    $col->addItem(new \Ease\TWB5\Card($telo, ['class' => 'h-100 shadow-sm'.($b['zvyraznit'] ? ' border-primary' : '')]));
}

// ── ZÁVĚREČNÉ CTA ────────────────────────────────────────────────────────────
$cta = $oPage->container->addItem(new \Ease\Html\DivTag(null, ['class' => 'text-center py-5']));
$cta->addItem(new \Ease\Html\H2Tag(_('Ušetřete si ruční práci')));
$cta->addItem(new \Ease\Html\PTag(
    _('Jedna automatizace obvykle ušetří víc hodin práce za měsíc, než stojí za rok. Ozvěte se, 15 minut vám to ukážu na vašich datech.'),
    ['class' => 'lead'],
));
$cta->addItem(new \Ease\TWB5\LinkButton('kontakt.php', _('Nezávazně poptat').' →', 'primary', ['class' => 'btn-lg']));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
