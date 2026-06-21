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

class MainPageMenu extends \Ease\TWB5\Widgets\MainPageMenu
{
    /**
     * Extract first plain-text paragraph from AppStream HTML description.
     * AppStream locale keys: 'en-US', 'en', 'C' (neutral).
     */
    private static function appStreamExcerpt(array $comp, int $maxLen = 280): string
    {
        foreach (['en-US', 'en', 'C'] as $locale) {
            $html = $comp['Description'][$locale] ?? $comp['Summary'][$locale] ?? '';

            if ($html) {
                break;
            }
        }

        if (empty($html)) {
            return '';
        }

        if (preg_match('/<p>(.*?)<\/p>/si', $html, $m)) {
            $text = strip_tags($m[1]);
        } else {
            $text = strip_tags($html);
        }

        $text = preg_replace('/\s+/', ' ', trim($text));

        return mb_strlen($text) > $maxLen ? mb_substr($text, 0, $maxLen).'…' : $text;
    }

    /**
     * Render a row of small Bootstrap secondary badges.
     */
    private static function tagBadges(array $tags): string
    {
        $html = '';

        foreach (array_slice($tags, 0, 6) as $tag) {
            $html .= '<span class="badge bg-secondary me-1 mb-1">'.htmlspecialchars($tag).'</span>';
        }

        return $html;
    }

    /**
     * Resolve the best icon URL: AppStream remote icon → fallback to $image path.
     */
    private static function resolveIcon(string $image, string $debPackage = ''): string
    {
        if ($debPackage) {
            $url = \VSCZ\AppStream::iconUrl($debPackage);

            if ($url) {
                return $url;
            }
        }

        return $image;
    }

    /**
     * Build the horizontal card shell: fixed-width icon column + flex content column.
     *
     * @return array{0: \Ease\Html\DivTag, 1: \Ease\Html\DivTag}  [$iconWrap, $body]
     */
    private function makeCardShell(string $iconSrc, string $title, string $linkUrl): array
    {
        $icon = new \Ease\Html\ImgTag($iconSrc, $title, [
            'alt'   => $title,
            'style' => 'width:72px;height:72px;object-fit:contain;',
        ]);

        $iconWrap = new \Ease\Html\DivTag(
            new \Ease\Html\ATag($linkUrl, $icon),
            [
                'class' => 'flex-shrink-0 d-flex align-items-center justify-content-center p-3 border-end',
                'style' => 'width:100px;background:#fff;',
            ],
        );

        $body = new \Ease\Html\DivTag(null, ['class' => 'flex-grow-1 p-3']);

        return [$iconWrap, $body];
    }

