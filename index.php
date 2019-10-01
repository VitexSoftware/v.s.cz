<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2018 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

//echo _('');

$oPage->addItem(new ui\PageTop(_('Vitex Software')));

$appMenu = new ui\MainPageMenu();
$libMenu = new ui\MainPageMenu();
$utilsMenu = new ui\MainPageMenu();

//$mainPageMenu->addMenuItem('img/deb-package.png', _('Repozitář'), 'repos.php',
//    _('Repozitář balíčků pro Debian & Ubuntu'));


$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-core', _('Ease Core') , _('Core of Framework for easy writing of PHP applications') , 'img/ease-core.svg' );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-html', _('Ease HTML') , _('HTML 5 Tags for Ease Framework')                         , 'img/ease-html-logo.png');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-twbootstrap', _('Ease Twbootstrap'),_('Twitter Bootstrap 3 support for Ease Framework') );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap-widgets', _('Ease Twbootstrap Widgets'),  _('Twitter Bootstrap 3 Widgets for Ease Framework') );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-twbootstrap4', _('Ease Twbootstrap4'),_('Twitter Bootstrap 4 support for Ease Framework') );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap4-widgets', _('Ease Twbootstrap4 FlexiBee widgets '),  _('Twitter Bootstrap 4 Widgets for Ease Framework')  );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-fluentpdo', _('Ease FluentPDO'), _('FluentPDO support for Ease Framework')  );
$libMenu->addLibraryItem('https://github.com/Spoje-NET/php-flexibee', _('FlexiBee'), _('FlexiBee client library') );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-flexibee-bricks' , _('FlexiBee Bricks'), _('Addons for FlexiBee PHP apps')  );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap-widgets-flexibee', _('Bootstrap 3 FlexiBee widgets'), _('Several Bootstrap3 Widgets for FlexiBee'));
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap4-widgets-flexibee',  _('Bootstrap 4 FlexiBee widgets') , _('Several Bootstrap4 Widgets for FlexiBee')   );
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-flexibee-datatables', _('FlexiBee datables') , _('Show FlexiBee data in Datatables widget') );
$libMenu->addLibraryItem('https://github.com/Spoje-NET/ipex-b2b', _('IPEX B2B'),  _('Library for interaction with restapi.ipex.cz'),'img/ipex-b2b-logo.png');
$libMenu->addLibraryItem('https://github.com/Spoje-NET/php-subreg',_('php-Subreg'), _('Easy interaction with subreg.cz'),'img/php-subreg-logo.png');

if (file_exists('/usr/share/icinga-editor/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/icinga-editor/composer.json'));
    $version      = $composerInfo->version;
} else {
    $version = 'n/a';
}


$appMenu->addMenuItem('img/icinga_editor-logo.png', _('Icinga Editor'),
    'http://monitoring.vitexsoftware.cz/', _('Editor Konfigurace monitoringu'),
    new \Ease\TWB4\Label('info', $version));

if (file_exists('/usr/share/flexplorer/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexplorer/composer.json'));
    $version      = $composerInfo->version;
}


$appMenu->addMenuItem('img/flexplorer-logo.png', _('Flexplorer'),
    '/flexplorer/', _('Vývojářský nástroj pro FlexiBee REST API'),
    new \Ease\TWB4\Label('info', $version));
//$mainPageMenu->addMenuItem('img/flexihubee-logo.png', _('FlexiHUBee'),
//    'https://www.vitexsoftware.cz/redmine/projects/flexihubee',
//    _('Webová aplikace pro vzájemnou synchronizaci FlexiBee serverů (zatím neveřejné)'));


if (file_exists('/usr/share/flexiproxy/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexiproxy/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem('img/flexiproxy-logo.png', _('FlexiProxy'),
    'https://flexiproxy.vitexsoftware.cz/c/demo', _('FlexiBee modifikátor'),
    new \Ease\TWB4\Label('info', $version));

if (file_exists('/usr/share/shop4flexibee/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/shop4flexibee/composer.json'));
    $version      = $composerInfo->version;
}

$appMenu->addMenuItem('img/shop4flexibee-logo.svg', _('FlexiBee ClientZone'),
    'https://clientzone.vitexsoftware.cz/clientzone/login.php?email=demo@vitexsoftware.cz&password=demo',
    _('ClientZone App for FlexiBee'), new \Ease\TWB4\Label('info', $version));

//$mainPageMenu->addMenuItem('img/tux-server.png', _('Hosting'), 'hosting.php',
//    _('Specializovaný hosting'));



$oPage->container->addItem(new \Ease\Html\H1Tag(_('Applications')));

$oPage->container->addItem($appMenu);

$oPage->container->addItem(new \Ease\Html\H1Tag(_('Libraries')));

$oPage->container->addItem($libMenu);

$oPage->container->addItem(new \Ease\Html\H1Tag(_('News')));

$newsRow = new \Ease\TWB4\Row();




$newsColumn = $newsRow->addColumn(8,
    new \Ease\TWB4\Well([new ui\NewsShow(new News()), new \Ease\TWB4\LinkButton('articles.php',
            '<img src="img/news.svg" style="height: 20px"> '._('More articles').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>',
            'info')]));
$newsRow->addColumn(4, new ui\NewPackages());

$newsColumn->addItem(new \Ease\TWB4\Well('<h1>'._('Languages used last week').'</h1><figure><embed src="https://wakatime.com/share/@5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7/993cf4a7-8296-4820-96c3-c4caf210b3bf.svg"></embed></figure>'));

$newsColumn->addItem(new \Ease\TWB4\Well('<h1>'._('Coding activity last week').'</h1><figure><embed src="https://wakatime.com/share/@5abba9ca-813e-43ac-9b5f-b1cfdf3dc1c7/04de33a5-c65a-4447-a93a-d5294dd85c73.svg"></embed></figure>'));

$newsColumn->addItem(new \Ease\Html\DivTag(null, ['id' => 'ghfeed']));
$oPage->includeCSS('//cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css');
$oPage->includeJavaScript('//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js');

$oPage->includeJavaScript('js/github-activity-0.1.5.min.js');
$oPage->includeCSS('css/github-activity-0.1.5.min.css');
$oPage->addJavaScript('
 GitHubActivity.feed({
	username: "Vitexus",
	selector: "#ghfeed",
});   
');


$oPage->container->addItem($newsRow);

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

