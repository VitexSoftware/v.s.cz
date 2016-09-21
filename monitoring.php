<?php
/**
 * VitexSoftware - monitoring
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
require_once 'includes/VSInit.php';
require_once './classes/loginbox.php';

$oPage->addItem(new \VSCZ\ui\PageTop(_('Vitex Software')));
$oPage->AddPageColumns();

$oPage->AddItem('<a href="https://github.com/Vitexus/icinga_configurator" class="ribbon bg-teal">Forkni na GitHubu</a>');


if ($OUser->getUserID()) {
    $oPage->redirect('http://v.s.cz/icinga-editor/');
}


$monitoringTabs = new \Ease\TWB\Tabs('montabs');

$serviceTab = $monitoringTabs->addTab(_('Monitorujte svoji síť'));
$serviceRow = new \Ease\TWB\Row;

$serviceInfo = $serviceRow->addColumn(8);

$serviceInfo->addItem(new \Ease\Html\H2Tag(_('Monitoring serverů a služeb')));
$serverSkills = $serviceInfo->addItem(new \Ease\Html\UlTag());
$serverSkills->addItemSmart(_('Monitoring Windows i za NATem/firewallem'));
$serverSkills->addItemSmart('Nonstop provoz');
$serverSkills->addItemSmart('Notifikace přez mail, jabber, twitter a sms');


$serviceInfo->addItem(new \Ease\Html\H3Tag(_('Přidejte se')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Služba jako taková je nabízena do deseti monitorovaných služeb zdarma.')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Nad deset monitorovaných služeb požadujeme deset korun za každý host na měsíc')));
$serviceInfo->addItem(new \Ease\Html\PTag(_('Zpoplatněny jsou i notifikační SMS a to dvěmi korunami za jednu zprávu.')));

$serviceInfo->addItem(new \Ease\TWB\LinkButton('/icinga-editor/createaccount.php',
    _('Registrace'), 'success'));




$serviceLogin = $serviceRow->addColumn(4);
$serviceTab->addItem($serviceRow);

$loginFace  = new \Ease\Html\DivTag('LoginFace');
$loginForm  = new loginbox('/icinga-editor/login.php', 'login', 'password');
$loginFrame = $serviceLogin->addItem(new \Ease\Html\Div('<span class="label label-danger">'._('testovací provoz').'</span>',
    ['class' => 'alert alert-warning']));
$loginFrame->addItem(new \Ease\Html\DivTag('WelcomeHint',
    _('Zadejte, prosím, Vaše přihlašovací údaje:')));
$loginFrame->addItem($loginForm);





$ossTab = $monitoringTabs->addTab(_('Open Source'));
$ossTab->addItem(new \Ease\Html\H4Tag(_('Svoboda především')));
$ossTab->addItem(new \Ease\Html\PTag(_('Ctíme myšlenku že software má být svobodný a proto jsou k dispozici zdrojové kódy i instalační balíčky pro debian a odvozené distribuce.')));
$ossTab->addItem(new \Ease\Html\H4Tag(_('Instalace zdroje a balíčku')));
$ossTab->addItem(new \Ease\Html\PTag(_('Bude pro nás výrazem uznání kvality naší práce pokud se rozhodnete používat naše konfigurační rozhraní monitoringu i na vašem serveru.')));
$ossTab->addItem('<li><code>wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -</code></li>');
$ossTab->addItem('<li><code>echo deb http://v.s.cz/ stable main &gt; /etc/apt/sources.list.d/ease.list </code></li>');
$ossTab->addItem('<li><code>aptitude update</code></li>');
$ossTab->addItem('<li><code>aptitude install icinga-editor</code></li>');
$ossTab->addItem(new \Ease\Html\H4Tag(_('Veřejně dostupné zdrojové kódy')));

$ossTab->addItem(new \Ease\Html\PTag(_('Pro všechny zájemce o nahlédnutí nebo i přispění do zdrojových kódů jsou dveře otevřené.')));

$ossTab->addItem('

<iframe src="https://ghbtns.com/github-btn.html?user=Vitexus&repo=icinga_configurator&type=star&count=true" frameborder="0" scrolling="0" width="170px" height="20px"></iframe>');
$sources = new \Ease\Html\UlTag;

$sources->addItemSmart(new \Ease\Html\ATag('https://www.vitexsoftware.cz/redmine/projects/monitoring/repository',
    'Redmine'));
$sources->addItemSmart(new \Ease\Html\ATag('https://github.com/Vitexus/icinga_configurator',
    'GitHub'));

$ossTab->addItem($sources);

$pageRow = new \Ease\TWB\Row;
$pageRow->addColumn(8, $monitoringTabs);
$pageRow->addColumn(4,
    '<a class="twitter-timeline"  href="https://twitter.com/VSMonitoring" data-widget-id="255378607919210497">Tweets by @VSMonitoring</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
');


$supportTab = $monitoringTabs->addTab(_('Podpora'));
$supportTab->addItem(new \Ease\Html\H4Tag(_('Snadný start')));
$supportTab->addItem(new \Ease\Html\PTag(_('Ke spuštění monitoringu nejsou třeba žádné zvláštní znalosti. I přes to jsme pro vás připravili tento stručný ale názorný návod')));
$supportTab->addItem(new \Ease\TWB\LinkButton('https://www.vitexsoftware.cz/redmine/projects/monitoring/wiki/Tutori%C3%A1l',
    _('Začínáme'), 'info'));

$supportTab->addItem(new \Ease\Html\H4Tag(_('Zajímá nás váš názor')));
$supportTab->addItem(new \Ease\Html\PTag(_('Náš systém je neustále ve vývoji a tak se může stát že něco přestane fungovat. Proto oceníme pokud nám toto oznámíte. Stejně tak oceníme vaše přání a připomínky.')));
$supportTab->addItem(new \Ease\TWB\LinkButton('http://r.v.s.cz/projects/monitoring',
    'Redmine - Kniha přání a stížností', 'warning'));


$oPage->container->addItem($pageRow);



//$LoginFrame->addItem(new \Ease\TWB\LinkButton('/IcingaEditor/twauth.php?authenticate=1', '<img src="img/tw.png">&nbsp;'. _('Přihlásit pomocí Twitteru'),'success'));
//$OPage->column1->addItem(new \Ease\Html\ImgTag('img/statusmap.png', 'Monitoring v červenci 2002', 400));
//$OPage->column3->addItem(new \Ease\Html\ImgTag('img/vsmonitoring.png', 'Logo', 250));

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
