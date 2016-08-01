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

$oPage->column1->addItem(new \Ease\Html\H2Tag(_('Práce na dálku programování/administrace')));
$serverSkills = $oPage->column1->addItem( new \Ease\Html\UlTag() );
$serverSkills->addItemSmart('Práce malého rozsahu: 400 Kč za hodinu');
$serverSkills->addItemSmart('Práce středního rozsahu: 1500 Kč za den');
$serverSkills->addItemSmart('Paušální cena 30000 Kč za měsíc');

$oPage->column3->addItem(new \Ease\Html\H2Tag(_('Práce na místě programování/administrace')));
$serverSkills = $oPage->column3->addItem( new \Ease\Html\UlTag() );
$serverSkills->addItemSmart('Práce malého rozsahu: 500 Kč za hodinu');
$serverSkills->addItemSmart('Práce středního rozsahu: 2000 Kč za den');
$serverSkills->addItemSmart('Paušální cena 35000 Kč za měsíc');


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

