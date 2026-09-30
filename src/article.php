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

$oPage->addItem(new ui\PageTop(_('Article')));

$oPage->container->addItem(new ui\NewsShow(new News(), $oPage->getRequestValue('id', 'int')));

$oPage->container->addItem(
    new \Ease\Html\DivTag(
        new \Ease\TWB5\LinkButton(
            'articles.php?locale='.rawurlencode(\Ease\Locale::singleton()->getLocaleUsed() ?? 'en_US'),
            '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="mb-1 me-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/></svg> '._('Back to articles'),
            'outline-secondary',
        ),
        ['class' => 'container pb-4'],
    ),
);

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
