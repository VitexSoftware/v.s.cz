<?php

namespace VSCZ\ui;

/**
 * Třídy pro vykreslení stránky
 *
 * @package   VitexSoftware
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2016 Vitex@hippy.cz (G)
 */
class WebPage extends \Ease\TWB\WebPage
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
        \Ease\Shared::webPage()->head->addItem('<link rel="icon" type="image/png"
 href="img/tux-server.png" />');
        \Ease\Shared::webPage()->head->addItem('<script type="text/javascript">
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
        $this->container = $this->addItem(new \Ease\Html\Div(null,
            array('class' => 'container')));
        $row             = $this->container->addItem(new \Ease\Html\Div(
            null, array('class' => 'row')));
        $this->column1   = $row->addItem(new \Ease\Html\Div(null,
            array('class' => 'col-md-4')));
        $this->column2   = $row->addItem(new \Ease\Html\Div(null,
            array('class' => 'col-md-4')));
        $this->column3   = $row->addItem(new \Ease\Html\Div(null,
            array('class' => 'col-md-4')));
    }

    static function _format_bytes($a_bytes)
    {
        if ($a_bytes < 1024) {
            return $a_bytes.' B';
        } elseif ($a_bytes < 1048576) {
            return round($a_bytes / 1024, 2).' KiB';
        } elseif ($a_bytes < 1073741824) {
            return round($a_bytes / 1048576, 2).' MiB';
        } elseif ($a_bytes < 1099511627776) {
            return round($a_bytes / 1073741824, 2).' GiB';
        } elseif ($a_bytes < 1125899906842624) {
            return round($a_bytes / 1099511627776, 2).' TiB';
        } elseif ($a_bytes < 1152921504606846976) {
            return round($a_bytes / 1125899906842624, 2).' PiB';
        } elseif ($a_bytes < 1180591620717411303424) {
            return round($a_bytes / 1152921504606846976, 2).' EiB';
        } elseif ($a_bytes < 1208925819614629174706176) {
            return round($a_bytes / 1180591620717411303424, 2).' ZiB';
        } else {
            return round($a_bytes / 1208925819614629174706176, 2).' YiB';
        }
    }

}
