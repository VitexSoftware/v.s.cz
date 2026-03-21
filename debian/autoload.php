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

require_once '/usr/share/php/Ease/autoload.php';

require_once '/usr/share/php/EaseTWB5/autoload.php';

// Create a simple fallback autoloader
spl_autoload_register(function ($class): void {
    $file = str_replace('\\', '/', $class).'.php';

    if (strpos($class, 'VSCZ\\') === 0) {
        $file = '/usr/lib/vitexsoftware-website/classes/'.substr($file, 5);

        if (file_exists($file)) {
            include $file;
        }
    }
});
