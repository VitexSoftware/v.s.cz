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
 * Třídy pro vykreslení stránky.
 *
 * @author    Vitex <vitex@hippy.cz>
 * @copyright 2009-2019 Vitex@hippy.cz (G)
 */
class WebPage extends \Ease\TWB5\WebPage
{
    /**
     * Bump when css/vitex.css or js/vitex.js change, so browsers fetch the new version.
     */
    public const ASSET_VERSION = '1.1.0';
    public string $bootstrapThemeCSS = '';
    public \Ease\TWB5\Container $container;
    public $column1;
    public $column2;
    public $column3;

    /**
     * Základní objekt stránky.
     */
    public function __construct()
    {
        parent::__construct('Vitex Software');
        // Light/dark mode before the first paint, so the page does not flash (dark is the default).
        $this->head->addItem('<script>(function(){var t="dark";try{t=localStorage.getItem("vsTheme")||t}catch(e){}var d=document.documentElement;d.classList.add("js");d.setAttribute("data-theme",t);d.setAttribute("data-bs-theme",t)})()</script>');
        $this->head->addItem('<link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>');
        $this->includeCss('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&family=Caveat:wght@400;500&display=swap');
        $this->includeCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css');
        $this->includeCss('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/v4-shims.min.css');
        $this->includeCss('css/default.css');
        $this->includeCSS('css/github-activity.css');
        $this->includeCss('css/vitex.css?v='.self::ASSET_VERSION);
        $this->includeJavaScript('js/vitex.js?v='.self::ASSET_VERSION);

        $this->head->addItem('<link rel="icon" type="image/png" href="img/tux-server.png" />');
        $this->head->addItem('<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">');
        $this->head->addItem('<link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php">');
        $this->head->addItem('<meta name="theme-color" content="#1d1440">');

        $this->body->setTagID('page-top');
        $this->container = $this->addItem(new \Ease\TWB5\Container());
        $this->container->setTagClass('container-fluid page-content');
    }

    /**
     * Locale for this request: ?locale= → session → browser language → English.
     *
     * Ease\Locale::langToLocale() compares "cs_CZ" from the browser with "cs", so it never matches.
     */
    public static function preferredLocale(string $i18n = '../i18n'): string
    {
        $available = array_map(
            static fn (string $mo): string => basename(\dirname($mo, 2)),
            glob($i18n.'/*/LC_MESSAGES/vscz.mo') ?: [],
        );

        foreach ([$_REQUEST['locale'] ?? null, $_SESSION['locale'] ?? null] as $candidate) {
            if (\is_string($candidate) && \in_array($candidate, $available, true)) {
                return $candidate;
            }
        }

        $browser = \function_exists('locale_accept_from_http') ? (string) locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '') : '';

        foreach ($available as $code) {
            if ($browser !== '' && strncmp($browser, $code, 2) === 0) {
                return $code;
            }
        }

        return 'en_US';
    }

    /**
     * Timestap to time convertor.
     *
     * @param int|long $seconds
     *
     * @return Date
     */
    public static function secondsToTime($seconds)
    {
        $dtF = new \DateTime('@0');
        $dtT = new \DateTime("@{$seconds}");

        return $dtF->diff($dtT)->format('%a');
    }

    /**
     * Only Admin can continue.
     */
    public function onlyForAdmin(): void
    {
        if (!\Ease\Shared::user()->getSettingValue('admin')) {
            $this->addStatusMessage(_('Only for admin'), 'warning');
            $this->redirect('login.php');

            exit;
        }
    }
}
