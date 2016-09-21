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

$dwDir     = "/var/www/download/";
$d         = dir($dwDir);
$downloads = [];
while (false !== ($entry     = $d->read())) {
    if ($entry[0] == '.') {
        continue;
    }
    $downloads[$entry] = VSWebPage::_format_bytes(filesize($dwDir.$entry));
}
$d->close();
ksort($downloads);
$tbPackage     = [];
$fuelUXPackage = [];
$tbSwPackage   = [];
$jqueryPackage = [];
foreach ($downloads as $file => $size) {
    if (strstr($file, 'libjs-twitter-bootstrap_')) {
        $tbPackage = [$file => $size];
    }
    if (strstr($file, 'libjs-fuelux_')) {
        $fuelUXPackage = [$file => $size];
    }
    if (strstr($file, 'libjs-twitter-bootstrap-switch_')) {
        $tbSwPackage = [$file => $size];
    }
    if (strstr($file, 'libjs-jquery_')) {
        $jqueryPackage = [$file => $size];
    }
}




//$oPage->head->addItem('<link rel="alternate" type="application/rss+xml" title="Ease Framework SVN" href="/websvn/rss.php?repname=Ease+Framework" />');


$oPage->addItem(new \VSCZ\ui\PageTop(_('unofficial Twitter Bootstrap Debian/Ubuntu packages')));


$container = $oPage->addItem(new \Ease\TWB\Container);


$packTabs     = new \Ease\TWB\Tabs('PackTabs');
$bootStrapTab = $packTabs->addTab('Twitter Bootstrap');


$bootStrapTab->addItem(new \Ease\Html\Div(new VSDownloadButton($tbPackage),
    ['style' => 'float:left;']));
$bootStrapTab->addItem(new \Ease\Html\Div(new \Ease\Html\ATag('http://twitter.github.com/bootstrap/',
    '<img style="height: 32px;" src="img/twitter-bootstrap.png">&nbsp; Official project homepage',
    ['class' => 'btn btn-info']), ['style' => 'float:right;']));
$bootStrapTab->addItem('is a free collection of tools for creating websites and web applications. It contains HTML and CSS-based design templates for typography, forms, buttons, charts, navigation and other interface components, as well as optional JavaScript extensions.');

$fuelUXTab = $packTabs->addTab('Fuel UX');
$fuelUXTab->addItem(new \Ease\Html\Div(new VSDownloadButton($fuelUXPackage),
    ['style' => 'float:left;']));
$fuelUXTab->addItem(new \Ease\Html\Div(new \Ease\Html\ATag('http://getfuelux.com/',
    '<img style="height: 32px;" src="img/fuelux.png">',
    ['class' => 'btn btn-info', 'style' => 'margin-left: 5px;']),
    ['style' => 'float:right;']));
$fuelUXTab->addItem('extends Twitter Bootstrap with additional lightweight JavaScript controls. Other benefits include easy installation into web projects, integrated scripts for customizing Bootstrap and Fuel UX, simple updates, and solid optimization for deployment. All functionality is covered by live documentation and unit tests.');


$bsSwitchTab = $packTabs->addTab('Bootstrap Switch');
$bsSwitchTab->addItem(new \Ease\Html\Div(new VSDownloadButton($tbSwPackage),
    ['style' => 'float:left;']));
$bsSwitchTab->addItem(new \Ease\Html\Div(new \Ease\Html\ATag('http://www.bootstrap-switch.org/',
    'Project Homepage', ['class' => 'btn btn-info']),
    ['style' => 'float:right;']));
$bsSwitchTab->addItem('extends Twitter Bootstrap with switch widget.');

$jqueryTab = $packTabs->addTab('jQuery');
$jqueryTab->addItem(new \Ease\Html\Div(new VSDownloadButton($jqueryPackage),
    ['style' => 'float:left;']));
$jqueryTab->addItem(new \Ease\Html\Div(new \Ease\Html\ATag('http://jquery.com/',
    '<img style="height: 32px;" src="img/logo-jquery.png">',
    ['class' => 'btn btn-info', 'style' => 'margin-left: 5px;']),
    ['style' => 'float:right;']));
$jqueryTab->addItem('jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.');



$container->addItem($packTabs);





$container2 = $oPage->addItem(new \Ease\TWB\Container('<p><br></p>'));


$tabs = new \Ease\TWB\Tabs('infotabs');

$steps = new \Ease\Html\UlTag(null, ['class' => 'list-group']);

$steps->addItemSmart('wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key | sudo apt-key add -',
    ['class' => 'list-group-item']);
$steps->addItemSmart('echo deb http://v.s.cz/ stable main | sudo tee /etc/apt/sources.list.d/vitexsoftware.list ',
    ['class' => 'list-group-item']);
$steps->addItemSmart('sudo aptitude update', ['class' => 'list-group-item']);

$steps->addItemSmart('aptitude install libjs-twitter-bootstrap',
    ['class' => 'list-group-item']);
$steps->addItemSmart('aptitude install libjs-fuelux',
    ['class' => 'list-group-item']);
$steps->addItemSmart('aptitude install libjs-twitter-bootstrap-switch',
    ['class' => 'list-group-item']);


$tabs->addTab(_('Debian installation'), $steps);
$tabs->addTab(_('Usage'),
    ('

In order to make use of twitter bootstrap in your html, include the following lines in
your html header:
<br/>
<code>
    &lt;link type="text/css" href="/javascript/twitter-bootstrap/css/twitter-bootstrap.css" rel="stylesheet" /&gt;
    <br/>
    &lt;script language="javascript" type="text/javascript" src="/javascript/jquery/jquery.js"&gt;&lt;/script&gt;
    <br/>
    &lt;script language="javascript" type="text/javascript" src="/javascript/twitter-bootstrap/bootstrap.js"&gt;&lt;/script&gt;
</code>
<h5>for FuelUX support add:</h5>
<code>
    &lt;link type="text/css" href="/javascript/twitter-bootstrap/css/fuelux.css" rel="stylesheet" /&gt;
    <br/>
    &lt;script language="javascript" type="text/javascript" src="/javascript/twitter-bootstrap/fuelux.js"&gt;&lt;/script&gt;
</code>

<h5>for boostrstrap-switch add:</h5>
<code>
    &lt;link type="text/css" href="/javascript/twitter-bootstrap/css/boostrstrap-switch.css" rel="stylesheet" /&gt;
    <br/>
    &lt;script language="javascript" type="text/javascript" src="/javascript/twitter-bootstrap/js/boostrstrap-switch.js"&gt;&lt;/script&gt;
</code>


'));

$container2->addItem($tabs);



$container2->addItem('<hr>');

$container2->addItem('<h5>Compatible with</h5>');
$container2->addItem('<a href="http://debian.org/"><img style="width: 60px;" title="Debian Linux" src="img/debian.png"></a>');
$container2->addItem('<a href="http://ubuntu.com/"><img style="width: 60px;" title="Ubuntu Linux" src="img/ubuntulogo.png"></a>');


$container2->addItem(new \Ease\Html\ATag('http://bootsnipp.com/',
    '<img style="height: 32px;" src="img/bootsnip.png">&nbsp; Design elements and code snippets',
    ['class' => 'btn btn-info']));


$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

