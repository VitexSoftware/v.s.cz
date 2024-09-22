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
 * Description of PackagistBadge.
 *
 * @author vitex
 */
class PackagistBadge extends \Ease\Html\ATag
{
    public $baseUrl = 'https://packagist.org/packages/';

    /**
     * @param string $github
     * @param string $packagist
     * @param string $type       dt|v
     * @param array  $properties
     */
    public function __construct($github, $packagist, $type = 'dt', $properties = [])
    {
        $label = str_replace(['dt', 'v'], [_('Packagist Downloads'), _('Packagist Version')], $type);

        parent::__construct(
            $this->baseUrl.$packagist,
            new ShieldsBadge(
                'packagist/'.$type.'/'.$packagist,
                $label,
            ),
            $properties,
        );
    }
}
