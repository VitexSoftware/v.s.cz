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
require_once './classes/loginbox.php';


$oPage->addItem(new \VSCZ\ui\PageTop(_('Fakturační systém Moloch')));
//$oPage->AddItem('<a href="https://github.com/Vitexus/EaseFramework" class="ribbon bg-teal">Forkni na GitHubu</a>');

/*
  $oPage->column2->addItem('<h4>Poslední změna:</h4>');
  $oPage->column2->addItem(file('molochlastmsg.txt'));
  $oPage->column2->addItem('<hr>');
 */


$container = new \Ease\TWB\Container;

$infopanel = $container->addItem(new \Ease\TWB\Panel(new \Ease\Html\H2Tag('Moloch')));

$prehled = $infopanel->addItem(new \Ease\Html\UlTag());
$prehled->addItemSmart('byl vyvíjen od roku 2000 jako intranetový IS společnosti <a href="http://arachne.cz/">Arachne Labs</a>. ');
$prehled->addItemSmart('Současná verze je kompletní přepis do aktuálních technologií roku 2014. ');

$infopanel->addItem(new \Ease\Html\ImgTag('img/moloch-main2015.png', 'Moloch', null, null, array('class' => 'img-responsive img-rounded')));

//$oPage->column3->addItem('<div style="background-color: #CAAAAA; margin: 2px; padding: 5px;">Zdrojové kody EaseFrameworku<br>');

$dwDir = "/var/www/download/";
$d = dir($dwDir);
$downloads = array();
while (false !== ($entry = $d->read())) {
    if ($entry[0] == '.') {
        continue;
    }
    $downloads[$entry] = VSWebPage::_format_bytes(filesize($dwDir . $entry));
}
$d->close();
ksort($downloads);
$package = array();
foreach ($downloads as $file => $size) {
    if (strstr($file, 'moloch_')) {
        $package = array($file => $size);
    }
}

//echo '<pre>'; print_r($Downloads); echo '</pre>';

$row = $container->addItem(new \Ease\TWB\Row);


$install = new \Ease\TWB\Well(new \Ease\Html\H3Tag(_('Ke stažení')));

$install->addItem(new VSDownloadButton($package));


$install->addItem('<hr><h4>Instalace zdroje</h4>');

$install->addItem('<li><code>wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -</code></li>');
$install->addItem('<li><code>echo deb http://v.s.cz/ stable main &gt; /etc/apt/sources.list.d/ease.list </code></li>');
$install->addItem('<li><code>aptitude update</code></li>');
$install->addItem('<li><code>aptitude install moloch</code></li>');

$install->addItem('<hr><a href="http://debian.org/"><img style="width: 60px;" title="Debian Linux" src="img/debian.png"></a>');
$install->addItem('<a href="http://ubuntu.com/"><img style="width: 60px;" title="Ubuntu Linux" src="img/ubuntulogo.png"></a><p></p>');


$row->addItem(new \Ease\TWB\Col(6, $install));

$loginFace = new \Ease\Html\DivTag('LoginFace');

$loginForm = new loginbox('/moloch/login.php', 'login', 'heslo');

$loginFrame = new \Ease\Html\Div( '<span class="label label-danger">' . _('testovací provoz') . '</span>', array('class' => 'alert alert-warning'));

$loginFrame->addItem(new \Ease\Html\DivTag('WelcomeHint', _('Zadejte, prosím, Vaše přihlašovací údaje:')));

$loginFrame->addItem($loginForm);

$row->addItem(new \Ease\TWB\Col(6, new \Ease\TWB\Well($loginFrame)));

$oPage->addItem($container);


$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
