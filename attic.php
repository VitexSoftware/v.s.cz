<?php

namespace VSCZ;

/**
 * VitexSoftware - Old/Discontinued projects
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2019 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';


$oPage->addItem(new ui\PageTop(_('Vitex Software')));

$appMenu = new ui\MainPageMenu();
$libMenu = new ui\MainPageMenu();

//$mainPageMenu->addMenuItem('img/deb-package.png', _('Repozitář'), 'repos.php',
//    _('Repozitář balíčků pro Debian & Ubuntu'));



$libMenu->addLibraryItem('https://github.com/Spoje-NET/FlexiPeeHP', _('FlexiPeeHP'), _('FlexiBee client library'), 'img/flexipeehp-logo.png' );

$libMenu->addLibraryItem('https://github.com/vitexsoftware/ease-framework', _('EasePHP'), _('Framework for easy writing of PHP applications'),  'img/ease-framework-logo.png' );

$libMenu->addLibraryItem('https://github.com/VitexSoftware/phplib-datamolino', _('PHP Datamolino'), _('support for accounting scanner API'),'img/deb/php-datamolino.png');


$libMenu->addLibraryItem('https://github.com/VitexSoftware/Ease-PHP-Bricks', _('EaseBricks'), _('Common Widgets for EasePHP Framework'), 'img/ease-bricks-logo.png',);
    
    

$appMenu->addMenuItem('Icinga Editor','https://github.com/VitexSoftware/Icinga-Editor/',   'img/icinga_editor-logo.png' , _('Icinga 1x configuration Editor'));

if (file_exists('/usr/share/flexplorer/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexplorer/composer.json'));
    $version      = $composerInfo->version;
}

$libMenu->addMenuItem('img/flexipeehp-bricks-logo.png', _('FlexiPeeHP Bricks'),
    _('https://github.com/VitexSoftware/FlexiPeeHP-Bricks'),
    _('Widgets & Code snipplets for FlexiPeeHP'),
    new \Ease\TWB4\Label('info', '0.2').new ui\PackagistBadge('VitexSoftware/FlexiPeeHP-Bricks',
        'vitexsoftware/flexipeehp-bricks'));


$appMenu->addMenuItem( _('Flexplorer'),'/flexplorer/', 'img/flexplorer-logo.png',
     _('Developer for FlexiBee REST API'),
    _('Visit'));


if (file_exists('/usr/share/flexiproxy/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexiproxy/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem(_('FlexiProxy'), 'https://github.com/VitexSoftware/FlexiProxy','img/flexiproxy-logo.png',
     _('FlexiBee modifikátor'),_('Visit'));

if (file_exists('/usr/share/shop4flexibee/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/shop4flexibee/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem( _('FlexiBee ClientZone'),'https://clientzone.vitexsoftware.cz/clientzone/login.php?email=demo@vitexsoftware.cz&password=demo', 'img/shop4flexibee-logo.svg',
    
    _('ClientZone App for FlexiBee'), _('Visit'));

//$mainPageMenu->addMenuItem('img/tux-server.png', _('Hosting'), 'hosting.php',
//    _('Specializovaný hosting'));


$libMenu->addMenuItem('img/ipex-b2b-logo.png', _('IPEX B2B'),
    'https://github.com/Spoje-NET/ipex-b2b',
    _('Library for interaction with restapi.ipex.cz'),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('Spoje-NET/ipex-b2b',
        'spoje.net/ipexb2b'));

$libMenu->addMenuItem('img/php-subreg-logo.png', _('php-subreg'),
    'https://github.com/Spoje-NET/php-subreg',
    _('Easy interaction with subreg.cz'),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('Spoje-NET/php-subreg',
        'spoje.net/subreg'));

$libMenu->addMenuItem('img/ease-fuelux-logo.png', _('Ease FuelUX'),
    'https://github.com/VitexSoftware/ease-fuelux',
    _('FuelUX componets for EasePHP FrameWork '),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('VitexSoftware/ease-fuelux',
        'vitexsoftware/ease-fuelux'));

$libMenu->addMenuItem('img/php-primaerp-logo.png', _('PrimaERP'),
    'https://github.com/VitexSoftware/php-primaERP',
    _('Library for interaction with API primaerp.com'),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('VitexSoftware/php-primaERP',
        'vitexsoftware/primaerp'));




$oPage->container->addItem(new \Ease\Html\H1Tag(_('Applications')));

$oPage->container->addItem($appMenu);

$oPage->container->addItem(new \Ease\Html\H1Tag(_('Libraries')));

$oPage->container->addItem($libMenu);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

