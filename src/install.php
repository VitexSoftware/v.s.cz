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

$package = (string) ($_REQUEST['package'] ?? '');

// Debian package names only: lower case letters, digits and + - .
if (!preg_match('/^[a-z0-9][a-z0-9+.\-]+$/', $package)) {
    header('Location: debs.php');

    exit;
}

header('Location: apt:'.$package);

echo _('Installing Package  - If your install does not start automatically, type in terminal');
echo '<p><br/></p>';
echo '              sudo apt-get install '.htmlspecialchars($package);
