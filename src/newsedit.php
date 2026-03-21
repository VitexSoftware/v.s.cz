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

$oPage->onlyForAdmin();

$id = $oPage->getRequestValue('id', 'int');

$news = new ui\News($id);

if ($oPage->isPosted()) {
    $news->takeData($_POST);

    if ($news->saveToSQL()) {
        $news->addStatusMessage(_('Article was saved'), 'success');
    } else {
        $news->addStatusMessage(_('Article was not saved'), 'warning');
    }
} else {
    $id = $oPage->getRequestValue('delete', 'int');

    if (null !== $id) {
        if ($news->deleteFromSQL($id)) {
            $news->addStatusMessage(_('Article was deleted'), 'success');
        } else {
            $news->addStatusMessage(_('Article was not deleted'), 'warning');
        }
    }
}

$oPage->addItem(new ui\PageTop(_('Vitex Software news editor')));
$oPage->addPageColumns();

$oPage->container->addItem(new ui\NewsEditor($news));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
