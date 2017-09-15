<?php
/**
 * VitexSoftware - monitoring
 *
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
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
    if (!is_null($id)) {
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

