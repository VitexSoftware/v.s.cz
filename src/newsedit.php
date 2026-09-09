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

// Ease\SQL\Engine's default identifier handling only sets the key column
// (useIdentifier()) -- it never actually fetches the row, which is why
// editing an existing article opened an empty form. loadFromSQL()/the
// 'autoload' option would fetch it, but both build an unqualified
// "WHERE id = ..." that's ambiguous against News::listingQuery()'s join
// with user. Load it explicitly with a qualified column instead.
$news = new News();

if ($id) {
    $newsRow = $news->getColumnsFromSQL(['news.*'], ['news.id' => $id]);

    if (!empty($newsRow)) {
        $news->takeData($newsRow[0]);
    }
}

if ($oPage->isPosted()) {
    $news->takeData($_POST);

    if (!$news->getMyKey()) {
        // The hidden "id" field posts as an empty string for a new,
        // unsaved article -- insertToSQL() would otherwise try to
        // insert that literal '' into the int auto_increment column.
        $news->unsetDataValue('id');
        $news->setDataValue('author', \Ease\Shared::user()->getUserID());
    }

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
