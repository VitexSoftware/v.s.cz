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
 * Description of SlideImage.
 *
 * @author vitex
 */
class SlideImage extends \Ease\Html\DivTag
{
    public function __construct($img, $label)
    {
        parent::__construct(
            new \Ease\Html\ImgTag(
                $img,
                $label,
                ['class' => 'img-responsive', 'style' => ' display: block; margin-left: auto;margin-right: auto;'],
            ),
            ['style' => 'padding-bottom: 200px;'],
        );
    }
}
