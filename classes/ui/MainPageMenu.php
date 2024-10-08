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

class MainPageMenu extends \Ease\TWB5\Widgets\MainPageMenu
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
     * @param string     $url
     * @param string     $title
     * @param string     $description
     * @param string     $image
     * @param null|mixed $packagist
     *
     * @return \Ease\TWB5\Col
     */
    public function addLibraryItem($url, $title, $description, $image = null, $packagist = null)
    {
        $gitHubURL = str_replace('https://github.com/', '', $url);
        $vendorProject = substr(parse_url($url, \PHP_URL_PATH), 1);
        $packagist = null === $packagist ? str_replace(['spoje-net', 'php-flexibee'], ['spoje.net', 'flexibee'], strtolower($vendorProject)) : $packagist;

        if (null === $image) {
            $image = 'img/'.basename($vendorProject).'.svg';
        }

        $this->includeJavaScript('https://buttons.github.io/buttons.js');

        $bottom = [new \Ease\Html\DivTag([
            new \Ease\Html\ATag(
                $url,
                _('Star'),
                [
                    'class' => 'github-button',
                    'data-icon' => 'octicon-star',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size' => 'large',
                    'data-show-count' => 'true',
                    'aria-label' => _(sprintf('Star %s on GitHub', $gitHubURL)),
                ],
            ),
            '&nbsp;',
            new \Ease\Html\ATag(
                $url.'/fork',
                _('Fork'),
                [
                    'class' => 'github-button',
                    'data-icon' => 'octicon-repo-forked',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size' => 'large', 'data-show-count' => 'true',
                    'aria-label' => _(sprintf('Fork %s on GitHub', $gitHubURL)),
                ],
            ),
            '<br clear="all"/>',
            new PackagistBadge($vendorProject, $packagist, 'v'),
            '<br>',
            new PackagistBadge($vendorProject, $packagist, 'dt'),
        ], ['class' => 'card-footer'])];

        $icon = new \Ease\Html\ImgTag($image, $title, ['alt' => $title, 'class' => 'card-img-top']);
        $cardHeader = new \Ease\Html\DivTag(new \Ease\Html\StrongTag($title), ['class' => 'card-header text-dark']);
        $cardBody = new \Ease\Html\DivTag(new \Ease\Html\PTag($description, ['class' => 'card-text text-dark']), ['class' => 'card-body', 'style' => 'align-text-bottom']);
        $menuCard = new \Ease\TWB5\Card([new \Ease\Html\ATag($url, $cardHeader), new \Ease\Html\ATag($url, $icon), $cardBody, $bottom], ['class' => 'text-white bg-light mp-menu-item ']);

        return $this->addItem(new \Ease\TWB5\Col(3, $menuCard));
    }

    /**
     * @param string $composerPath
     *
     * @return string
     */
    public static function composerVersion($composerPath)
    {
        return sprintf(_('Current version %s'), file_exists($composerPath) ? json_decode(file_get_contents($composerPath))->version : 'n/a');
    }
}
