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
class NewsShow extends \Ease\Container
{

    function __construct($datasource, $id = null)
    {
        parent::__construct();
        $query = 'SELECT * FROM '.$datasource->getMyTable().' a LEFT JOIN `user` ON `user`.id = author';
        if (!is_null($id)) {
            $query .= ' WHERE a.id='.$id;
        }

        $news = $datasource->dblink->queryToArray($query, 'id', 'id');
        if (count($news)) {
            foreach ($news as $article) {

                $articletext = $this->addItem(new \Ease\Html\Div(new \Ease\Html\H1Tag($article['title']),
                    ['class' => 'smokeback']));
                $articletext->addItem(new \Ease\Html\Div($article['text']));
                $articletext->addItem(new \Ease\Html\Div('<hr><div style="text-align: right"><small>'.$article['login'].' '.strftime("%d/%m/%Y %H:%M:%S",
                        strtotime($article['DatCreate'])).'</small></div>'));
            }
        } else {
            $this->addItem(new \Ease\TWB\Label('warning', _('No articles')));
        }
    }
}
