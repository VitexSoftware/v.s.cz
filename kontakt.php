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
 * VitexSoftware - kontakty.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop('Vitex Software - '._('contacts')));
$pageCols = $oPage->container->addItem(new \Ease\TWB4\Row());

$oPage->column1 = $pageCols->addColumn(4);
$oPage->column2 = $pageCols->addColumn(4);
$oPage->column3 = $pageCols->addColumn(4);

$oPage->column3->addItem(new \Ease\Html\H1Tag(_('Vítězslav Dvořák')));

// $oPage->column2->addItem(new \Ease\Html\H1Tag(_('Contacts')));

$NetworkSkills = $oPage->column2->addItem(new \Ease\Html\UlTag());
$NetworkSkills->addItemSmart(new \Ease\Html\ATag('mailto:info@vitexsoftware.cz', 'info@vitexsoftware.cz'));
$NetworkSkills->addItemSmart(new \Ease\Html\ATag('callto:+420739778202', 'T-Mobile: (+420) 739  778 202'));

// https://outlook.office365.com/owa/calendar/SoftwaredevelopmentServeradministration@spojenet.cz/bookings/

$oPage->column1->addItem(new \Ease\Html\H1Tag(_('Vitex Software')));
$DevelSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$DevelSkills->addItemSmart('IČO: 69438676');
$DevelSkills->addItemSmart('DIČ: CZ7808072811');

$DevelSkills->addItemSmart('Bankovní spojení: 2800677051 / 2010');
$DevelSkills->addItemSmart('IBAN: CZ9520100000002800677051');

$oPage->column2->addItem(new \Ease\Html\ImgTag(
    'img/vitexlovetux.jpg',
    'Vitex',
    ['width' => 250],
));

// $oPage->column1->addItem(new \Ease\Html\H4Tag(_('Bitcoins accepted')));
// $oPage->column1->addItem('<a href="bitcoin:1CiBn9CT99amr8VoasYqKznwyfo36HKZLB?label=VitexSoftware"><pre>1Au9b6pkd5eqAP3pprjJRkFduyS9uhFE8m</pre></a>');
// $oPage->column1->addItem(new \Ease\Html\ImgTag('img/donatebitcoins.png'));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
