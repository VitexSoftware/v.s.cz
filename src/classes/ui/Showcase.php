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
 * Grid of product cards with the addSlide() API of the removed Ease\TWB5\Carousel.
 */
class Showcase extends \Ease\Html\DivTag
{
    public function __construct(array $properties = [])
    {
        $properties['class'] = trim('showcase '.($properties['class'] ?? ''));
        parent::__construct(null, $properties);
    }

    /**
     * @param mixed  $image   picture (e.g. SlideImage)
     * @param string $title   card title
     * @param mixed  $content description, buttons…
     */
    public function addSlide($image, $title = '', $content = null): \Ease\Html\DivTag
    {
        return $this->addItem(new \Ease\Html\DivTag([
            new \Ease\Html\DivTag($image, ['class' => 'showcase-img']),
            new \Ease\Html\DivTag([new \Ease\Html\H3Tag($title), $content], ['class' => 'showcase-body']),
        ], ['class' => 'showcase-card glass-card']));
    }
}
