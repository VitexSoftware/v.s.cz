<?php

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

$oPage->addItem(new \VSCZ\ui\PageTop(_('Vitex Software')));
$oPage->AddPageColumns();

$oPage->heroUnit = $oPage->container->addItem(new \Ease\Html\Div(
    null, array('class' => 'jumbotron', 'id' => 'HeroUnit')));


$oPage->heroUnit->addItem('Linux Guru ');
$oPage->heroUnit->addItem('<img src="img/debian-logo.png">');
$oPage->heroUnit->addItem('<img src="img/redhat-logo.png">');
$oPage->heroUnit->addItem('<img src="img/fedora-logo.png">');
$oPage->heroUnit->addItem('<img src="img/centos-logo.png">');
$oPage->heroUnit->addItem('<img src="img/ubuntu-logo.png">');
$oPage->heroUnit->addItem(' řeší vaše problémy');

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Správa serverů')));

$serverSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart('Administrace');
$serverSkills->addItemSmart('Vzdálený dohled');
$serverSkills->addItemSmart('Virtualizace XEN,VMWare,VirtualBox,HyperV');
$serverSkills->addItemSmart('Instalace OS dle potřeb zákazníka');
$serverSkills->addItemSmart('Poradenství');

$oPage->column2->addItem(new \Ease\Html\H2Tag(_('Správa sítě')));

$NetworkSkills = $oPage->column2->addItem(new \Ease\Html\UlTag());
$NetworkSkills->addItemSmart('stavba metalických a bezdrátových sítí');
$NetworkSkills->addItemSmart('tunelování, routovaní');
$NetworkSkills->addItemSmart('Sledování stavu sítě');


$oPage->column3->addItem(new \Ease\Html\H2Tag(_('Vývoj aplikací')));
$DevelSkills = $oPage->column3->addItem(new \Ease\Html\UlTag());
$DevelSkills->addItemSmart('Webové aplikace LAMP');
$DevelSkills->addItemSmart('Mobilní webové aplikace ');
$DevelSkills->addItemSmart('Aplikace pro platformy Android / FirefoxOS');

$oPage->column3->addItem(new \Ease\Html\H2Tag(_('Servis aplikací')));
$UpdateSkills = $oPage->column3->addItem(new \Ease\Html\UlTag());
$UpdateSkills->addItemSmart('Aktualizace na PHP5 ze starších verzí jazyka');
$UpdateSkills->addItemSmart('Převod ze starých znakových sad do UTF8');
$UpdateSkills->addItemSmart('Převod dat mezi databázemi MySQL, Postgres, MSSQL');
$UpdateSkills->addItemSmart('úprava pro mobilní použití');

$oPage->column2->addItem('<div style="text-align: center;"><img src="img/tux-server.png"></div>');


$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Bezpečnostní audity')));
$serverSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart('Test vašich počítačů na známé zranitelnosti');
$serverSkills->addItemSmart('Zabezpečení webových aplikací');
$serverSkills->addItemSmart('Zabezpečení serverů');


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

