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
 * @copyright  2012-2023 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';

$oPage->includeJavaScript('js/github-activity.js');

// echo _('');

$oPage->addItem(new ui\PageTop(_('Vitex Software')));

$appMenu = new ui\MainPageMenu();
$libMenu = new ui\MainPageMenu();
$utilsMenu = new ui\MainPageMenu();

// $mainPageMenu->addMenuItem('img/deb-package.png', _('Repozitář'), 'repos.php',
//    _('Repozitář balíčků pro Debian & Ubuntu'));

$libMenu->addLibraryItem('https://github.com/Spoje-NET/php-flexibee', _('PHP AbraFlexi'), _('AbraFlexi client library'), null, 'spojenet/flexibee');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-vitexsoftware-rbczpremiumapi', _('PHP RBczPremiumAPI'), _('Raiffeisenbank Premium API client library'), null, 'vitexsoftware/rbczpremiumapi');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/PHP-Pohoda-Connector', _('PHPmServer'), _('client library for Sormware\'s Pohoda mServer'), 'img/phpmserver.svg', 'vitexsoftware/pohoda-connector');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-flexibee-bricks', _('AbraFlexi Bricks'), _('Addons for AbraFlexi PHP apps'));
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap4-widgets', _('TWB5 AbraFlexi widgets'), _('Twitter Bootstrap 4 Widgets for Ease Framework'), 'img/deb/php-ease-bootstrap4-widgets.svg', 'vitexsoftware/ease-twbootstrap4-widgets');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-core', _('Ease Core'), _('Core of Framework for easy writing of PHP applications'));
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-html', _('Ease HTML'), _('HTML 5 Tags for Ease Framework'));
$libMenu->addLibraryItem('https://github.com/Spoje-NET/PHP-Realpad-Takeout', _('RealPad Takeout'), _('Realpad document exporter'), 'img/realpad-takeout.svg', 'spojenet/realpad-takeout');

$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-twbootstrap4', _('Ease TWBootstrap4'), _('Twitter Bootstrap 4 support for Ease Framework'), null, 'vitexsoftware/ease-twbootstrap4');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap5', _('Ease TWBootstrap5'), _('Twitter Bootstrap 5 support for Ease Framework'), null, 'vitexsoftware/ease-twbootstrap5');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-fluentpdo', _('Ease FluentPDO'), _('FluentPDO support for Ease Framework'), null, 'vitexsoftware/ease-fluentpdo');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap-widgets-flexibee', _('TWB3 AbraFlexi widgets'), _('Several Bootstrap3 Widgets for AbraFlexi'), null, 'vitexsoftware/ease-twbootstrap-widgets-flexibee');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap4-widgets-flexibee', _('TWB5 AbraFlexi widgets'), _('Several Bootstrap4 Widgets for AbraFlexi'), null, 'vitexsoftware/ease-twbootstrap4-widgets-flexibee');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-flexibee-datatables', _('AbraFlexi datables'), _('Show AbraFlexi data in Datatables widget'), 'img/php-flexibee-datatables.png', 'vitexsoftware/php-datatables-abraflexi');
$libMenu->addLibraryItem('https://github.com/Spoje-NET/ipex-b2b', _('IPEX B2B'), _('Library for interaction with restapi.ipex.cz'), 'img/ipex-b2b-logo.png', 'spojenet/ipexb2b');
$libMenu->addLibraryItem('https://github.com/Spoje-NET/php-subreg', _('php-Subreg'), _('Easy interaction with subreg.cz'), 'img/php-subreg-logo.png', 'spojenet/subreg');
$libMenu->addLibraryItem('https://github.com/Spoje-NET/PohodaSQL', _('PohodaSQL'), _('PHP Library for Pohoda SQL Tables access '), 'img/pohodaSQL.svg', 'spojenet/pohoda-sql');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/php-ease-twbootstrap-widgets', _('TWB3 Widgets'), _('Twitter Bootstrap 3 Widgets for Ease Framework'), null, 'vitexsoftware/ease-twbootstrap-widgets');
$libMenu->addLibraryItem('https://github.com/VitexSoftware/ease-twbootstrap', _('Ease Twbootstrap'), _('Twitter Bootstrap 3 support for Ease Framework'), null, 'vitexsoftware/ease-twbootstrap');

