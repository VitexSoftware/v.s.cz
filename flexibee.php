<?php

namespace VSCZ;

/**
 * VitexSoftware FlexiBee
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2017 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('FlexiBee')));
$oPage->container = $oPage->addItem(new \Ease\TWB\Container());



$oPage->container->addItem(new \Ease\Html\ATag('https://flexibee.eu/',
    new \Ease\Html\ImgTag('img/abra-flexibee.png', 'Abra FlexiBee',
    ['class' => 'img-responsive', 'style' => 'margin: 10px']),
    ['title' => _('Go to FlexiBee site')]));

$oPage->container->addItem(new \Ease\Html\DivTag(_('Účetní a ekonomický systém pro menší firmy a živnostníky s bohatými možnostmi integrace.'),
    ['class' => 'jumbotron']));


$productRow = new \Ease\TWB\Row();

$column1 = $productRow->addColumn(4);

$column1->addItem(new \Ease\Html\H3Tag('FlexiBee Server'));
$column1->addItem(new \Ease\Html\DivTag(_('Abra poskytuje pouze instalační balíčkek grafického klienta pro desktop a nebo klienta se serverem. Kdo si ale nechce na server instalovat nepotřebné grafické knihovny, ten si nainstaluje náš balíček.'),
    ['style' => 'margin: 5px;']));

$column1->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-server-deb',
   [new \Ease\Html\ImgTag('img/abra-flexibee-square.png', 'FlexiBee logo',
        ['style' => 'height: 30px;']), ' ', _('Více informací').' »'],
    'success btn-lg'));



$column1->addItem(new \Ease\Html\H3Tag('Zálohování'));
$column1->addItem(new \Ease\Html\DivTag(_('Snadno nastavitelná utilita pro každodení zálohování vašich účetních dat'),
    ['style' => 'margin: 5px;']));
$column1->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-server-deb',
    _('Více informací').' »', 'success btn-lg'));


$column1->addItem(new \Ease\Html\H3Tag('Monitoring'));
$column1->addItem(new \Ease\Html\DivTag(_('Senzory pro sledování stavu FlexiBee. Použitelné v monitorovacích systémech Nagios/Icinga.'),
    ['style' => 'margin: 5px;']));

$column1->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/monitoring-plugins-flexibee',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));



$column2 = $productRow->addColumn(4);
$column2->addItem(new \Ease\Html\H3Tag(_('Library FlexiPeeHP')));
$column2->addItem(new \Ease\Html\DivTag(_('PHP Knihovna pro snadnou integraci vašich aplikací a systémů'),
    ['style' => 'margin: 5px;']));

$column2->addItem(new \Ease\TWB\LinkButton('https://www.youtube.com/watch?time_continue=23158&v=LTxascj6uv8',
    [new \Ease\Html\ImgTag('img/flexipeehp-logo.png', 'FlexiPeeHP logo',
        ['style' => 'height: 30px;']), ' ', _('Video presentation').' »'],
    'success btn-lg'));

$column2->addItem(new \Ease\TWB\LinkButton('https://github.com/Spoje-NET/FlexiPeeHP',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));



$column2->addItem(new \Ease\Html\H3Tag('FlexPlorer'));
$column2->addItem(new \Ease\Html\DivTag(_('Vývojářský nástroj a editor pro FlexiBee API. Napsaný s využitím knihovny FlexiPeeHP:'),
    ['style' => 'margin: 5px;']));
$column2->addItem(new \Ease\TWB\LinkButton('https://flexplorer.vitexsoftware.cz/',
    [new \Ease\Html\ImgTag('img/flexplorer-logo.png', 'Flexplorer logo',
        ['style' => 'height: 30px;']), ' ', _('See in action').' »'],
    'success btn-lg'));

$column2->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/Flexplorer/',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));

$column2->addItem(new \Ease\Html\H3Tag(_('FlexiBee Git History')));
$column2->addItem(new \Ease\Html\DivTag(_('Solution for saving all flexibee changes into git repository with json files in'),
    ['style' => 'margin: 5px;']));

$column2->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-history',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));


$column3 = $productRow->addColumn(4);
$column3->addItem(new \Ease\Html\H3Tag('FlexiProxy'));
$column3->addItem(new \Ease\Html\DivTag(_('Transparent Proxy for filering and modification communictation with FlexiBee '),
    ['style' => 'margin: 5px;']));
$column3->addItem(new \Ease\TWB\LinkButton('https://flexiproxy.vitexsoftware.cz/c/demo',
    [new \Ease\Html\ImgTag('img/flexiproxy-logo.png', 'FlexiProxy logo',
        ['style' => 'height: 30px;']), ' ', _('Live Demo').' »'],
    'success btn-lg'));
$column3->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/FlexiProxy',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));

$column3->addItem(new \Ease\Html\H3Tag('Shop4FlexiBee'));
$column3->addItem(new \Ease\Html\DivTag(_('Basic app for order pricelist items and reaction after incoming payment'),
    ['style' => 'margin: 5px;']));

$column3->addItem(new \Ease\TWB\LinkButton('https://shop4flexibee.vitexsoftware.cz/',
    [new \Ease\Html\ImgTag('img/shop4flexibee-logo.svg', 'Shop4FlexiBee logo',
        ['style' => 'height: 30px;']), ' ', _('Live Customer Demo').' »'],
    'success btn-lg'));

$column3->addItem(new \Ease\Html\DivTag(_('Username: admin Password: admin'),
    ['style' => 'margin: 5px;']));


$column3->addItem(new \Ease\TWB\LinkButton('https://shop4flexibee.vitexsoftware.cz/adminlogin.php',
    [new \Ease\Html\ImgTag('img/shop4flexibee-logo.svg', 'Shop4FlexiBee logo',
        ['style' => 'height: 30px;']), ' ', _('Live Admin Demo').' »'],
    'success btn-lg'));




$column3->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/Shop4FlexiBee',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));



$oPage->container->addItem(new \Ease\Html\H2Tag(_('FlexiBee enhancenments')));
$oPage->container->addItem(new \Ease\Html\DivTag(_('Díky několikaleté praxi s tímto systémem vám přinášíme tyto naše vylepšení, integrace a nástroje').':'));
$oPage->container->addItem($productRow);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

