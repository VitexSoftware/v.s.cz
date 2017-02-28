<?php
/**
 * Flexplorer - Menu hlavní stránky.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace VSCZ\ui;

class MainPageMenu extends \Ease\Html\Div
{
    /**
     * Sem se přidávají položky.
     *
     * @var \Ease\Html\DivTag
     */
    public $row = null;

    /**
     * Rámeček nabídky.
     *
     * @var \Ease\Html\DivTag
     */
    public $well = null;

    public function __construct()
    {
        parent::__construct(
            null, null,
            [
            'class' => 'container', 'style' => 'margin: auto;',
            ]
        );
        $this->well = $this->addItem(
            new \Ease\Html\Div(null, ['class' => 'well'])
        );
        $this->row  = $this->well->addItem(
            new \Ease\Html\Div(null, ['class' => 'row'])
        );
    }

    public function addMenuItem($image, $title, $url, $hint = null,
                                $version = null)
    {
        return $this->row->addItem(
                new \Ease\Html\ATag(
                $url,
                new \Ease\Html\Div(
        "$title<center><img class=\"mpicon\" src=\"$image\" alt=\"$title\">$version</center>",
                ['class' => 'col-md-2 hinter', 'tabindex' => 0, 'data-toggle' => 'popover',
                        'data-trigger' => 'hover',
                        'data-content' => $hint]
                )
                )
        );
    }

    public function finalize()
    {
        $this->addJavascript('$(".hinter").popover();', null, true);
        $this->addCss('.hinter { font-weight: bold; font-size: large; }');
    }
}
