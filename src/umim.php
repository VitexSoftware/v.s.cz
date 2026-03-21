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
 * @copyright  2012 Vitex@hippy.cz (G)
 */

// if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
//    header('Location: https://www.vitexsoftware.cz/');
//    exit;
// }

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Co umím')));

$pageCols = $oPage->container->addItem(new \Ease\TWB5\Row());

$oPage->column1 = $pageCols->addColumn(4);
$oPage->column2 = $pageCols->addColumn(4);
$oPage->column3 = $pageCols->addColumn(4);

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

$oPage->column2->addItem(new \Ease\Html\ATag('https://wakatime.com/@5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7', new \Ease\Html\ImgTag('https://wakatime.com/badge/user/5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7.svg')));

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Bezpečnostní audity')));
$serverSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart('Test vašich počítačů na známé zranitelnosti');
$serverSkills->addItemSmart('Zabezpečení webových aplikací');
$serverSkills->addItemSmart('Zabezpečení serverů');

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
