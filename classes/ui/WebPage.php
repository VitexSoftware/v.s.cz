<?php

namespace VSCZ\ui;

/**
 * Třídy pro vykreslení stránky
 *
 * @package   VitexSoftware
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2019 Vitex@hippy.cz (G)
 */
class WebPage extends \Ease\TWB4\WebPage {

    public $bootstrapThemeCSS = 'css/freelancer.min.css';

    /**
     *
     * @var \Ease\TWB4\Container 
     */
    public $container = null;

    /**
     * Základní objekt stránky
     */
    function __construct() {
        parent::__construct('Vitex Software');
        $this->includeCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css');
        $this->includeCss('css/freelancer.min.css');
        $this->includeCss('css/default.css');
        $this->includeCSS('css/github-activity.css');

        $this->head->addItem('<link rel="icon" type="image/png" href="img/tux-server.png" />');
        $this->head->addItem('<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">');
        $this->head->addItem('<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php">');

        $this->body->setTagID('page-top');
        $this->container = $this->addItem(new \Ease\TWB4\Container(new \Ease\Html\DivTag('<p><br clear="all"><br clear="all"></p>')));
        $this->container->setTagClass('container-fluid');
    }

    /**
     * Timestap to time convertor
     * 
     * @param int|long $seconds
     * 
     * @return Date
     */
    public static function secondsToTime($seconds) {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@$seconds");
        return $dtF->diff($dtT)->format('%a');
    }

    /**
     * Only Admin can continue
     */
    function onlyForAdmin() {
        if (!\Ease\Shared::user()->getSettingValue('admin')) {
            $this->addStatusMessage(_('Only for admin'), 'warning');
            $this->redirect('login.php');
            exit();
        }
    }

}
