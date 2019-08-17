<?php

namespace VSCZ\ui;

/**
 * Vršek stránky
 *
 * @package    VitexSoftware
 * @subpackage WebUI
 * @author     Vitex <vitex@hippy.cz>
 */
class PageTop extends \Ease\Html\DivTag
{
    /**
     * Titulek stránky
     * @var type
     */
    public $pageTitle = 'Page Heading';

    /**
     * Nastavuje titulek
     *
     * @param string $pageTitle
     */
    function __construct($pageTitle = null)
    {
        parent::__construct();
        if ($pageTitle) {
            \Ease\WebPage::singleton()->setPageTitle($pageTitle);
        }
        $this->setTagID('header');
    }

    /**
     * Vloží vršek stránky a hlavní menu
     */
    function finalize()
    {
        $this->addItem(new MainMenu('menu', 'Vitex Software'));
    }

}

