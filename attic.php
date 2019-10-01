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

$easeLib = $libMenu->addMenuItem('img/ease-framework-logo.png', _('EasePHP'),
    'ease.php', _('Framework for easy writing of PHP applications'),
    new \Ease\TWB4\Label('info', \Ease\Atom::$frameworkVersion).new ui\PackagistBadge('VitexSoftware/EaseFramework',
        'vitexsoftware/ease-framework'));


$libMenu->addMenuItem('img/ease-bricks-logo.png', _('EaseBricks'),
    'https://github.com/VitexSoftware/Ease-PHP-Bricks',
    _('Common Widgets for EasePHP Framework'),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('VitexSoftware/Ease-PHP-Bricks',
        'vitexsoftware/ease-bricks'));


if (file_exists('/usr/share/icinga-editor/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/icinga-editor/composer.json'));
    $version      = $composerInfo->version;
} else {
    $version = 'n/a';
}


$appMenu->addMenuItem('img/icinga_editor-logo.png', _('Icinga Editor'),
    'http://monitoring.vitexsoftware.cz/', _('Editor Konfigurace monitoringu'),
    new \Ease\TWB4\Label('info', $version));


$libMenu->addMenuItem('img/flexipeehp-logo.png', _('FlexiPeeHP'),
    _('flexipeehp.php'), _('PHP Knihovna pro komunikaci s FlexiBee'),
    new \Ease\TWB4\Label('info',
        \FlexiPeeHP\FlexiBeeRO::$libVersion.' (FlexiBee '.\FlexiPeeHP\EvidenceList::$version.')').new ui\PackagistBadge('Spoje-NET/FlexiPeeHP',
        'spoje.net/flexipeehp'));

if (file_exists('/usr/share/flexplorer/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexplorer/composer.json'));
    $version      = $composerInfo->version;
}

$libMenu->addMenuItem('img/flexipeehp-bricks-logo.png', _('FlexiPeeHP Bricks'),
    _('https://github.com/VitexSoftware/FlexiPeeHP-Bricks'),
    _('Widgets & Code snipplets for FlexiPeeHP'),
    new \Ease\TWB4\Label('info', '0.2').new ui\PackagistBadge('VitexSoftware/FlexiPeeHP-Bricks',
        'vitexsoftware/flexipeehp-bricks'));


$appMenu->addMenuItem('img/flexplorer-logo.png', _('Flexplorer'),
    '/flexplorer/', _('Vývojářský nástroj pro FlexiBee REST API'),
    new \Ease\TWB4\Label('info', $version));
//$mainPageMenu->addMenuItem('img/flexihubee-logo.png', _('FlexiHUBee'),
//    'https://www.vitexsoftware.cz/redmine/projects/flexihubee',
//    _('Webová aplikace pro vzájemnou synchronizaci FlexiBee serverů (zatím neveřejné)'));


if (file_exists('/usr/share/flexiproxy/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexiproxy/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem('img/flexiproxy-logo.png', _('FlexiProxy'),
    'https://flexiproxy.vitexsoftware.cz/c/demo', _('FlexiBee modifikátor'),
    new \Ease\TWB4\Label('info', $version));

if (file_exists('/usr/share/shop4flexibee/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/shop4flexibee/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem('img/shop4flexibee-logo.svg', _('FlexiBee ClientZone'),
    'https://clientzone.vitexsoftware.cz/clientzone/login.php?email=demo@vitexsoftware.cz&password=demo',
    _('ClientZone App for FlexiBee'), new \Ease\TWB4\Label('info', $version));

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

$libMenu->addMenuItem('img/deb/php-datamolino.png', _('Datamolino'),
    'https://github.com/VitexSoftware/phplib-datamolino',
    _('Library for interaction with Datamolino API'),
    new \Ease\TWB4\Label('info', '0.1').new ui\PackagistBadge('VitexSoftware/php-datamolino',
        'vitexsoftware/datamolino'));


$oPage->container->addItem(new \Ease\Html\H1Tag(_('Applications')));

$oPage->container->addItem($appMenu);

$oPage->container->addItem(new \Ease\Html\H1Tag(_('Libraries')));

$oPage->container->addItem($libMenu);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