    /**
     * Modern horizontal card for application/utility entries.
     *
     * @param string $debPackage Optional deb package name. Auto-detected when $url
     *                           starts with "deb.php?package=". Supply explicitly for
     *                           items that use a GitHub URL.
     */
    public function addMenuItem($title, $url, $image, $description, $buttonText = null, $properties = [], string $debPackage = ''): \Ease\TWB5\Col
    {
        // Auto-detect deb package from URL
        if (!$debPackage && str_starts_with($url, 'deb.php?package=')) {
            parse_str((string) parse_url($url, \PHP_URL_QUERY), $q);
            $debPackage = $q['package'] ?? '';
        }

        // Auto-detect GitHub repo path from URL
        $githubRepo = '';

        if (preg_match('#github\.com/([^/?#]+/[^/?#]+)#', $url, $m)) {
            $githubRepo = $m[1];
        }

        // AppStream data (description, categories, icon)
        $appComp = $debPackage ? \VSCZ\AppStream::get($debPackage) : null;

        // GitHub data (topics, description)
        $ghInfo = $githubRepo ? GitHubInfo::get($githubRepo) : [];

        // Extended description: AppStream → Packages file → GitHub description
        $extDesc = $appComp ? self::appStreamExcerpt($appComp) : '';

        if (!$extDesc && $debPackage) {
            $extDesc = DebPackages::description($debPackage);
        }

        if (!$extDesc && !empty($ghInfo['description'])) {
            $extDesc = $ghInfo['description'];
        }

        // Tags: AppStream categories + AppStream keywords + GitHub topics
        $tags = [];

        if ($appComp) {
            $tags = array_merge($tags, $appComp['Categories'] ?? []);
            $kw   = $appComp['Keywords']['en-US'] ?? $appComp['Keywords']['C'] ?? $appComp['Keywords']['en'] ?? [];
            $tags = array_merge($tags, array_slice((array) $kw, 0, 4));
        }

        if ($ghInfo) {
            $tags = array_merge($tags, $ghInfo['topics'] ?? []);
        }

        $tags = array_unique($tags);

        // Resolve best icon URL
        $iconSrc = self::resolveIcon($image, $debPackage);

        // Primary link: deb.php when a package is known, otherwise original $url
        $primaryUrl = $debPackage ? 'deb.php?package='.$debPackage : $url;

        [$iconWrap, $body] = $this->makeCardShell($iconSrc, $title, $primaryUrl);

        $body->addItem(new \Ease\Html\H5Tag(
            new \Ease\Html\ATag($primaryUrl, $title, ['class' => 'text-dark text-decoration-none']),
            ['class' => 'mb-1'],
        ));

        // Short description (passed in)
        $body->addItem(new \Ease\Html\PTag($description, ['class' => 'text-muted small mb-1']));

        // Extended description from AppStream / GitHub
        if ($extDesc && $extDesc !== $description) {
            $body->addItem(new \Ease\Html\PTag($extDesc, ['class' => 'small mb-2']));
        }

        // Category / topic badges
        if ($tags) {
            $body->addItem(new \Ease\Html\DivTag(self::tagBadges($tags), ['class' => 'mb-2']));
        }

        // Footer row: version badge left, package/GitHub link right
        $footer = new \Ease\Html\DivTag(null, ['class' => 'd-flex justify-content-between align-items-center flex-wrap gap-1']);

        if ($buttonText !== null) {
            $footer->addItem(new \Ease\Html\DivTag($buttonText));
        }

        if ($debPackage) {
            $footer->addItem(new \Ease\Html\ATag(
                'deb.php?package='.$debPackage,
                '📦 '._('Package details'),
                ['class' => 'btn btn-sm btn-outline-primary'],
            ));
        } elseif ($githubRepo) {
            $footer->addItem(new \Ease\Html\ATag(
                $url,
                '↗ '._('View on GitHub'),
                ['class' => 'btn btn-sm btn-outline-secondary'],
            ));
        }

        $body->addItem($footer);

        $wrap     = new \Ease\Html\DivTag([$iconWrap, $body], ['class' => 'd-flex align-items-stretch']);
        $menuCard = new \Ease\TWB5\Card($wrap, array_merge(['class' => 'mp-menu-item overflow-hidden'], $properties));

        return $this->addItem(new \Ease\TWB5\Col(3, $menuCard));
    }

