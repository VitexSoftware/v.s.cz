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
 * Vršek stránky.
 *
 * @author     Vitex <vitex@hippy.cz>
 */
class PageTop extends \Ease\Html\DivTag
{
    /**
     * Titulek stránky.
     */
    public string $pageTitle = 'Page Heading';

    /**
     * Nastavuje titulek.
     *
     * @param string $pageTitle
     */
    public function __construct($pageTitle = null)
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
        $this->addItem(new MainMenu('menu', new \Ease\Html\ATag('https://vitexsoftware.cz/', 'Vitex Software')));
    }
}
