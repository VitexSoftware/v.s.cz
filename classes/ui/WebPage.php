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

namespace VSCZ\ui;

/**
 * Třídy pro vykreslení stránky.
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2019 Vitex@hippy.cz (G)
 */
class WebPage extends \Ease\TWB5\WebPage
{
    public string $bootstrapThemeCSS = 'css/freelancer.min.css';
    public \Ease\TWB5\Container $container;
    public $column1;
    public $column2;
    public $column3;

    /**
     * Základní objekt stránky.
     */
    public function __construct()
    {
        parent::__construct('Vitex Software');
        $this->includeCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');
        $this->includeCss('css/freelancer.min.css');
        $this->includeCss('css/default.css');
        $this->includeCSS('css/github-activity.css');

        $this->head->addItem('<link rel="icon" type="image/png" href="img/tux-server.png" />');
        $this->head->addItem('<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">');
        $this->head->addItem('<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php">');

        $this->body->setTagID('page-top');
        $this->container = $this->addItem(new \Ease\TWB5\Container(new \Ease\Html\DivTag('<p><br clear="all"><br clear="all"></p>')));
        $this->container->setTagClass('container-fluid');
    }

    /**
     * Timestap to time convertor.
     *
     * @param int|long $seconds
     *
     * @return Date
     */
    public static function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@{$seconds}");

        return $dtF->diff($dtT)->format('%a');
    }

    /**
     * Only Admin can continue.
     */
    public function onlyForAdmin(): void
    {
        if (!\Ease\Shared::user()->getSettingValue('admin')) {
            $this->addStatusMessage(_('Only for admin'), 'warning');
            $this->redirect('login.php');

            exit;
        }
    }
}
