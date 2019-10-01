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
        return parent::addMenuItem($title, $url, $image, $hint,
                empty($version) ? null : _('View').' '._('Version').': '.$version);
    }

    public function addLibraryItem($url, $title, $description, $image = null)
    {
        $vendorProject = substr(parse_url($url, PHP_URL_PATH),1);
        $packagist     = strtolower($vendorProject);
        if (is_null($image)) {
            $image = basename($vendorProject).'.png';
        }
        
        $libItem = parent::addMenuItem($title, $url, $image, $description, $vendorProject );
        
        $libItem->addItem(new PackagistBadge($vendorProject, $packagist, 'v'));
        $libItem->addItem(new PackagistBadge($vendorProject, $packagist, 'dt'));
        
        return $libItem;
    }
    
}
