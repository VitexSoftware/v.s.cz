<?php

namespace VSCZ;

/**
 * VitexSoftware - titulní strana
 *
 * @package    VS
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 * @copyright  2012 Vitex@hippy.cz (G)
 */
//if (!strstr($_SERVER['SERVER_NAME'], 'www.vitexsoftware.cz') || ($_SERVER['SERVER_PORT'] != 443)) {
//    header('Location: https://www.vitexsoftware.cz/');
//    exit;
//}

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Articles')));
$oPage->addPageColumns();

$oPage->container->addItem(new \Ease\TWB4\Well([new ui\NewsShow(new ui\News(),
        $oPage->getRequestValue('id', 'int')),
    new \Ease\TWB4\LinkButton('articles.php',
        '<img src="img/news.svg" style="height: 20px"> '._('More articles').' <i class="fa fa-angle-double-right" aria-hidden="true"></i>',
        'info')]));

$oPage->addItem(new \VSCZ\ui\PageBottom());


$oPage->draw();

