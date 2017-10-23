<?php

/**
 * VitexSoftware - titulní strana
 * 
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';


$oPage->addItem(new \VSCZ\ui\PageTop(_('Vitex Software')));
$oPage->AddPageColumns();

$oPage->column2->addItem(new \Ease\Html\ImgTag('img/terminal.png'));

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Remote programming / administration work')));
$serverSkills = $oPage->column1->addItem( new \Ease\Html\UlTag() );
$serverSkills->addItemSmart('Small work: 400 CZK per hour');
$serverSkills->addItemSmart('Medium work: CZK 1,500 per day');
$serverSkills->addItemSmart('Flat fee 30000 CZK per month');

$oPage->column3->addItem(new \Ease\Html\H2Tag(_('On-site programming / administration work')));
$serverSkills = $oPage->column3->addItem( new \Ease\Html\UlTag() );
$serverSkills->addItemSmart('Small scale work: CZK 500 per hour');
$serverSkills->addItemSmart('Medium work: CZK 2,000 per day');
$serverSkills->addItemSmart('Flat fee 35000 CZK per month');


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

