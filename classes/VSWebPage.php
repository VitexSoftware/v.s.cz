<?php

/**
 * Třídy pro vykreslení stránky
 *
 * @package   VitexSoftware
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2011 Vitex@hippy.cz (G)
 */
require_once 'Ease/EaseWebPage.php';
require_once 'Ease/EaseHtmlForm.php';
require_once 'Ease/EaseJQueryWidgets.php';
require_once 'Ease/EaseTWBootstrap.php';

class VSWebPage extends EaseTWBWebPage
{

    /**
     * Základní objekt stránky
     *
     * @param VSUser $userObject
     */
    function __construct(&$userObject = null)
    {
        parent::__construct('Vitex Software', $userObject);
        $this->includeCss('css/bootstrap.css');
        $this->includeCss('css/default.css');
        EaseShared::webPage()->head->addItem('<link rel="icon" type="image/png"
 href="img/tux-server.png" />');
        EaseShared::webPage()->head->addItem('<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-35526048-1\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>            ');
    }

    function AddPageColumns()
    {
        $this->container = $this->addItem(new EaseHtmlDivTag(null, null, array('class' => 'container')));
        $this->heroUnit = $this->container->addItem(new EaseHtmlDivTag('heroUnit', null, array('class' => 'jumbotron')));
        $row = $this->container->addItem(new EaseHtmlDivTag(null, null, array('class' => 'row')));
        $this->column1 = $row->addItem(new EaseHtmlDivTag(null, null, array('class' => 'col-md-4')));
        $this->column2 = $row->addItem(new EaseHtmlDivTag(null, null, array('class' => 'col-md-4')));
        $this->column3 = $row->addItem(new EaseHtmlDivTag(null, null, array('class' => 'col-md-4')));
    }

    static function _format_bytes($a_bytes)
    {
        if ($a_bytes < 1024) {
            return $a_bytes . ' B';
        } elseif ($a_bytes < 1048576) {
            return round($a_bytes / 1024, 2) . ' KiB';
        } elseif ($a_bytes < 1073741824) {
            return round($a_bytes / 1048576, 2) . ' MiB';
        } elseif ($a_bytes < 1099511627776) {
            return round($a_bytes / 1073741824, 2) . ' GiB';
        } elseif ($a_bytes < 1125899906842624) {
            return round($a_bytes / 1099511627776, 2) . ' TiB';
        } elseif ($a_bytes < 1152921504606846976) {
            return round($a_bytes / 1125899906842624, 2) . ' PiB';
        } elseif ($a_bytes < 1180591620717411303424) {
            return round($a_bytes / 1152921504606846976, 2) . ' EiB';
        } elseif ($a_bytes < 1208925819614629174706176) {
            return round($a_bytes / 1180591620717411303424, 2) . ' ZiB';
        } else {
            return round($a_bytes / 1208925819614629174706176, 2) . ' YiB';
        }
    }

}

/**
 * Vršek stránky
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class VSPageTop extends EaseHtmlDivTag
{

    /**
     * Titulek stránky
     * @var type
     */
    public $pageTitle = 'Page Heading';

    /**
     * Nastavuje titulek
     *
     * @param string $pageTitle
     */
    function __construct($pageTitle = null)
    {
        parent::__construct('header');
        if ($pageTitle) {
            EaseShared::webPage()->setPageTitle($pageTitle);
        }
    }

    /**
     * Vloží vršek stránky a hlavní menu
     */
    function finalize()
    {
        $this->addItem(new VSMainMenu('menu', 'Vitex Software'));
    }

}

/**
 * Hlavní menu
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class VSMainMenu extends EaseTWBNavbar
{

    /**
     * Menu aplikace
     *
     *
     * @param type $name
     * @param type $Brand
     * @param type $Properties
     */
    function __construct($name = null, $Brand = null, $Properties = null)
    {
        parent::__construct($name, $Brand, $Properties);

        $this->addMenuItem(new EaseHtmlATag('repos.php', '<img style="height: 19px;" src="img/deb-package.png"> ' . _('Repo')));

        $this->addDropDownMenu(
            _('Projekty'), array(
          'http://h.v.s.cz/' => _('Hosting'),
          'monitoring.php' => _('Monitoring'),
          'ease.php' => _('PHP Ease Framework'),
          'moloch.php' => _('Fakturační systém Moloch'),
          'http://privator.eu/' => _('Privator.eu'),
          'tbpackage.php' => _('Twitter Bootstrap pro Debian'),
          'imap2mx.php' => _('Imap2MX webmail plugins')//,
//                'easeshop.php' => _('elektronický obchod Ease Shop'),
//                'moloch.php' =>  _('Fakturační systém Moloch')
            )
        );


//$nav->addMenuItem(new EaseHtmlATag('monitoring.php', _('Monitoring')));
        $this->addMenuItem(new EaseHtmlATag('reference.php', _('Reference')));
        $this->addMenuItem(new EaseHtmlATag('cenik.php', _('Ceník')));
        $this->addMenuItem(new EaseHtmlATag('kontakt.php', _('Kontakt')));
    }

}

