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
 * Page TOP.
 */
class PageTop extends \Ease\Html\DivTag
{
    /**
     * Titulek stránky.
     */
    public string $pageTitle = '';

    /**
     * Nastavuje titulek.
     *
     * @param string $pageTitle
     */
    public function __construct($pageTitle = '')
    {
        parent::__construct();

        if ($pageTitle) {
            \Ease\WebPage::singleton()->setPageTitle($pageTitle);
        }

        $this->setTagID('header');
    }

    /**
     * Vloží vršek stránky a hlavní menu.
     */
    public function finalize(): void
    {
        if ($this->finalized()) {
            return;
        }

        $this->addItem(new MainMenu('menu', '<img src="img/vstux.png" alt="" width="36" height="36" class="brand-logo"><span class="brand-name"><b>Vitex</b> Software</span>'));
        $this->finalized(true);
    }
}
