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

require_once 'includes/VSInit.php';

$oPage->addItem(new \VSCZ\ui\PageTop(_('Icinga Configurator')));
$oPage->addPageColumns();

$oPage->addItem('<a href="https://github.com/Vitexus/icinga_configurator" class="ribbon bg-teal">Forkni na GitHubu</a>');

$monitoringTabs = new \Ease\TWB5\Tabs('montabs');

$serviceTab = $monitoringTabs->addTab(_('Monitor your network'));
$serviceRow = new \Ease\TWB5\Row();

$serviceInfo = $serviceRow->addColumn(8);

$serviceInfo->addItem(new \Ease\Html\H2Tag(_('Servers & Services Monitoring')));
$serverSkills = $serviceInfo->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart(_('Windows behind NATem/firewallem monitoring'));
$serverSkills->addItemSmart('Nonstop worktime');
$serverSkills->addItemSmart('email, jabber, and sms notifications');

$serviceInfo->addItem(new \Ease\Html\H3Tag(_('Sign Up')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Služba jako taková je nabízena do deseti monitorovaných služeb zdarma.')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Nad deset monitorovaných služeb požadujeme deset korun za každý host na měsíc')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Zpoplatněny jsou i notifikační SMS a to dvěmi korunami za jednu zprávu.')));

$serviceInfo->addItem(new \Ease\TWB5\LinkButton(
    '/icinga-editor/createaccount.php',
    _('Sign IN'),
    'success',
));

$serviceLogin = $serviceRow->addColumn(4);
$serviceTab->addItem($serviceRow);

$loginFace = new \Ease\Html\DivTag(null, ['id' => 'LoginFace']);
$loginForm = new VSCZ\ui\loginbox(
    '/icinga-editor/login.php',
    'login',
    'password',
);
$loginFrame = $serviceLogin->addItem(new \Ease\Html\DivTag(
    '<span class="label label-danger">'._('testovací provoz').'</span>',
    ['class' => 'alert alert-warning'],
));
$loginFrame->addItem(new \Ease\Html\DivTag(
    _('Please enter your login and password'),
    ['id' => 'WelcomeHint'],
));
$loginFrame->addItem($loginForm);

$ossTab = $monitoringTabs->addTab(_('Open Source'));
$ossTab->addItem(new \Ease\Html\H4Tag(_('Freedom first')));
$ossTab->addItem(new \Ease\Html\PTag(_('Ctíme myšlenku že software má být svobodný a proto jsou k dispozici zdrojové kódy i instalační balíčky pro debian a odvozené distribuce.')));
$ossTab->addItem(new \Ease\Html\H4Tag(_('Instalace zdroje a balíčku')));
$ossTab->addItem(new \Ease\Html\PTag(_('Bude pro nás výrazem uznání kvality naší práce pokud se rozhodnete používat naše konfigurační rozhraní monitoringu i na vašem serveru.')));
$ossTab->addItem('<li><code>wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -</code></li>');
$ossTab->addItem('<li><code>echo deb http://v.s.cz/ stable main &gt; /etc/apt/sources.list.d/ease.list </code></li>');
$ossTab->addItem('<li><code>aptitude update</code></li>');
$ossTab->addItem('<li><code>aptitude install icinga-editor</code></li>');
$ossTab->addItem(new \Ease\Html\H4Tag(_('Veřejně dostupné zdrojové kódy')));

$ossTab->addItem(new \Ease\Html\PTag(_('Pro všechny zájemce o nahlédnutí nebo i přispění do zdrojových kódů jsou dveře otevřené.')));

$ossTab->addItem(<<<'EOD'


<iframe src="https://ghbtns.com/github-btn.html?user=Vitexus&repo=icinga_configurator&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>
EOD);
$sources = new \Ease\Html\UlTag();

$sources->addItemSmart(new \Ease\Html\ATag(
    'https://www.vitexsoftware.cz/redmine/projects/monitoring/repository',
    'Redmine',
));
$sources->addItemSmart(new \Ease\Html\ATag(
    'https://github.com/Vitexus/icinga_configurator',
    'GitHub',
));

$ossTab->addItem($sources);

$pageRow = new \Ease\TWB5\Row();
$pageRow->addColumn(8, $monitoringTabs);
$pageRow->addColumn(
    4,
    <<<'EOD'
<a class="twitter-timeline"  href="https://twitter.com/VSMonitoring" data-widget-id="255378607919210497">Tweets by @VSMonitoring</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

EOD
);

$supportTab = $monitoringTabs->addTab(_('Podpora'));
$supportTab->addItem(new \Ease\Html\H4Tag(_('Snadný start')));
$supportTab->addItem(new \Ease\Html\PTag(_('Ke spuštění monitoringu nejsou třeba žádné zvláštní znalosti. I přes to jsme pro vás připravili tento stručný ale názorný návod')));
$supportTab->addItem(new \Ease\TWB5\LinkButton(
    'https://www.vitexsoftware.cz/redmine/projects/monitoring/wiki/Tutori%C3%A1l',
    _('Začínáme'),
    'info',
));

$supportTab->addItem(new \Ease\Html\H4Tag(_('Zajímá nás váš názor')));
$supportTab->addItem(new \Ease\Html\PTag(_('Náš systém je neustále ve vývoji a tak se může stát že něco přestane fungovat. Proto oceníme pokud nám toto oznámíte. Stejně tak oceníme vaše přání a připomínky.')));
$supportTab->addItem(new \Ease\TWB5\LinkButton(
    'http://r.v.s.cz/projects/monitoring',
    'Redmine - Kniha přání a stížností',
    'warning',
));

$oPage->container->addItem($pageRow);

// $LoginFrame->addItem(new \Ease\TWB5\LinkButton('/IcingaEditor/twauth.php?authenticate=1', '<img src="img/tw.png">&nbsp;'. _('Přihlásit pomocí Twitteru'),'success'));
// $OPage->column1->addItem(new \Ease\Html\ImgTag('img/statusmap.png', 'Monitoring v červenci 2002', 400));
// $OPage->column3->addItem(new \Ease\Html\ImgTag('img/vsmonitoring.png', 'Logo', 250));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
