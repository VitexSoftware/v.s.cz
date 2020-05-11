<?php

/**
 * Flexplorer - Menu hlavní stránky.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace VSCZ\ui;

class MainPageMenu extends \Ease\TWB4\Widgets\MainPageMenu {
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
     * 
     * @param string $url
     * @param string $title
     * @param string $description
     * @param string $image
     * 
     * @return \Ease\TWB4\Col
     */
    public function addLibraryItem($url, $title, $description, $image = null, $packagist = null) {
        $vendorProject = substr(parse_url($url, PHP_URL_PATH), 1);
        $packagist = is_null($packagist) ? str_replace(['spoje-net', 'php-flexibee'], ['spoje.net', 'flexibee'], strtolower($vendorProject)) : $packagist;
        if (is_null($image)) {
            $image = 'img/' . basename($vendorProject) . '.svg';
        }

        $this->includeJavaScript("https://buttons.github.io/buttons.js");


        $bottom = [new \Ease\Html\DivTag([
                new \Ease\Html\ATag($url, _('Star'),
                        [
                    'class' => "github-button",
                    'data-icon' => "octicon-star",
                    'data-color-scheme' => "no-preference: dark; light: dark; dark: dark;",
                    'data-size' => "large",
                    'data-show-count' => 'true',
                    'aria-label' => _(sprintf("Star %s on GitHub", str_replace('https://github.com/', '', $url)))
                        ]),
                new \Ease\Html\ATag($url . '/fork', _('Fork'),
                        [
                    'class' => "github-button",
                    'data-icon' => "octicon-repo-forked",
                    'data-color-scheme' => "no-preference: dark; light: dark; dark: dark;",
                    'data-size' => "large", 'data-show-count' => 'true',
                    'aria-label' => _(sprintf("Fork %s on GitHub", str_replace('https://github.com/', '', $url)))
                        ]),
                '<br clear="all"/>',
                new PackagistBadge($vendorProject, $packagist, 'v'),
                new PackagistBadge($vendorProject, $packagist, 'dt'),
                    ], ['class' => 'card-footer'])];

        $icon = new \Ease\Html\ImgTag($image, $title, ['alt' => $title, 'class' => 'card-img-top']);
        $cardHeader = new \Ease\Html\DivTag($title, ['class' => 'card-header']);
        $cardBody = new \Ease\Html\DivTag(new \Ease\Html\PTag($description, ['class' => 'card-text']), ['class' => 'card-body']);
        $menuCard = new \Ease\TWB4\Card([$cardHeader, $icon, $cardBody, $bottom], ['class' => 'text-white bg-secondary']);

        return $this->addItem(new \Ease\TWB4\Col(3, $menuCard));
    }

}
