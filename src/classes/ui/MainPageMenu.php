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
    /**
     * Modern horizontal card: icon left, title/description/action right.
     */
    public function addMenuItem($title, $url, $image, $description, $buttonText = null, $properties = []): \Ease\TWB5\Col
    {
        $icon = new \Ease\Html\ImgTag($image, $title, [
            'alt'   => $title,
            'style' => 'width:72px;height:72px;object-fit:contain;',
        ]);

        $iconWrap = new \Ease\Html\DivTag(
            new \Ease\Html\ATag($url, $icon),
            ['class' => 'flex-shrink-0 d-flex align-items-center justify-content-center p-3 border-end', 'style' => 'width:100px;background:#fff;'],
        );

        $body = new \Ease\Html\DivTag(null, ['class' => 'flex-grow-1 p-3']);
        $body->addItem(new \Ease\Html\H5Tag(
            new \Ease\Html\ATag($url, $title, ['class' => 'stretched-link text-dark text-decoration-none']),
            ['class' => 'mb-1'],
        ));
        $body->addItem(new \Ease\Html\PTag($description, ['class' => 'text-muted small mb-0']));

        if ($buttonText !== null) {
            $body->addItem(new \Ease\Html\DivTag($buttonText, ['class' => 'mt-2']));
        }

        $wrap     = new \Ease\Html\DivTag([$iconWrap, $body], ['class' => 'd-flex align-items-stretch']);
        $menuCard = new \Ease\TWB5\Card($wrap, array_merge(['class' => 'mp-menu-item overflow-hidden'], $properties));

        return $this->addItem(new \Ease\TWB5\Col(3, $menuCard));
    }

    /**
     * Horizontal card for library items (GitHub star/fork + registry badges).
     *
     * @param string     $url
     * @param string     $title
     * @param string     $description
     * @param string     $image
     * @param null|mixed $packagist
     *
     * @return \Ease\TWB5\Col
     */
    public function addLibraryItem($url, $title, $description, $image = null, $packagist = null, string $registry = 'packagist')
    {
        $gitHubURL     = str_replace('https://github.com/', '', $url);
        $vendorProject = substr(parse_url($url, \PHP_URL_PATH), 1);
        $packagist     = null === $packagist
            ? str_replace(['spoje-net', 'php-flexibee'], ['spoje.net', 'flexibee'], strtolower($vendorProject))
            : $packagist;

        if (null === $image) {
            $image = 'img/'.basename($vendorProject).'.svg';
        }

        $this->includeJavaScript('https://buttons.github.io/buttons.js');

        $icon = new \Ease\Html\ImgTag($image, $title, [
            'alt'   => $title,
            'style' => 'width:72px;height:72px;object-fit:contain;',
        ]);

        $iconWrap = new \Ease\Html\DivTag(
            new \Ease\Html\ATag($url, $icon),
            ['class' => 'flex-shrink-0 d-flex align-items-center justify-content-center p-3 border-end', 'style' => 'width:100px;background:#fff;'],
        );

        $body = new \Ease\Html\DivTag(null, ['class' => 'flex-grow-1 p-3']);
        $body->addItem(new \Ease\Html\H5Tag(
            new \Ease\Html\ATag($url, $title, ['class' => 'text-dark text-decoration-none']),
            ['class' => 'mb-1'],
        ));
        $body->addItem(new \Ease\Html\PTag($description, ['class' => 'text-muted small mb-2']));

        $body->addItem(new \Ease\Html\DivTag([
            new \Ease\Html\ATag(
                $url,
                _('Star'),
                [
                    'class'             => 'github-button',
                    'data-icon'         => 'octicon-star',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size'         => 'large',
                    'data-show-count'   => 'true',
                    'aria-label'        => _(sprintf('Star %s on GitHub', $gitHubURL)),
                ],
            ),
            '&nbsp;',
            new \Ease\Html\ATag(
                $url.'/fork',
                _('Fork'),
                [
                    'class'             => 'github-button',
                    'data-icon'         => 'octicon-repo-forked',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size'         => 'large',
                    'data-show-count'   => 'true',
                    'aria-label'        => _(sprintf('Fork %s on GitHub', $gitHubURL)),
                ],
            ),
        ], ['class' => 'mb-1']));

        $body->addItem(new \Ease\Html\DivTag([
            $registry === 'pypi'
                ? new PyPIBadge($packagist, 'v')
                : new PackagistBadge($vendorProject, $packagist, 'v'),
            '&nbsp;',
            $registry === 'pypi'
                ? new PyPIBadge($packagist, 'dm')
                : new PackagistBadge($vendorProject, $packagist, 'dt'),
        ]));

        $wrap     = new \Ease\Html\DivTag([$iconWrap, $body], ['class' => 'd-flex align-items-stretch']);
        $menuCard = new \Ease\TWB5\Card($wrap, ['class' => 'mp-menu-item overflow-hidden']);

        return $this->addItem(new \Ease\TWB5\Col(3, $menuCard));
    }

    public function toCarousel(string $id, int $perSlide = 1): CardCarousel
    {
        $carousel = new CardCarousel($id, $perSlide);

        foreach ($this->pageParts as $col) {
            // Unwrap Col wrapper so CardCarousel controls the column layout
            $card = ($col instanceof \Ease\Html\DivTag && !empty($col->pageParts))
                ? reset($col->pageParts)
                : $col;
            $carousel->addCard($card);
        }

        return $carousel;
    }

    /**
     * @param string $composerPath
     *
     * @return string
     */
    public static function composerVersion($composerPath)
    {
        $version = 'n/a';
        if (file_exists($composerPath)) {
            $data    = json_decode(file_get_contents($composerPath));
            $version = $data->version ?? 'n/a';
        }

        return sprintf(_('Current version %s'), $version);
    }
}
