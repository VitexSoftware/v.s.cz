<?php

/**
 * VitexSoftware - install helper
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2018 Vitex@hippy.cz (G)
 */

$package = $_REQUEST['package'];

header('Location: apt:' . $package);


echo _('Installing Package  - If your install does not start automatically, type in terminal');
echo "<p><br/></p>";
echo '              sudo apt-get install ' . $package;
