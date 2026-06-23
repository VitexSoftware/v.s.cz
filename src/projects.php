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

namespace VSCZ;

require_once 'includes/VSInit.php';

$oPage->addItem(new ui\PageTop(_('Projects')));

$allRepos = require __DIR__.'/data/github_repos.php';

$vsRepos = array_filter(
    $allRepos,
    static fn (string $k): bool => str_starts_with($k, 'VitexSoftware/'),
    \ARRAY_FILTER_USE_KEY,
);

ksort($vsRepos);

$languages = [];

foreach ($vsRepos as $meta) {
    $lang = $meta['language'] ?? '';

    if ($lang) {
        $languages[$lang] = ($languages[$lang] ?? 0) + 1;
    }
}

arsort($languages);

$langColors = [
    'PHP'        => 'primary',
    'Python'     => 'warning',
    'Shell'      => 'success',
    'JavaScript' => 'danger',
    'C++'        => 'info',
    'CSS'        => 'secondary',
    'Dart'       => 'primary',
    'Go'         => 'info',
    'Rust'       => 'danger',
    'Java'       => 'warning',
    'TypeScript' => 'primary',
];

$langBadge = static function (string $lang) use ($langColors): string {
    $color = $langColors[$lang] ?? 'secondary';

    return '<span class="badge bg-'.$color.' me-1">'.htmlspecialchars($lang).'</span>';
};

$oPage->container->addItem(new \Ease\Html\H1Tag(_('Open Source Projects')));

$filterBar = new \Ease\Html\DivTag(null, ['class' => 'mb-3']);
$filterBar->addItem(new \Ease\Html\InputTag(null, [
    'id'          => 'project-search',
    'class'       => 'form-control mb-2',
    'type'        => 'search',
    'placeholder' => _('Search projects…'),
    'oninput'     => 'filterProjects()',
]));

$langBtns = new \Ease\Html\DivTag(null, ['class' => 'd-flex flex-wrap gap-1', 'id' => 'lang-filters']);
$langBtns->addItem('<button class="btn btn-sm btn-dark active" data-lang="" onclick="setLang(this)">'._('All').' <span class="badge bg-secondary">'.count($vsRepos).'</span></button>');

foreach ($languages as $lang => $count) {
    $color = $langColors[$lang] ?? 'secondary';
    $langBtns->addItem(
        '<button class="btn btn-sm btn-outline-'.$color.'" data-lang="'.htmlspecialchars($lang).'" onclick="setLang(this)">'
        .htmlspecialchars($lang).' <span class="badge bg-'.$color.'">'.$count.'</span></button>',
    );
}

$filterBar->addItem($langBtns);
$oPage->container->addItem(new \Ease\TWB5\Container($filterBar));

$grid = new \Ease\Html\DivTag(null, ['class' => 'row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3', 'id' => 'project-grid']);

foreach ($vsRepos as $repoPath => $meta) {
    $name        = substr($repoPath, strlen('VitexSoftware/'));
    $description = $meta['description'] ?? '';
    $language    = $meta['language'] ?? '';
    $stars       = (int) ($meta['stars'] ?? 0);
    $forks       = (int) ($meta['forks'] ?? 0);
    $topics      = $meta['topics'] ?? [];
    $pushedAt    = $meta['pushedAt'] ?? '';
    $ghUrl       = 'https://github.com/'.$repoPath;

    $topicSearch = strtolower($name.' '.$description.' '.$language.' '.implode(' ', $topics));

    $card = new \Ease\Html\DivTag(null, [
        'class'            => 'col project-card',
        'data-name'        => strtolower($name),
        'data-lang'        => $language,
        'data-search'      => $topicSearch,
    ]);

    $inner = new \Ease\Html\DivTag(null, ['class' => 'card h-100 shadow-sm']);
    $body  = new \Ease\Html\DivTag(null, ['class' => 'card-body d-flex flex-column']);

    $title = new \Ease\Html\H5Tag(
        new \Ease\Html\ATag($ghUrl, htmlspecialchars($name), ['class' => 'text-decoration-none stretched-link']),
        ['class' => 'card-title mb-1'],
    );
    $body->addItem($title);

    if ($description) {
        $body->addItem(new \Ease\Html\PTag(htmlspecialchars($description), ['class' => 'card-text text-muted small flex-grow-1']));
    } else {
        $body->addItem(new \Ease\Html\DivTag(null, ['class' => 'flex-grow-1']));
    }

    $badges = new \Ease\Html\DivTag(null, ['class' => 'mt-2 d-flex flex-wrap gap-1']);

    if ($language) {
        $badges->addItem($langBadge($language));
    }

    foreach (\array_slice($topics, 0, 5) as $topic) {
        $badges->addItem('<span class="badge bg-light text-dark border">'.htmlspecialchars($topic).'</span>');
    }

    $body->addItem($badges);

    $footer = new \Ease\Html\DivTag(null, ['class' => 'card-footer text-muted small d-flex justify-content-between align-items-center']);
    $footer->addItem('<span>⭐ '.$stars.'&nbsp;&nbsp;🍴 '.$forks.'</span>');

    if ($pushedAt) {
        $footer->addItem('<span>'.htmlspecialchars($pushedAt).'</span>');
    }

    $inner->addItem($body);
    $inner->addItem($footer);
    $card->addItem($inner);
    $grid->addItem($card);
}

$oPage->container->addItem(new \Ease\TWB5\Container($grid));

$oPage->addJavaScript(<<<'JS'
var activeLang = '';
function filterProjects() {
    var q = document.getElementById('project-search').value.toLowerCase();
    document.querySelectorAll('.project-card').forEach(function(c) {
        var matchSearch = !q || c.dataset.search.includes(q);
        var matchLang   = !activeLang || c.dataset.lang === activeLang;
        c.style.display = (matchSearch && matchLang) ? '' : 'none';
    });
}
function setLang(btn) {
    activeLang = btn.dataset.lang;
    document.querySelectorAll('#lang-filters button').forEach(function(b) {
        b.classList.remove('active');
        var baseClass = b.className.replace(/ active/, '');
        if (b.className.includes('btn-outline-')) {
            b.className = baseClass;
        }
    });
    btn.classList.add('active');
    filterProjects();
}
JS);

$oPage->addItem(new ui\PageBottom());
$oPage->draw();
