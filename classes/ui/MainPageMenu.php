<?php
/**
 * Flexplorer - Menu hlavní stránky.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace VSCZ\ui;

class MainPageMenu extends \Ease\TWB4\Widgets\MainPageMenu
{

    public function addMenuItem($image, $title, $url, $hint = null,
                                $version = null)
    {
        return parent::addMenuItem($title, $url, $image, $hint, empty($version) ? null : _('View').' '._('Version').': '.$version );
    }

}
