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
    function __construct($datasource, $authorId = null)
    {
        $news = $datasource->listingQuery(); //->orderBy('id DESC');
        if (!is_null($authorId)) {
            $news->where('author.id', $authorId);
        }

        if (count($news)) {
            foreach ($news as $article) {
                $this->addItemSmart(new \Ease\Html\ATag(
                    'article.php?id=' . $article['id'],
                    $article['title']
                ));
            }
        } else {
            $this->addItem(new \Ease\TWB4\Label('warning', _('No articles')));
        }
    }
}