    /**
     * Modern horizontal card for library entries (GitHub + registry badges).
     *
     * @param string     $url
     * @param string     $title
     * @param string     $description
     * @param string     $image
     * @param null|mixed $packagist
     *
     * @return \Ease\TWB5\Col
     */
    public function addLibraryItem($url, $title, $description, $image = null, $packagist = null, string $registry = 'packagist')
    {
        $gitHubURL     = str_replace('https://github.com/', '', $url);
        $vendorProject = substr((string) parse_url($url, \PHP_URL_PATH), 1);
        $packagist     = null === $packagist
            ? str_replace(['spoje-net', 'php-flexibee'], ['spoje.net', 'flexibee'], strtolower($vendorProject))
            : $packagist;

        if (null === $image) {
            $image = 'img/'.basename($vendorProject).'.svg';
        }

        $this->includeJavaScript('https://buttons.github.io/buttons.js');

        // GitHub metadata (cached)
        $ghInfo = GitHubInfo::get($gitHubURL);
        $topics = $ghInfo['topics'] ?? [];
        $lang   = $ghInfo['language'] ?? '';

        // Extended description from GitHub
        $ghDesc = $ghInfo['description'] ?? '';

        [$iconWrap, $body] = $this->makeCardShell($image, $title, $url);

        $body->addItem(new \Ease\Html\H5Tag(
            new \Ease\Html\ATag($url, $title, ['class' => 'text-dark text-decoration-none']),
            ['class' => 'mb-1'],
        ));

        $body->addItem(new \Ease\Html\PTag($description, ['class' => 'text-muted small mb-1']));

        if ($ghDesc && $ghDesc !== $description) {
            $body->addItem(new \Ease\Html\PTag($ghDesc, ['class' => 'small mb-2']));
        }

        // Language + topic badges
        $tags = $lang ? array_merge([$lang], $topics) : $topics;

        if ($tags) {
            $body->addItem(new \Ease\Html\DivTag(self::tagBadges($tags), ['class' => 'mb-2']));
        }

        // GitHub Star / Fork buttons
        $body->addItem(new \Ease\Html\DivTag([
            new \Ease\Html\ATag(
                $url,
                _('Star'),
                [
                    'class'             => 'github-button',
                    'data-icon'         => 'octicon-star',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size'         => 'large',
                    'data-show-count'   => 'true',
                    'aria-label'        => _(sprintf('Star %s on GitHub', $gitHubURL)),
                ],
            ),
            '&nbsp;',
            new \Ease\Html\ATag(
                $url.'/fork',
                _('Fork'),
                [
                    'class'             => 'github-button',
                    'data-icon'         => 'octicon-repo-forked',
                    'data-color-scheme' => 'no-preference: dark; light: dark; dark: dark;',
                    'data-size'         => 'large',
                    'data-show-count'   => 'true',
                    'aria-label'        => _(sprintf('Fork %s on GitHub', $gitHubURL)),
                ],
            ),
            '&nbsp;&nbsp;',
            $registry === 'pypi'
                ? new PyPIBadge($packagist, 'v')
                : new PackagistBadge($vendorProject, $packagist, 'v'),
            '&nbsp;',
            $registry === 'pypi'
                ? new PyPIBadge($packagist, 'dm')
                : new PackagistBadge($vendorProject, $packagist, 'dt'),
        ], ['class' => 'mb-1 d-flex flex-wrap align-items-center gap-1']));

        $wrap     = new \Ease\Html\DivTag([$iconWrap, $body], ['class' => 'd-flex align-items-stretch']);
        $menuCard = new \Ease\TWB5\Card($wrap, ['class' => 'mp-menu-item overflow-hidden']);

        return $this->addItem(new \Ease\TWB5\Col(3, $menuCard));
    }

    public function toCarousel(string $id, int $perSlide = 1): CardCarousel
    {
        $carousel = new CardCarousel($id, $perSlide);

        foreach ($this->pageParts as $col) {
            $card = ($col instanceof \Ease\Html\DivTag && !empty($col->pageParts))
                ? reset($col->pageParts)
                : $col;
            $carousel->addCard($card);
        }

        return $carousel;
    }

    /**
     * Returns "Current version X" from composer.json or the apt Packages file.
     *
     * @param string $composerPath  Path to installed composer.json
     * @param string $debPackage    Optional deb package name for apt fallback
     */
    public static function composerVersion($composerPath, string $debPackage = '')
    {
        if (file_exists($composerPath)) {
            $data    = json_decode(file_get_contents($composerPath));
            $version = $data->version ?? '';

            if ($version) {
                return sprintf(_('Current version %s'), $version);
            }
        }

        if ($debPackage) {
            $version = DebPackages::version($debPackage);

            if ($version) {
                return sprintf(_('Current version %s'), $version);
            }
        }

        // Auto-detect package name from composer path: /usr/lib/PKG/composer.json
        if (preg_match('#/usr/lib/([^/]+)/composer\.json#', $composerPath, $m)) {
            $version = DebPackages::version($m[1]);

            if ($version) {
                return sprintf(_('Current version %s'), $version);
            }
        }

        return sprintf(_('Current version %s'), 'n/a');
    }
}
