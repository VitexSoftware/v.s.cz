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

namespace VSCZ;

use VSCZ\ui\NewPackages;

/**
 * VitexSoftware - RSS Feed.
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012-2021 Vitex@hippy.cz (G)
 */

require_once 'includes/VSInit.php';

$packages = [['title' => 'n/a', 'description' => '', 'icon' => '', 'date' => '']]; // TODO:  new NewPackages();

// header("Content-Type: application/xml; charset=UTF-8");
header('Content-Type: application/rss+xml; charset=UTF-8');

$xml = new \SimpleXMLElement('<rss/>');
$xml->addAttribute('version', '2.0');

$channel = $xml->addChild('channel');

$channel->addChild('title', _('VitexSoftware Package feed'));
$channel->addChild('link', 'https://vitexsoftware.com/');
$channel->addChild('description', 'Fresh packages in our repository');
$channel->addChild('language', 'en-us');

foreach ($packages->getRssData(\Ease\WebPage::getRequestValue('search')) as $entry) {
    $item = $channel->addChild('item');

    $item->addChild('title', $entry['title']);
    $item->addChild('link', 'https://vitexsoftware.cz/'.$entry['link']);
    $item->addChild('description', $entry['description']);
    $item->addChild('pubDate', $entry['date']);

    $enclosure = $item->addChild('enclosure');
    $enclosure->addAttribute('url', $entry['icon']);
    $enclosure->addAttribute('type', mime_content_type($entry['icon']));
}

echo $xml->asXML();
