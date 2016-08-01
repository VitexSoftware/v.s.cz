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

$oPage->addItem(new \VSCZ\ui\PageTop(_('Ease Framework'))); $oPage->AddItem('<a href="https://github.com/Vitexus/EaseFramework" class="ribbon bg-teal">Forkni na GitHubu</a>');

$oPage->AddPageColumns();

$oPage->column2->addItem('<h4>Poslední změna:</h4>');
$oPage->column2->addItem(file('easelastmsg.txt'));
$oPage->column2->addItem('<hr>');

$prehled = $oPage->column1->addItem(new \Ease\Html\Div());
$prehled->addItem('<strong>Ease Framework</strong> je aktívně vyvíjen od roku 2008. ');
$prehled->addItem('Podporuje <a href="http://html5.org">HTML5</a> či <a href="http://jqueryui.com/">jQueryUI</a>');
$prehled->addItem(' a <a href="http://www.phpunit.de/manual/current/en/index.html">PHPUnit</a> testy. ');
$prehled->addItem('Snaží se o přehledně psaný kod s <a href="http://pear.php.net/">PEAR</a> upravou. ');
$prehled->addItem('Čeština byla zvolena jako výchozí jazyk pro dokumentaci. ');
$prehled->addItem('<a href="http://www.phpdoc.org/">PHPDoc</a> a <a href="http://apigen.org/">apiGen</a>. ');
$prehled->addItem('Jazykově závislé řetězce mají <a href="http://php.net/manual/en/book.gettext.php">gettext</a> překlad do Anglického jazyka.<hr>');

$oPage->column3->addItem(new \Ease\Html\H3Tag(_('Ke stažení')));

$oPage->column3->addItem('<div style="background-color: #CAAAAA; margin: 2px; padding: 5px;">Zdrojové kody EaseFrameworku<br>');

$dwDir = "/var/www/html/download/";
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
foreach ($downloads as $file=>$size) {
    if (strstr($file, 'ease-framework_')) {
        $package = array($file=>$size);
    }
}

//echo '<pre>'; print_r($Downloads); echo '</pre>';

$oPage->column3->addItem(new \Ease\Html\ATag('download/Ease.tar.bz2', 'Ease.tar.bz2 '.$downloads['Ease.tar.bz2'] ,array('class'=>'btn btn-success')));
$oPage->column3->addItem(new \Ease\Html\ATag('download/'.key($package),'<img style="width: 42px;" src="img/deb-package.png">&nbsp;' .  key($package) . ' '.current($package) ,array('class'=>'btn btn-success')));

$oPage->column3->addItem('</div>');

$oPage->column3->addItem('<div style="background-color: #A0A7A0; margin: 2px; padding: 5px;">Ukázková aplikace <a href="http://l.q.cz/">LinkQuick</a><br> ');
$oPage->column3->addItem(new \Ease\Html\ATag('download/LinkQuick.tar.bz2', 'bz2 '.$downloads['LinkQuick.tar.bz2'],array('class'=>'btn btn-success')));
$oPage->column3->addItem('</div>');

$CodFS = $oPage->column2->addItem(new \Ease\Html\FieldSet(_('Ukázka kódu')));
$CodFS->addItem('<pre><code>
<span style="color: #007700">require_once&nbsp;</span><span style="color: #DD0000">\'Ease/EaseWebPage.php\'</span><span style="color: #007700">;</span>
<span style="color: black">/**&nbsp;Instancujeme&nbsp;objekt&nbsp;webové&nbsp;stránky&nbsp;*/</span>
<span style="color: #0000BB">$OPage&nbsp;</span><span style="color: #007700">=&nbsp;new&nbsp;</span><span style="color: #0000BB">EaseWebPage</span><span style="color: #007700">();<br />
<span style="color: black">/**&nbsp;Vložení&nbsp;jQuery&nbsp;tlačítka&nbsp;*/<br /></span><span style="color: #007700">require&nbsp;</span><span style="color: #DD0000">\'Ease/EaseJQueryWidgets.php\'</span><span style="color: #007700">;<br /></span><span style="color: #0000BB">$OPage</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">addItem</span><span style="color: #007700">(<br>new&nbsp;</span><span style="color: #0000BB">EaseJQueryLinkButton</span><span style="color: #007700">(</span><span style="color: #DD0000">\'http://l.q.cz\'</span><span style="color: #007700">,<br></span><span style="color: #DD0000">\'zkracovač\'</span><span style="color: #007700">));<br /></span>
<span style="color: black">/**&nbsp;Vyrendrování&nbsp;stránky&nbsp;*/<br /></span><span style="color: #0000BB">$OPage</span><span style="color: #007700">-&gt;</span><span style="color: #0000BB">draw</span><span style="color: #007700">();<br /><br /></span></code></pre>');

$oPage->column2->addItem(new \Ease\Html\FieldSet(_('Výsledek: jQueryUI tlačítko')));

$oPage->column2->addItem(new EaseJQueryLinkButton('http://l.q.cz/', 'zkracovač'));

$oPage->column1->addItem(new \Ease\Html\ATag('EaseDoc', 'Dokumentace Apigen',array('class'=>'btn btn-info')));
$oPage->column1->addItem(new \Ease\Html\ATag('https://github.com/Vitexus/EaseFramework', 'GitHub',array('class'=>'btn btn-info')));
$oPage->column1->addItem(new \Ease\Html\ATag('/websvn/rss.php?repname=Ease+Framework', 'RSS kanál',array('class'=>'btn btn-info')));
$oPage->column1->addItem(new \Ease\Html\ATag('http://redmine.murka.cz/projects/ease-framework', 'Redmine',array('class'=>'btn btn-info')));

$oPage->column3->addItem('<hr><h4>Instalace zdroje</h4>');
$oPage->column3->addItem('<a href="http://debian.org/"><img style="width: 60px;" title="Debian Linux" src="img/debian.png"></a>');
$oPage->column3->addItem('<a href="http://ubuntu.com/"><img style="width: 60px;" title="Ubuntu Linux" src="img/ubuntulogo.png"></a><p></p>');

$oPage->column3->addItem('<li><code>wget -O - http://v.s.cz/info@vitexsoftware.cz.gpg.key|sudo apt-key add -</code></li>');
$oPage->column3->addItem('<li><code>echo deb http://v.s.cz/ stable main &gt; /etc/apt/sources.list.d/ease.list </code></li>');
$oPage->column3->addItem('<li><code>aptitude update</code></li>');
$oPage->column3->addItem('<li><code>aptitude install ease-framework</code></li>');
$oPage->column1->addItem('<hr>');
$oPage->column1->addItem(new \Ease\Html\FieldSet(_('Proč použít ?')));
$oPage->column1->addItem('<img src="img/graf-timecost.png">');

$oPage->addItem(new \VSCZ\ui\PageBottom());

$oPage->draw();
