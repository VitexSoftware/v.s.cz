<?php
/**
 * VitexSoftware Site
 */

namespace VSCZ\ui;

/**
 * Description of NewsShow
 *
 * @author vitex
 */
class NewsListing extends \Ease\Html\UlTag
{
    function __construct($datasource)
    {

        parent::__construct();
        $news = $datasource->dblink->queryToArray('SELECT id,title FROM '.$datasource->getMyTable().' ORDER BY id DESC',
            'id', 'id');
        if (count($news)) {
            foreach ($news as $article) {
                $this->addItemSmart(new \Ease\Html\ATag('article.php?id='.$article['id'],
                    $article['title']));
            }
        } else {
            $this->addItem(new \Ease\TWB4\Label('warning', _('No articles')));
        }
    }
}
