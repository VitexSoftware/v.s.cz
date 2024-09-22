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

namespace VSCZ\ui;

/**
 * Description of NewsShow.
 *
 * @author vitex
 */
class NewsListing extends \Ease\Html\UlTag
{
    public function __construct($datasource, $authorId = null)
    {
        $news = $datasource->listingQuery(); // ->orderBy('id DESC');

        if (null !== $authorId) {
            $news->where('author.id', $authorId);
        }

        if (\count($news)) {
            foreach ($news as $article) {
                $this->addItemSmart(new \Ease\Html\ATag(
                    'article.php?id='.$article['id'],
                    $article['title'],
                ));
            }
        } else {
            $this->addItem(new \Ease\TWB4\Label('warning', _('No articles')));
        }
    }
}