$appMenu->addMenuItem(
    _('MultiFlexi'),
    'https://github.com/VitexSoftware/MultiFlexi',
    'img/multiflexi.svg',
    _('Run various tools on top of AbraFlexi and Stormware Pohoda '),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/multiflexi/composer.json')),
);

$appMenu->addMenuItem(
    _('AbraFlexi Digest'),
    'https://github.com/VitexSoftware/AbraFlexi-Digest',
    'img/abraflexi-digest.svg',
    _('FlexiBee company status digest every day, week, month or year'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-digest/composer.json')),
);

$appMenu->addMenuItem(
    _('Debs To SQL'),
    'https://github.com/VitexSoftware/DEBs-to-SQL',
    'img/debs2sql.svg',
    _('Index Debian package repository into SQL'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/debs2sql/composer.json')),
);

$utilsMenu->addMenuItem(
    _('Jasper Compiler'),
    'https://github.com/VitexSoftware/jaspercompiler',
    'img/jaspercompiler.svg',
    _('Commandline Jasper compiler with AbraFlexi custom reports support'),
    new \Ease\TWB5\Badge( sprintf(_('Current version %s'), '0.4')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Report Tools'),
    'https://github.com/VitexSoftware/AbraFlexi-Report-Tools',
    'img/abraflexi-report-tools.svg',
    _('Commandline tools related to AbraFlexi custom reports '),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-report-tools/composer.json')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Tools'),
    'https://github.com/VitexSoftware/AbraFlexi-Tools',
    'img/abraflexitools.svg',
    _('Set of commandline tools related to testing AbraFlexi functionality'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-tools/composer.json')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Raiffeisen Bank'),
    'https://github.com/VitexSoftware/abraflexi-raiffeisenbank',
    'img/abraflexi-raiffeisenbank.svg',
    _('Raiffeisen Bank Transaction / Statement puller for AbraFlexi'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-raiffeisenbank/composer.json')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Revolut Bank'),
    'https://github.com/VitexSoftware/AbraFlexi-Revolut',
    'img/abraflexi-revolut.svg',
    _('Revolut Bank Statement importer for AbraFlexi'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-revolut/composer.json')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Matcher'),
    'https://github.com/VitexSoftware/abraflexi-matcher',
    'img/abraflexi-matcher.svg',
    _('Match Invoices'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-matcher/composer.json')),
);

$utilsMenu->addMenuItem(
    _('AbraFlexi Reminder'),
    'https://github.com/VitexSoftware/abraflexi-reminder',
    'img/abraflexi-reminder.svg',
    _('Remind your customers'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-reminder/composer.json')),
);

$utilsMenu->addMenuItem(
    _('Mailer for AbraFlexi'),
    'https://github.com/VitexSoftware/abraflexi-mailer',
    'img/abraflexi-mailer.svg',
    _('Document Sender for AbraFlexi'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/abraflexi-mailer/composer.json')),
);

$utilsMenu->addMenuItem(
    _('Discomp To AbraFlexi'),
    'https://github.com/Spoje-NET/discomp2abraflexi',
    'img/discomp2abraflexi.svg',
    _('Import Discomp pricelist into AbraFlexi'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/discomp2abraflexi/composer.json')),
);

$utilsMenu->addMenuItem(
    _('Redmine To AbraFlexi'),
    'https://github.com/VitexSoftware/Redmine2AbraFlexi',
    'img/redmine2abraflexi.svg',
    _('It generates an invoice in FlexiBee from the hours worked in Redmine'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/redmine2abraflexi/composer.json')),
);

$utilsMenu->addMenuItem(
    _('Debs to Deb'),
    'https://github.com/VitexSoftware/debs2deb',
    'img/debs2deb.svg',
    _('Gives you offline debian repository as debian package'),
    new \Ease\TWB5\Badge( sprintf(_('Current version %s'), '1.1')),
);

$utilsMenu->addMenuItem(
    _('Subreg to AbraFlexi'),
    'https://github.com/Spoje-NET/subreg2abraflexi',
    'img/subreg2abraflexi.svg',
    _('Import Subreg Pricelist into AbraFlexi'),
    new \Ease\TWB5\Badge( ui\MainPageMenu::composerVersion('/usr/lib/subreg2abraflexi/composer.json')),
);

// $mainPageMenu->addMenuItem('img/tux-server.png', _('Hosting'), 'hosting.php',
//    _('Specializovaný hosting'));
$mainPageRow = new \Ease\TWB5\Row();

$activityColumn = $mainPageRow->addColumn(3, new \Ease\Html\H1Tag(_('Activity')));

$activityColumn->addItem(new \Ease\TWB5\Card('<h3>'._('Languages used last week').'</h3><figure><embed src="https://wakatime.com/share/@Vitex/f11768fc-15a3-4bdb-a419-32c058346b7e.svg"></embed></figure>'));

$activityColumn->addItem(new \Ease\TWB5\Card('<h3>'._('Coding activity last week').'</h3><figure><embed src="https://wakatime.com/share/@Vitex/5c5862c7-25c7-452d-a381-591ba73f9501.svg"></embed></figure>'));

$activityColumn->addItem(new \Ease\Html\DivTag(null, ['id' => 'ghfeed']));

$activityColumn->setTagCss(['background-image' => 'url(img/magnetic-nymph-head.png)', 'background-repeat' => 'no-repeat', 'background-position' => 'bottom left', 'background-attachment' => 'fixed']);

$mainPageRow->addColumn(7, [new \Ease\Html\H1Tag(_('Applications')), $appMenu, new \Ease\Html\H1Tag(_('Utilities')), $utilsMenu, new \Ease\Html\H1Tag(_('Libraries')), $libMenu]);

$mainPageRow->addColumn(2, new \Ease\Html\DivTag(
    '<h3>' . _('Latest Packages') . '</h3><div id="rss-feed"></div>',
    ['class' => 'rss-widget']
));

$oPage->includeCSS('//cdnjs.cloudflare.com/ajax/libs/octicons/2.0.2/octicons.min.css');
$oPage->includeJavaScript('//cdnjs.cloudflare.com/ajax/libs/mustache.js/0.7.2/mustache.min.js');

$oPage->addJavaScript(<<<'EOD'

 GitHubActivity.feed({
	username: "Vitexus",
	selector: "#ghfeed",
});

EOD);

$oPage->container->addItem($mainPageRow);

// $oPage->container->addItem(new \Ease\Html\H1Tag(_('News')));

$newsRow = new \Ease\TWB5\Row();

$newsColumn = $newsRow->addColumn(
    8,
    //    new \Ease\TWB5\Card([new ui\NewsShow(new News()), new \Ease\TWB5\LinkButton('articles.php',
    //            '<img src="img/news.svg" style="height: 20px"> '._('More articles').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>',
    //            'info')])
    ''
);


$oPage->addJavaScript(<<<'EOD'
fetch('https://repo.vitexsoftware.com/rss.php')
    .then(response => response.text())
    .then(str => new window.DOMParser().parseFromString(str, "text/xml"))
    .then(data => {
        const items = data.querySelectorAll("item");
        let html = "";
        items.forEach(el => {
            html += `<div class="card" style="width: 18rem;">`;
            html += `<h5 class="card-title">📦${el.querySelector("title").innerHTML}.deb</h5>`;
            html += `<p class="card-text">${el.querySelector("description").innerHTML}</p>`;
            html += `<!-- a class="btn btn-xsm btn-success" href="${el.querySelector("link").innerHTML}">💾</a -->`;
            html += `</div>`; 
        });
        document.getElementById("rss-feed").innerHTML = html;
    });
EOD);


$oPage->container->addItem($newsRow);

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
