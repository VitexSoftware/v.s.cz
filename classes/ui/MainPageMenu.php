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

    
//    ($title, $url, $image, $description, $buttonText = NULL, $properties = Array) 
//    
//    public function addMenuItem($image, $title, $url, $hint = null,
//                                $version = null)
//    {
//        return parent::addMenuItem($title, $url, $image, $hint,
//                empty($version) ? null : _('View').' '._('Version').': '.$version);
//    }

    /**
     * 
     * @param type $url
     * @param type $title
     * @param type $description
     * @param string $image
     * 
     * @return type
     */
    public function addLibraryItem($url, $title, $description, $image = null)
    {
        $vendorProject = substr(parse_url($url, PHP_URL_PATH),1);
        $packagist     = str_replace(['spoje-net','php-flexibee'], ['spoje.net','flexibee'], strtolower($vendorProject));
        if (is_null($image)) {
            $image = 'img/'.basename($vendorProject).'.svg';
        }
        
        $libItem = parent::addMenuItem($title, $url, $image, $description, $vendorProject, ['class'=>'text-white bg-secondary'] );
        
        $libItem->addItem(new PackagistBadge($vendorProject, $packagist, 'v'));
        $libItem->addItem(new PackagistBadge($vendorProject, $packagist, 'dt'));
        
        return $libItem;
    }
    
}
