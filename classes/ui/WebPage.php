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
        \Ease\Shared::webPage()->head->addItem('<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">');
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
        $this->container = $this->addItem(new \Ease\TWB\Container());
        $row             = $this->container->addItem(new \Ease\TWB\Row());
        $this->column1   = $row->addItem(new \Ease\Html\DivTag(null,
            ['class' => 'col-md-4']));
        $this->column2   = $row->addItem(new \Ease\Html\DivTag(null,
            ['class' => 'col-md-4']));
        $this->column3   = $row->addItem(new \Ease\Html\DivTag(null,
            ['class' => 'col-md-4']));
    }

    static function _format_bytes($a_bytes)
    {
        $a_bytes = doubleval($a_bytes);
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

    public static function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a');
    }

    /**
     * Only Admin can continue
     */
    function onlyForAdmin()
    {
        if (!\Ease\Shared::user()->getSettingValue('admin')) {
            $this->addStatusMessage(_('Only for admin'), 'warning');
            $this->redirect('login.php');
            exit();
        }
    }
}
