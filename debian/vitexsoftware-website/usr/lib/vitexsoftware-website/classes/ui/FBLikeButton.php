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
 * Like Button Facebooku.
 */
class FBLikeButton extends \Ease\Html\IframeTag
{
    /**
     * Like Button facebooku.
     *
     * @param string $src Url pro lajk facebooku
     */
    public function __construct($src)
    {
        $Properties['scrcolling'] = 'no';
        $Properties['frameborder'] = 'no';
        parent::__construct(
            'http://www.facebook.com/plugins/like.php?href='.$src,
            $Properties,
        );
    }
}
