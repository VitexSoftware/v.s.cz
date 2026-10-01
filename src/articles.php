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

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Articles')));

$oPage->container->addItem(new ui\PageHero(
    _('Articles'),
    _('Notes, releases and thoughts from Vitex Software'),
    _('From the workshop'),
));

$lang2    = \Ease\Locale::singleton()->get2Code();
$language = (\in_array($lang2, ['cs', 'en'], true)) ? $lang2 : null;

try {
    $listing = new ui\NewsListing(new News(), null, $language);
    $oPage->container->addItem(
        new \Ease\Html\DivTag(
            $listing,
            ['class' => 'row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4'],
        ),
    );
} catch (\Throwable $e) {
    error_log('articles.php: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    $oPage->container->addItem(new \Ease\TWB5\Alert(
        'warning',
        _('Articles temporarily unavailable.'),
    ));
}

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