/**
 * Spodek stránky
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class VSPageBottom extends EaseTWBContainer
{

    public function __construct($content = null)
    {
        parent::__construct($content);
        $this->SetTagID('footer');
        $this->addItem('<hr>');

        $rowFluid1 = new EaseTWBRow;
        $colA = $rowFluid1->addItem(new EaseTWBCol(2));
        $listA1 = $colA->addItem(new EaseHtmlUlTag(_('Zdrojáky'), array('style' => 'list-style-type: none')));
        $listA1->addItemSmart(new EaseHtmlATag('/redmine', 'Redmine'));
        $listA1->addItemSmart(new EaseHtmlATag('https://github.com/Vitexus', 'GitHub'));


        $colB = $rowFluid1->addItem(new EaseTWBCol(2));
        $listB1 = $colB->addItem(new EaseHtmlUlTag(_('Aplikace'), array('style' => 'list-style-type: none')));
        $listB1->addItemSmart(new EaseHtmlATag('ease.php', 'Ease Framework'));
        $listB1->addItemSmart(new EaseHtmlATag('monitoring.php', 'Icinga Editor'));
        $listB1->addItemSmart(new EaseHtmlATag('moloch.php', 'Moloch'));

        $colC = $rowFluid1->addItem(new EaseTWBCol(2));
        $listC1 = $colC->addItem(new EaseHtmlUlTag(_('Služby'), array('style' => 'list-style-type: none')));
        $listC1->addItemSmart(new EaseHtmlATag('monitoring.php', 'Monitoring'));
        $listC1->addItemSmart(new EaseHtmlATag('repos.php', _('Repozitář')));
        $listC1->addItemSmart(new EaseHtmlATag('http://h.v.s.cz/', _('Hosting')));

        $colD = $rowFluid1->addItem(new EaseTWBCol(2));
        $listD1 = $colD->addItem(new EaseHtmlUlTag(_('Dokumentace'), array('style' => 'list-style-type: none')));
        $listD1->addItemSmart(new EaseHtmlATag('/EaseDoc', 'Ease Framework'));
        $listD1->addItemSmart(new EaseHtmlATag('/IciEditDoc', 'Icinga Editor'));

        $colE = $rowFluid1->addItem(new EaseTWBCol(2));
        $listE1 = $colE->addItem(new EaseHtmlUlTag(_('Spřízněné'), array('style' => 'list-style-type: none')));
        $listE1->addItemSmart(new EaseHtmlATag('http://murka.cz', _('Murka.cz')));
        $listE1->addItemSmart(new EaseHtmlATag('http://spoje.net', _('Spoje.Net')));
        $listE1->addItemSmart(new EaseHtmlATag('http://rclick.cz', _('Rclick.cz')));

        $colF = $rowFluid1->addItem(new EaseTWBCol(2));
        $listF1 = $colF->addItem(new EaseHtmlUlTag(_('Více'), array('style' => 'list-style-type: none')));
        $listF1->addItemSmart(new EaseHtmlATag('reference.php', _('Reference')));
        $listF1->addItemSmart(new EaseHtmlATag('cenik.php', _('Cenník prací')));
        $listF1->addItemSmart(new EaseHtmlATag('kontakt.php', _('Kontakty')));


        $this->addItem($rowFluid1);

        $rowFluid2 = new EaseTWBRow;

        $socialIcons = '
        <a class = "btn btn-primary social-login-btn social-facebook" href = "https://www.facebook.com/vitexsoftware"><i class = "fa fa-facebook"></i></a>
        <a class = "btn btn-primary social-login-btn social-twitter" href = "https://twitter.com/Vitexus"><i class = "fa fa-twitter"></i></a>
        <a class = "btn btn-primary social-login-btn social-linkedin" href = "https://www.linkedin.com/in/vitexsoftware"><i class = "fa fa-linkedin"></i></a>
        <a class = "btn btn-primary social-login-btn social-google" href = "https://plus.google.com/100397009727603037623"><i class = "fa fa-google-plus"></i></a>
        <a class = "btn btn-primary social-login-btn social-github" href = "https://github.com/Vitexus/"><i class = "fa fa-github"></i></a>
        ';

        $rowFluid2->addItem(new EaseTWBCol(12, array(new EaseTWBCol(8, $socialIcons), new EaseTWBCol(4, _('&copy; 2012-2015 Vitex Software')))));

        $this->addItem($rowFluid2);
    }

    /**
     * Zobrazí přehled právě přihlášených a spodek stránky
     */
    function finalize()
    {
        if (isset($this->webPage->heroUnit) && !count($this->webPage->heroUnit->pageParts)) {
            unset($this->webPage->container->pageParts['EaseHtmlDivTag@heroUnit']);
        }

        $this->includeCss('css/font-awesome.min.css');
    }

}

/**
 * Like Button Facebooku
 */
class VSFBLikeButton extends EaseHtmlIframeTag
{

    /**
     * Like Button facebooku
     *
     * @param string $Src Url pro lajk facebooku
     */
    function __construct($Src)
    {
        $Properties['scrcolling'] = 'no';
        $Properties['frameborder'] = 'no';
        parent::__construct('http://www.facebook.com/plugins/like.php?href=' . $Src, $Properties);
    }

}
