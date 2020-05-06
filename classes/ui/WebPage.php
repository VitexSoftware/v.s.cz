<?php

namespace VSCZ\ui;

/**
 * Třídy pro vykreslení stránky
 *
 * @package   VitexSoftware
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2019 Vitex@hippy.cz (G)
 */
class WebPage extends \Ease\TWB4\WebPage
{
    public $bootstrapThemeCSS = 'css/freelancer.min.css';

    /**
     *
     * @var \Ease\TWB4\Container 
     */
    public $container         = null;

    /**
     * Základní objekt stránky
     */
    function __construct()
    {
        parent::__construct('Vitex Software');
        $this->includeCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');
        $this->includeCss('css/freelancer.min.css');
        $this->includeCss('css/default.css');
        $this->includeCSS('css/github-activity.css');
        
        \Ease\WebPage::singleton()->head->addItem('<link rel="icon" type="image/png" href="img/tux-server.png" />');
        \Ease\WebPage::singleton()->head->addItem('<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">');
        \Ease\WebPage::singleton()->head->addItem('<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-35526048-1\']);
  _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>            ');

        $this->body->setTagID('page-top');
        $this->container = $this->addItem(new \Ease\TWB4\Container(new \Ease\Html\DivTag('<p><br clear="all"><br clear="all"></p>')));
        $this->container->setTagClass('container-fluid');
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
