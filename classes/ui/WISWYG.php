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
 * Description of WISWYG.
 *
 * @author vitex
 */
class WISWYG extends \Ease\Html\TextareaTag
{
    public function finalize(): void
    {
        $this->includeJavaScript('js/tinymce/tinymce.min.js');
        $this->addJavaScript('tinymce.init({ selector:\'textarea\', plugins: [\'autolink lists link image charmap code fullscreen\'] });');
    }
}
