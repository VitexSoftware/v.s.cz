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
 * Wraps a collection of Bootstrap card columns into a BS5 Carousel.
 */
class CardCarousel extends \Ease\Html\DivTag
{
    private array $cards = [];
    private int $perSlide;
    private string $carouselId;
    private bool $carouselBuilt = false;

    public function __construct(string $id, int $perSlide = 1)
    {
        parent::__construct(null, [
            'id'               => $id,
            'class'            => 'carousel slide carousel-dark mb-4',
            'data-bs-ride'     => 'false',
            'data-bs-interval' => 'false',
        ]);
        $this->carouselId = $id;
        $this->perSlide   = $perSlide;
    }

    public function addCard($card): void
    {
        $this->cards[] = $card;
    }

    public function finalize(): void
    {
        if ($this->carouselBuilt || empty($this->cards)) {
            return;
        }

        $this->carouselBuilt = true;

        $chunks = array_chunk($this->cards, $this->perSlide);
        $id     = htmlspecialchars($this->carouselId);

        // Dot indicators
        $indicators = '<div class="carousel-indicators">';

        foreach ($chunks as $i => $_) {
            $active      = $i === 0 ? ' class="active" aria-current="true"' : '';
            $indicators .= "<button type=\"button\" data-bs-target=\"#$id\""
                         ." data-bs-slide-to=\"$i\"$active></button>";
        }

        $indicators .= '</div>';

        // Slides
        $inner = '<div class="carousel-inner">';

        $colClass = $this->perSlide <= 1
            ? 'col-12'
            : 'col-md-'.(12 / $this->perSlide);

        foreach ($chunks as $i => $chunk) {
            $active  = $i === 0 ? ' active' : '';
            $inner  .= "<div class=\"carousel-item$active\">"
                     .'<div class="row g-3 px-5">';

            foreach ($chunk as $card) {
                $inner .= '<div class="'.$colClass.'">'.(string) $card.'</div>';
            }

            $inner .= '</div></div>';
        }

        $inner .= '</div>';

        // Prev / next controls
        $controls = <<<HTML
<button class="carousel-control-prev" type="button" data-bs-target="#$id" data-bs-slide="prev">
  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Previous</span>
</button>
<button class="carousel-control-next" type="button" data-bs-target="#$id" data-bs-slide="next">
  <span class="carousel-control-next-icon" aria-hidden="true"></span>
  <span class="visually-hidden">Next</span>
</button>
HTML;

        $this->addItem($indicators.$inner.$controls);
    }
}
