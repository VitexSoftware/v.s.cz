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
 * Wide promotional banner highlighting a flagship product on the homepage.
 */
class PromoBanner extends \Ease\Html\DivTag
{
    public function __construct(string $title, string $tagline, string $iconSrc, string $url, ?string $ctaLabel = null)
    {
        parent::__construct(null, ['class' => 'promo-banner d-flex align-items-stretch']);

        $ctaLabel ??= _('Learn more');

        $icon = new \Ease\Html\ImgTag($iconSrc, $title, [
            'alt' => $title,
            'style' => 'width:110px;height:110px;object-fit:contain;',
        ]);

        $iconWrap = new \Ease\Html\DivTag(
            new \Ease\Html\ATag($url, $icon),
            ['class' => 'flex-shrink-0 d-flex align-items-center justify-content-center p-3'],
        );

        $body = new \Ease\Html\DivTag(
            [
                new \Ease\Html\H2Tag(
                    new \Ease\Html\ATag($url, $title, ['class' => 'text-dark text-decoration-none']),
                    ['class' => 'mb-1'],
                ),
                new \Ease\Html\PTag($tagline, ['class' => 'mb-2']),
                new \Ease\TWB5\LinkButton($url, $ctaLabel.' &raquo;', 'primary'),
            ],
            ['class' => 'flex-grow-1 p-3'],
        );

        $this->addItem($iconWrap);
        $this->addItem($body);
    }
}
