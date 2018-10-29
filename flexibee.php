<?php

namespace VSCZ;

/**
 * VitexSoftware FlexiBee
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2017-2018 vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('FlexiBee')));
$oPage->container = $oPage->addItem(new \Ease\TWB\Container());



$oPage->container->addItem(new \Ease\Html\ATag('https://flexibee.eu/',
    new \Ease\Html\ImgTag('img/abra-flexibee.png', 'Abra FlexiBee',
    ['class' => 'img-responsive', 'style' => 'margin: 10px']),
    ['title' => _('Go to FlexiBee site')]));

$oPage->container->addItem(new \Ease\Html\DivTag('<center>'._('Účetní a ekonomický systém pro menší firmy a živnostníky s bohatými možnostmi integrace.').'</center>',
    ['class' => 'jumbotron']));

//
//$productRow = new \Ease\TWB\Row();
//
//$column1 = $productRow->addColumn(4);
//
//$column2 = $productRow->addColumn(4);
//
//
//$column2->addItem(new \Ease\Html\H3Tag(_('FlexiBee Git History')));
//$column2->addItem(new \Ease\Html\DivTag(_('Solution for saving all flexibee changes into git repository with json files in'),
//    ['style' => 'margin: 5px;']));
//
//$column2->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-history',
//    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));
//
//
//$column3 = $productRow->addColumn(4);
//
//$column3->addItem(new \Ease\Html\H3Tag(_('FlexiBee ClientZone')));
//$column3->addItem(new \Ease\Html\ImgTag('img/shop4flexibee-logo.svg',
//    _('FlexiBee ClientZone'), ['class' => 'img-responsive']));
//$column3->addItem(new \Ease\Html\DivTag(_('Basic app for order pricelist items and reaction after incoming payment'),
//    ['style' => 'margin: 5px;']));
//
//$column3->addItem(new \Ease\TWB\LinkButton('https://shop4flexibee.vitexsoftware.cz/',
//    [new \Ease\Html\ImgTag('img/shop4flexibee-logo.svg', 'Shop4FlexiBee logo',
//        ['style' => 'height: 30px;']), ' ', _('Live Customer Demo').' »'],
//    'success btn-lg'));
//
//$column3->addItem(new \Ease\Html\DivTag(_('Username: admin Password: admin'),
//    ['style' => 'margin: 5px;']));
//
//
//$column3->addItem(new \Ease\TWB\LinkButton('https://shop4flexibee.vitexsoftware.cz/adminlogin.php',
//    [new \Ease\Html\ImgTag('img/shop4flexibee-logo.svg', 'Shop4FlexiBee logo',
//        ['style' => 'height: 30px;']), ' ', _('Live Admin Demo').' »'],
//    'success btn-lg'));
//
//$column3->addItem(new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/FlexiBee-ClientZone',
//    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));
//





$oPage->container->addItem(new \Ease\Html\H2Tag(_('FlexiBee enhancenments')));
$oPage->container->addItem(new \Ease\Html\DivTag(_('Díky několikaleté praxi s tímto systémem vám přinášíme tyto naše vylepšení, integrace a nástroje').':'));
//$oPage->container->addItem($productRow);

$flexiCarousel = new \Ease\TWB\Carousel('FlexiCarousel');

$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexibee-server.png',
    'FlexiBee server'), _('FlexiBee Server'),
    [
    new \Ease\Html\DivTag(_('Abra poskytuje pouze instalační balíčkek grafického klienta pro desktop a nebo klienta se serverem. Kdo si ale nechce na server instalovat nepotřebné grafické knihovny, ten si nainstaluje náš balíček.'),
        ['style' => 'margin: 5px;']), new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-server-deb',
        [new \Ease\Html\ImgTag('img/abra-flexibee-square.png', 'FlexiBee logo',
            ['style' => 'height: 30px;']), ' ', _('More informations').' »'],
        'success btn-lg')]);


$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexibee-server-backup.png',
    _('FlexiBee server backup')), _('Backup'),
    [new \Ease\Html\DivTag(_('Snadno nastavitelná utilita pro každodení zálohování vašich účetních dat'),
        ['style' => 'margin: 5px;']), new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/flexibee-server-deb',
        _('More informations').' »', 'success btn-lg')]);


$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexibee-testing-tools.png',
    _("Testing Tools")), _("Testing Tools"),
    [new \Ease\Html\DivTag(_('Set of commandline tools related to testing FlexiBee functionality'),
        ['style' => 'margin: 5px;']), new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/FlexiBee-TestingTools',
        '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info')]);



$flexiCarousel->addSlide(new ui\SlideImage('img/deb/monitoring-plugins-flexibee.png',
    _('Monitoring')), _('Monitoring'),
    [
    new \Ease\Html\DivTag(_('Senzory pro sledování stavu FlexiBee. Použitelné v monitorovacích systémech Nagios/Icinga.'),
        ['style' => 'margin: 5px;'])
    ,
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/monitoring-plugins-flexibee',
        '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info')
    ]
);

$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexibee-digest.png',
    _('FlexiBee Digest')), _('FlexiBee Digest'),
    [
    new \Ease\Html\DivTag(_('FlexiBee company status digest every  day, week, month,year or alltime'),
        ['style' => 'margin: 5px;'])
    ,
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/FlexiBee-Digest',
        '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info')
    ]
);



$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexplorer.png',
    _('FlexPlorer')), _('FlexPlorer'),
    [
    new \Ease\Html\DivTag(_('Vývojářský nástroj a editor pro FlexiBee API. Napsaný s využitím knihovny FlexiPeeHP:'),
        ['style' => 'margin: 5px;']),
    new \Ease\TWB\LinkButton('https://flexplorer.vitexsoftware.cz/',
        [new \Ease\Html\ImgTag('img/flexplorer-logo.png', 'Flexplorer logo',
            ['style' => 'height: 30px;']), ' ', _('See in action').' »'],
        'success btn-lg'),
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/Flexplorer/',
        '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info')
    ]
);

$flexiCarousel->addSlide(new ui\SlideImage('img/deb/php-flexibee-reminder.png',
    _('FlexiBee Reminder')), _('FlexiBee Reminder'),
    [new \Ease\Html\DivTag(_('Reminds your customers by email with invoices in attachment as pdf and isdoc')),
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/php-flexibee-reminder',
        [new \Ease\Html\ImgTag('img/deb/php-flexibee-reminder.png',
            'FlexiBee Reminder', ['style' => 'height: 30px;']), ' ', _('More informations').' »'],
        'success btn-lg')
    ]
);

$flexiCarousel->addSlide(new ui\SlideImage('img/deb/php-flexibee-matcher.png',
    _('FlexiBee Matcher')), _('FlexiBee Matcher'),
    [new \Ease\Html\DivTag(_('Match invoices')),
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/php-flexibee-matcher',
        [new \Ease\Html\ImgTag('img/deb/php-flexibee-matcher.png',
            'FlexiBee Matcher', ['style' => 'height: 30px;']), ' ', _('More informations').' »'],
        'success btn-lg')
    ]
);


$flexiCarousel->addSlide(new ui\SlideImage('img/flexiproxy-logo.png',
    'FlexiProXY'),'FlexiProXY',
    [
    new \Ease\Html\DivTag(_('Transparent Proxy for filering and modification communictation with FlexiBee '),
        ['style' => 'margin: 5px;']),
    new \Ease\TWB\LinkButton('https://flexiproxy.vitexsoftware.cz/c/demo',
        [new \Ease\Html\ImgTag('img/flexiproxy-logo.png', 'FlexiProxy logo',
            ['style' => 'height: 30px;']), ' ', _('Live Demo').' »'],
        'success btn-lg'),
    new \Ease\TWB\LinkButton('https://github.com/VitexSoftware/FlexiProxy',
        '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info')
]);


$flexiPeeHPInfo = new \Ease\Html\DivTag();
$flexiPeeHPInfo->addItem(new \Ease\Html\DivTag(_('PHP Knihovna pro snadnou integraci vašich aplikací a systémů'),
    ['style' => 'margin: 5px;']));

$flexiPeeHPInfo->addItem(new \Ease\TWB\LinkButton('https://www.youtube.com/watch?time_continue=23158&v=LTxascj6uv8',
    [new \Ease\Html\ImgTag('img/flexipeehp-logo.png', 'FlexiPeeHP logo',
        ['style' => 'height: 30px;']), ' ', _('Video presentation').' »'],
    'success btn-lg'));

$flexiPeeHPInfo->addItem(new \Ease\TWB\LinkButton('https://github.com/Spoje-NET/FlexiPeeHP',
    '<i class = "fa fa-github"></i> '._('Source codes').' »', 'info'));

$flexiCarousel->addSlide(new ui\SlideImage('img/deb/flexipeehp.png', _('Library FlexiPeeHP')),_('Library FlexiPeeHP'), $flexiPeeHPInfo);



$oPage->container->addItem($flexiCarousel);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

