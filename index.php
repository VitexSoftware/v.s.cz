<?php

/**
 * VitexSoftware - titulní strana
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
    header('Location: https://www.vitexsoftware.cz/');
    exit;
}

require_once 'includes/VSInit.php';

$oPage->addItem(new VSPageTop(_('Vitex Software')));
$oPage->AddPageColumns();

$oPage->heroUnit->addItem('Linux Guru ');
$oPage->heroUnit->addItem('<img src="img/debian-logo.png">');
$oPage->heroUnit->addItem('<img src="img/redhat-logo.png">');
$oPage->heroUnit->addItem('<img src="img/fedora-logo.png">');
$oPage->heroUnit->addItem('<img src="img/centos-logo.png">');
$oPage->heroUnit->addItem('<img src="img/ubuntu-logo.png">');
$oPage->heroUnit->addItem(' řeší vaše problémy');

$oPage->column1->addItem(new EaseHtmlH2Tag(_('Správa serverů')));

$serverSkills = $oPage->column1->addItem(new EaseHtmlUlTag());
$serverSkills->addItemSmart('Administrace');
$serverSkills->addItemSmart('Vzdálený dohled');
$serverSkills->addItemSmart('Virtualizace XEN,VMWare,VirtualBox,HyperV');
$serverSkills->addItemSmart('Instalace OS dle potřeb zákazníka');
$serverSkills->addItemSmart('Poradenství');

$oPage->column2->addItem(new EaseHtmlH2Tag(_('Správa sítě')));

$NetworkSkills = $oPage->column2->addItem(new EaseHtmlUlTag());
$NetworkSkills->addItemSmart('stavba metalických a bezdrátových sítí');
$NetworkSkills->addItemSmart('tunelování, routovaní');
$NetworkSkills->addItemSmart('Sledování stavu sítě');


$oPage->column3->addItem(new EaseHtmlH2Tag(_('Vývoj aplikací')));
$DevelSkills = $oPage->column3->addItem(new EaseHtmlUlTag());
$DevelSkills->addItemSmart('Webové aplikace LAMP');
$DevelSkills->addItemSmart('Mobilní webové aplikace ');
$DevelSkills->addItemSmart('Aplikace pro platformy Android / FirefoxOS');

$oPage->column3->addItem(new EaseHtmlH2Tag(_('Servis aplikací')));
$UpdateSkills = $oPage->column3->addItem(new EaseHtmlUlTag());
$UpdateSkills->addItemSmart('Aktualizace na PHP5 ze starších verzí jazyka');
$UpdateSkills->addItemSmart('Převod ze starých znakových sad do UTF8');
$UpdateSkills->addItemSmart('Převod dat mezi databázemi MySQL, Postgres, MSSQL');
$UpdateSkills->addItemSmart('úprava pro mobilní použití');

$oPage->column2->addItem('<div style="text-align: center;"><img src="img/tux-server.png"></div>');


$oPage->column1->addItem(new EaseHtmlH2Tag(_('Bezpečnostní audity')));
$serverSkills = $oPage->column1->addItem(new EaseHtmlUlTag());
$serverSkills->addItemSmart('Test vašich počítačů na známé zranitelnosti');
$serverSkills->addItemSmart('Zabezpečení webových aplikací');
$serverSkills->addItemSmart('Zabezpečení serverů');


$oPage->addItem(new VSPageBottom());


$oPage->draw();

