<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
//if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
//    header('Location: https://www.vitexsoftware.cz/');
//    exit;
//}

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Vitex Software')));
$oPage->addPageColumns();


$mainPageMenu = new ui\MainPageMenu();
//$mainPageMenu->addMenuItem('img/deb-package.png', _('Repozitář'), 'repos.php',
//    _('Repozitář balíčků pro Debian & Ubuntu'));

$mainPageMenu->addMenuItem('img/ease-framework-logo.png', _('EaseFramework'),
    'ease.php', _('Framework pro snadné psaní PHP aplikací'),
    new \Ease\TWB\Label('info', \Ease\Atom::$frameworkVersion));


if (file_exists('/usr/share/icinga-editor/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/icinga-editor/composer.json'));
    $version      = $composerInfo->version;
} else {
    $version = 'n/a';
}


$mainPageMenu->addMenuItem('img/icinga_editor-logo.png', _('Icinga Editor'),
    '/icinga-editor', _('Editor Konfigurace monitoringu'),
    new \Ease\TWB\Label('info', $version));


$mainPageMenu->addMenuItem('img/flexipeehp-logo.png', _('FlexiPeeHP'),
    _('https://github.com/Spoje-NET/FlexiPeeHP'),
    _('PHP Knihovna pro komunikaci s FlexiBee'),
    new \Ease\TWB\Label('info',
    \FlexiPeeHP\FlexiBeeRO::$libVersion.' (FlexiBee '.\FlexiPeeHP\EvidenceList::$version.')'));

if (file_exists('/usr/share/flexplorer/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexplorer/composer.json'));
    $version      = $composerInfo->version;
}


$mainPageMenu->addMenuItem('img/flexplorer-logo.png', _('Flexplorer'),
    '/flexplorer/', _('Vývojářský nástroj pro FlexiBee REST API'),
    new \Ease\TWB\Label('info', $version));
//$mainPageMenu->addMenuItem('img/flexihubee-logo.png', _('FlexiHUBee'),
//    'https://www.vitexsoftware.cz/redmine/projects/flexihubee',
//    _('Webová aplikace pro vzájemnou synchronizaci FlexiBee serverů (zatím neveřejné)'));


if (file_exists('/usr/share/flexiproxy/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexiproxy/composer.json'));
    $version      = $composerInfo->version;
}

$mainPageMenu->addMenuItem('img/flexiproxy-logo.png', _('FlexiProxy'),
    'http://flexiproxy.vitexsoftware.cz/c/demo', _('FlexiBee modifikátor'),
    new \Ease\TWB\Label('info', $version));

if (file_exists('/usr/share/shop4flexibee/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/shop4flexibee/composer.json'));
    $version      = $composerInfo->version;
}

$mainPageMenu->addMenuItem('img/shop4flexibee-logo.svg', _('Shop4FlexiBee'),
    'http://shop4flexibee.vitexsoftware.cz/', _('Shopping App for Flexibee'),
    new \Ease\TWB\Label('info', $version));

//$mainPageMenu->addMenuItem('img/tux-server.png', _('Hosting'), 'hosting.php',
//    _('Specializovaný hosting'));

$oPage->container->addItem($mainPageMenu);

$newsRow = new \Ease\TWB\Row();
$newsRow->addColumn(8,
    new \Ease\TWB\Well([new ui\NewsShow(new ui\News()), new \Ease\TWB\LinkButton('articles.php',
       '<img src="img/news.svg" style="height: 20px"> '._('More articles').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>',
        'info')]));
$newsRow->addColumn(4, new \Ease\TWB\Well(new ui\NewPackages()));

$oPage->container->addItem($newsRow);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

