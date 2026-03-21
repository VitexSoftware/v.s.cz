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
class NewsShow extends \Ease\Container
{
    /**
     * Show news on page.
     *
     * @param \VSCZ\News $datasource
     * @param int        $id         Only Author with id
     * @param null|mixed $authorId
     */
    public function __construct($datasource, $id = null, $authorId = null)
    {
        parent::__construct();
        $news = $datasource->listingQuery();

        if (null !== $authorId) {
            $news->where('author.id', $authorId);
        }

        if (null !== $id) {
            $news->where('news.id', $id);
        }

        if (\count($news)) {
            foreach ($news as $article) {
                $articletext = $this->addItem(new \Ease\Html\DivTag(
                    new \Ease\Html\H1Tag($article['title']),
                    ['class' => 'smokeback'],
                ));
                $articletext->addItem(new \Ease\Html\DivTag($article['text']));
                $articletext->addItem(new \Ease\Html\DivTag('<hr><div style="text-align: right"><small>'.$article['login'].' '.strftime(
                    '%d/%m/%y',
                    strtotime($article['DatCreate']),
                ).'</small></div>'));
            }
        } else {
            $this->addItem(new \Ease\TWB5\Label('warning', _('No articles')));
        }
    }
}
