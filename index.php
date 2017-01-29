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
$oPage->AddPageColumns();


$mainPageMenu = new ui\MainPageMenu();
$mainPageMenu->addMenuItem('img/tux-server.png', _('Hosting'), 'hosting.php',
    _('Specializovaný hosting'));


$mainPageMenu->addMenuItem('img/ease-framework-logo.png',
    _('EaseFramework'),
    'ease.php', _('Framework pro snadné psaní PHP aplikací'));
$mainPageMenu->addMenuItem('img/icinga_editor-logo.png', _('Icinga Editor'),
    '/icinga-editor', _('Editor Konfigurace monitoringu'));
$mainPageMenu->addMenuItem('img/flexipeehp-logo.png', _('FlexiPeeHP'),
    _('https://github.com/Spoje-NET/FlexiPeeHP'),
    _('PHP Knihovna pro komunikaci s FlexiBee'));
$mainPageMenu->addMenuItem('img/flexplorer-logo.png', _('Flexplorer'),
    '/flexplorer/', _('Vývojářský nástroj pro FlexiBee REST API'));
//$mainPageMenu->addMenuItem('img/flexihubee-logo.png', _('FlexiHUBee'),
//    'https://www.vitexsoftware.cz/redmine/projects/flexihubee',
//    _('Webová aplikace pro vzájemnou synchronizaci FlexiBee serverů (zatím neveřejné)'));

$oPage->container->addItem($mainPageMenu);


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

