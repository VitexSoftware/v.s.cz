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

date_default_timezone_set('Europe/Prague');

\define('EASE_APPNAME', 'vsweb');
\define('EASE_LOGGER', 'syslog');

/**
 * Adresa odesilatele.
 */
\define('SEND_MAILS_FROM', 'noreply@vitexsoftware.cz');

/**
 * Databázový pro logy.
 */
\define('STATS_SERVER', 'localhost');
\define('STATS_USERNAME', 'apache');
\define('STATS_PASSWORD', 'TeacPets4');
\define('STATS_DATABASE', 'apachelogs');
\define('STATS_TYPE', 'mysql');
\define('STATS_PORT', '3306');

/**
 * Adresář pro zápis logů.
 */
\define('LOG_DIRECTORY', '/var/tmp/');

\define('DB_TYPE', 'mysql');
\define('DB_HOST', 'localhost');
\define('DB_PORT', '3306');
\define('DB_DATABASE', 'vitexsoftware');
\define('DB_USERNAME', 'vitexsoftware');
\define('DB_PASSWORD', 'TusVecFer.ow5');
