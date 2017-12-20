<?php
/**
 * Flexplorer - Menu hlavní stránky.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace VSCZ\ui;

class MainPageMenu extends \Ease\ui\MainPageMenu
{
    public function addMenuItem($image, $title, $url, $hint = null,
                                $version = null)
    {
        return $this->row->addItem(
                new \Ease\Html\ATag(
                $url,
                new \Ease\Html\DivTag(
        "$title<center><img class=\"img-responsive mpicon\" src=\"$image\" alt=\"$title\">$version</center>",
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
        parent::finalize();
    }
}
