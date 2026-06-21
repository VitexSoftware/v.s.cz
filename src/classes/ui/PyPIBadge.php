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

class PyPIBadge extends \Ease\Html\ATag
{
    public string $baseUrl = 'https://pypi.org/project/';

    /**
     * @param string $package    PyPI package name
     * @param string $type       v (version) | dm (monthly downloads)
     * @param array  $properties
     */
    public function __construct(string $package, string $type = 'dm', array $properties = [])
    {
        $label = match ($type) {
            'v'  => _('PyPI Version'),
            'dm' => _('PyPI Downloads'),
            default => 'PyPI',
        };

        parent::__construct(
            $this->baseUrl.$package.'/',
            new ShieldsBadge('pypi/'.$type.'/'.$package, $label),
            $properties,
        );
    }
}
