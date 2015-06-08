<?php

/**
 * VitexSoftware - kontakty
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new VSPageTop(_('Vitex Software - kontakty')));
$oPage->AddPageColumns();
$oPage->column3->addItem(new EaseHtmlH1Tag(_('Vítězslav Dvořák')));


$serverSkills = $oPage->column3->addItem(new EaseHtmlUlTag());
$serverSkills->addItemSmart('Melodická 11');
$serverSkills->addItemSmart('Praha 13, Stodůlky');
$serverSkills->addItemSmart('158 00');



$oPage->column2->addItem(new EaseHtmlH1Tag(_('')));

$NetworkSkills = $oPage->column2->addItem(new EaseHtmlUlTag());
$NetworkSkills->addItemSmart(new EaseHtmlATag('mailto:info@vitexsoftware.cz', 'info@vitexsoftware.cz'));
$NetworkSkills->addItemSmart(new EaseHtmlATag('callto:+420739778202', 'T-Mobile: (+420) 739  778 202'));
$NetworkSkills->addItemSmart(new EaseHtmlATag('callto:+420378774054', 'VoIP: (+420) 378 774054'));

$oPage->column1->addItem(new EaseHtmlH1Tag(_('Vitex Software')));
$DevelSkills = $oPage->column1->addItem(new EaseHtmlUlTag());
$DevelSkills->addItemSmart('IČO: 69438676');
$DevelSkills->addItemSmart('DIČ: CZ7808072811');

$DevelSkills->addItemSmart('Bankovní spojení: 2800677051 / 2010');
$DevelSkills->addItemSmart('IBAN: CZ9520100000002800677051');

$oPage->column2->addItem(new EaseHtmlImgTag('img/vitexutilite.jpg', 'Vitex', '250'));

//$oPage->column1->addItem(new EaseHtmlH4Tag(_('Bitcoins accepted')));
//$oPage->column1->addItem('<a href="bitcoin:1Au9b6pkd5eqAP3pprjJRkFduyS9uhFE8m?label=VitexSoftware"><pre>1Au9b6pkd5eqAP3pprjJRkFduyS9uhFE8m</pre></a>');
//$oPage->column1->addItem(new EaseHtmlImgTag('img/donatebitcoins.png'));

$oPage->addItem(new VSPageBottom());


$oPage->draw();
?>
