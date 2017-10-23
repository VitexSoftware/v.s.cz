<?php

namespace VSCZ;

/**
 * VitexSoftware - kontakty
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop('Vitex Software - '._('contacts')));
$oPage->AddPageColumns();
$oPage->column3->addItem(new \Ease\Html\H1Tag(_('Vítězslav Dvořák')));



//$oPage->column2->addItem(new \Ease\Html\H1Tag(_('Contacts')));

$NetworkSkills = $oPage->column2->addItem(new \Ease\Html\UlTag());
$NetworkSkills->addItemSmart(new \Ease\Html\ATag('mailto:info@vitexsoftware.cz', 'info@vitexsoftware.cz'));
$NetworkSkills->addItemSmart(new \Ease\Html\ATag('callto:+420739778202', 'T-Mobile: (+420) 739  778 202'));

$oPage->column1->addItem(new \Ease\Html\H1Tag(_('Vitex Software')));
$DevelSkills = $oPage->column1->addItem(new \Ease\Html\UlTag());
$DevelSkills->addItemSmart('IČO: 69438676');
$DevelSkills->addItemSmart('DIČ: CZ7808072811');

$DevelSkills->addItemSmart('Bankovní spojení: 2800677051 / 2010');
$DevelSkills->addItemSmart('IBAN: CZ9520100000002800677051');

$oPage->column2->addItem(new \Ease\Html\ImgTag('img/vitexlovetux.jpg', 'Vitex',
    ['width' => 250]));

$oPage->column1->addItem(new \Ease\Html\H4Tag(_('Bitcoins accepted')));
$oPage->column1->addItem('<a href="bitcoin:1CiBn9CT99amr8VoasYqKznwyfo36HKZLB?label=VitexSoftware"><pre>1Au9b6pkd5eqAP3pprjJRkFduyS9uhFE8m</pre></a>');
$oPage->column1->addItem(new \Ease\Html\ImgTag('img/donatebitcoins.png'));

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();
