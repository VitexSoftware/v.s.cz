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
 * Description of NewsEditor.
 *
 * @author vitex
 */
class NewsEditor extends \Ease\Html\DivTag
{
    /**
     * News.
     */
    public News $newsEngine = null;

    /**
     * Articles.
     *
     * @param News $news
     */
    public function __construct($news)
    {
        parent::__construct();
        $this->newsEngine = $news;
    }

    public function articleListing()
    {
        $oUser = \Ease\Shared::user();

        if ($oUser->getSettingValue('admin')) {
            $articles = $this->newsEngine->getColumnsFromSQL(
                '*',
                null,
                'id',
                'id',
            );
        } else {
            $articles = $this->newsEngine->dblink->queryToArray(
                'SELECT * FROM '.$this->newsEngine->getMyTable().' WHERE author = '.$oUser->getUserID(),
                'id',
                'id',
            );
        }

        $list = new \Ease\Html\OlTag();

        foreach ($articles as $articleID => $article) {
            $listRow = new \Ease\Html\Span();

            $listRow->addItem(
                new \Ease\Html\ATag('?id='.$articleID, $article['title']),
            );

            $listRow->addItem('&nbsp;(');

            $listRow->addItem(
                new \Ease\TWB4\LinkButton(
                    '?delete='.$articleID,
                    _('Delete'),
                    'warning btn-xs',
                ),
            );

            $listRow->addItem(')');

            $list->addItemSmart($listRow);
        }

        return $list;
    }

    public function finalize(): void
    {
        $row = new \Ease\TWB4\Row();
        $row->addColumn(8, $this->articleForm());
        $row->addColumn(4, $this->articleListing());
        $this->addItem($row);
    }

    public function articleForm()
    {
        $form = new \Ease\TWB4\Form('NewsArticle');
        $form->addItem(new \Ease\Html\InputHiddenTag(
            'id',
            $this->newsEngine->getMyKey(),
        ));
        $form->addInput(new \Ease\Html\InputTextTag('title'), _('Name'));
        $form->addInput(new WISWYG('text'), _('Text'));
        $form->addInput(new \Ease\Html\Select(
            'language',
            ['cs' => _('Czech'), 'en' => _('English')],
        ), _('Language'));
        $form->addItem(new \Ease\TWB4\SubmitButton('Ok', 'success'));
        $form->fillUp($this->newsEngine->getData());

        return $form;
    }
}
