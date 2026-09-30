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
 * Header of a subpage: eyebrow, title and lead on a soft nebula, full width.
 */
class PageHero extends \Ease\Html\DivTag
{
    /**
     * @param string $title   page title (H1)
     * @param string $lead    one-sentence description
     * @param string $eyebrow small label above the title
     * @param mixed  $actions buttons or other content under the lead
     */
    public function __construct(string $title, string $lead = '', string $eyebrow = '', $actions = null)
    {
        parent::__construct(null, ['class' => 'page-hero']);

        $inner = $this->addItem(new \Ease\Html\DivTag(null, ['class' => 'page-hero-inner']));

        if ($eyebrow !== '') {
            $inner->addItem(new \Ease\Html\DivTag($eyebrow, ['class' => 'eyebrow']));
        }

        $inner->addItem(new \Ease\Html\H1Tag($title));

        if ($lead !== '') {
            $inner->addItem(new \Ease\Html\PTag($lead, ['class' => 'lead']));
        }

        if ($actions !== null) {
            $inner->addItem(new \Ease\Html\DivTag($actions, ['class' => 'page-hero-actions']));
        }
    }
}
