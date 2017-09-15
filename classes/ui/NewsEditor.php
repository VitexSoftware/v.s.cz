<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace VSCZ\ui;

/**
 * Description of NewsEditor
 *
 * @author vitex
 */
class NewsEditor extends \Ease\Html\Div
{
    /**
     * News 
     * @var News 
     */
    public $newsEngine = null;

    /**
     * Articles
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
            $articles = $this->newsEngine->getColumnsFromSQL('*', null, 'id',
                'id');
        } else {
            $articles = $this->newsEngine->dblink->queryToArray('SELECT * FROM '.$this->newsEngine->getMyTable().' WHERE author = '.$oUser->getUserID(),
                'id', 'id');
        }
        $list     = new \Ease\Html\OlTag();
        foreach ($articles as $articleID => $article) {

            $listRow = new \Ease\Html\Span();

            $listRow->addItem(
                new \Ease\Html\ATag('?id='.$articleID, $article['title']));


            $listRow->addItem('&nbsp;(');

            $listRow->addItem(
                new \Ease\TWB\LinkButton('?delete='.$articleID, _('Delete'),
                'warning btn-xs'));

            $listRow->addItem(')');

            $list->addItemSmart($listRow);
        }
        return $list;
    }

    public function finalize()
    {
        $row = new \Ease\TWB\Row();
        $row->addColumn(8, $this->articleForm());
        $row->addColumn(4, $this->articleListing());
        $this->addItem($row);
    }

    public function articleForm()
    {
        $form = new \Ease\TWB\Form('NewsArticle');
        $form->addItem(new \Ease\Html\InputHiddenTag('id',
            $this->newsEngine->getMyKey()));
        $form->addInput(new \Ease\Html\InputTextTag('title'), _('Name'));
        $form->addInput(new WISWYG('text'), _('Text'));
        $form->addInput(new \Ease\Html\Select('language',
            [ 'cs' => _('Czech'), 'en' => _('English')]), _('Language'));
        $form->addItem(new \Ease\TWB\SubmitButton('Ok', 'success'));
        $form->fillUp($this->newsEngine->getData());
        return $form;
    }
}
