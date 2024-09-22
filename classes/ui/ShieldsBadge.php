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
 * Description of ShieldsBadge.
 *
 * @author vitex
 */
class ShieldsBadge extends \Ease\Html\ImgTag
{
    public $baseUrl = 'https://img.shields.io/';
    public $style = 'flat';
    public $format = 'svg';

    public function __construct($image, $alt = null, $tagProperties = [])
    {
        parent::__construct($this->baseUrl.$image.'.'.$this->format.'?colorB=272d32&style=flat&format='.$this->format, $alt, $tagProperties);
    }
}
