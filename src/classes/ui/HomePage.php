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
 * Sections of the homepage ("cyber hippies" design): cosmic hero with the MultiFlexi feed,
 * products, pricing, projects, tool catalog, news, about and call to action.
 */
class HomePage
{
    /**
     * Orbits around the MultiFlexi panel (ellipses centred at 1110,430, tilted by -14°).
     */
    private const ORBIT_INNER = 'M1382 362 A280 250 -14 1 1 838 498 A280 250 -14 1 1 1382 362';
    private const ORBIT_OUTER = 'M1459 343 A360 300 -14 1 1 761 517 A360 300 -14 1 1 1459 343';

    /**
     * Small line icons, drawn around 0,0.
     */
    private const ICONS = [
        'bank' => 'M-7 -1.5h14M-5 -1.5v6m3.3-6v6m3.4-6v6m3.3-6v6M-7 5.5h14M0 -7.5l7.5 4.5h-15z',
        'doc' => 'M-6 -7.5h12v15h-12zM-3 -3h6M-3 0.5h6M-3 4h4',
        'pohoda' => 'M6.5 0a6.5 6.5 0 1 1-6.5-6.5M6.5-6.5L0 0',
        'mail' => 'M-7.5 -5h15v10h-15zM-7.5 -4.5l7.5 5.5 7.5-5.5',
    ];

    public static function hero(): string
    {
        $t = static fn (string $text): string => _($text);

        $orbiting = self::satellite($t('Bank'), 'bank', '--p2', self::ORBIT_INNER, 30, 0)
            .self::satellite('AbraFlexi', 'doc', '--p1', self::ORBIT_INNER, 30, -15)
            .self::satellite('Pohoda', 'pohoda', '--p4', self::ORBIT_OUTER, 44, -10)
            .self::satellite($t('E-mail'), 'mail', '--p3', self::ORBIT_OUTER, 44, -30)
            .self::pulse(self::ORBIT_INNER, 7, 0, '--p2')
            .self::pulse(self::ORBIT_INNER, 7, -3.5, '--p4')
            .self::pulse(self::ORBIT_OUTER, 9, -2, '--p3');

        $feed = '';

        foreach ([
            ['--p2', 'bank', $t('Fio bank statement imported'), $t('Pohoda · 23 transactions'), '06:00'],
            ['--p1', 'link', $t('Payments matched to invoices'), $t('AbraFlexi · by variable symbol'), '06:02'],
            ['--p3', 'mail', $t('Payment reminders sent'), $t('only to overdue customers'), '07:30'],
            ['--p5', 'down', $t('Received invoices from e-mail'), $t('loaded into AbraFlexi'), '08:00'],
            ['--p4', 'chart', $t('Weekly digest for the management'), $t('receivables and cash flow'), '08:15'],
            ['--p2', 'bank', $t('Raiffeisenbank transactions'), $t('AbraFlexi · bank movements'), '09:00'],
        ] as [$color, $icon, $title, $detail, $time]) {
            $feed .= '<div class="cycle-item" style="--c:var('.$color.')"><div class="ic">'.self::uiIcon($icon).'</div><div><b>'.$title.'</b><span>'.$detail.'</span></div><time>'.$time.'</time></div>';
        }

        $inner = self::ORBIT_INNER;
        $outer = self::ORBIT_OUTER;

        return <<<HTML
<section class="hero">
  <div class="landscape" aria-hidden="true">
    <svg viewBox="0 0 1440 900" preserveAspectRatio="xMidYMax slice">
      <defs>
        <linearGradient id="bgG" x1="0" y1="0" x2="0" y2="1"><stop offset="0" style="stop-color:var(--art-bg1)"/><stop offset="1" style="stop-color:var(--art-bg2)"/></linearGradient>
        <filter id="blurG" x="-50%" y="-50%" width="200%" height="200%"><feGaussianBlur stdDeviation="70"/></filter>
        <filter id="glowG" x="-200%" y="-200%" width="500%" height="500%"><feGaussianBlur stdDeviation="3" result="b"/><feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge></filter>
        <linearGradient id="rimG" x1="0" y1="0" x2="1" y2="0"><stop offset="0" style="stop-color:var(--art-rim1)" stop-opacity="0"/><stop offset=".35" style="stop-color:var(--art-rim1)"/><stop offset=".7" style="stop-color:var(--art-rim2)"/><stop offset="1" style="stop-color:var(--art-rim2)" stop-opacity="0"/></linearGradient>
        <linearGradient id="shootG" x1="0" y1="0" x2="1" y2="0"><stop offset="0" style="stop-color:var(--text)" stop-opacity="0"/><stop offset="1" style="stop-color:var(--text)" stop-opacity=".9"/></linearGradient>
        <radialGradient id="ringPlanet" cx=".35" cy=".35" r=".8"><stop offset="0" style="stop-color:var(--p4)"/><stop offset="1" style="stop-color:var(--p2)"/></radialGradient>
      </defs>
      <rect width="1440" height="900" fill="url(#bgG)"/>
      <g filter="url(#blurG)" opacity=".7" class="nebula">
        <circle cx="1040" cy="330" r="210" style="fill:var(--art-n1)"/>
        <circle cx="1250" cy="470" r="170" style="fill:var(--art-n2)"/>
        <circle cx="880" cy="520" r="150" style="fill:var(--art-n3)"/>
        <circle cx="1320" cy="220" r="120" style="fill:var(--art-n4)"/>
      </g>
      <g class="stars" style="fill:var(--text)">
        <circle cx="120" cy="80" r="1.2" opacity=".7"/><circle cx="260" cy="210" r=".9" opacity=".5"/><circle cx="410" cy="120" r="1.4" opacity=".8"/><circle cx="560" cy="260" r=".8" opacity=".4"/>
        <circle cx="760" cy="60" r="1.1" opacity=".6"/><circle cx="880" cy="170" r="1.3" opacity=".7"/><circle cx="980" cy="90" r=".9" opacity=".5"/><circle cx="1120" cy="150" r="1.5" opacity=".9"/>
        <circle cx="1240" cy="70" r="1" opacity=".6"/><circle cx="1390" cy="330" r="1.2" opacity=".7"/><circle cx="660" cy="420" r=".8" opacity=".4"/><circle cx="330" cy="380" r="1" opacity=".5"/>
        <circle cx="40" cy="300" r="1" opacity=".5"/><circle cx="200" cy="640" r=".9" opacity=".4"/><circle cx="1420" cy="600" r="1.1" opacity=".6"/><circle cx="1000" cy="720" r=".8" opacity=".4"/>
      </g>
      <g class="peace-const" style="stroke:var(--text)" fill="none" stroke-width="1" stroke-linecap="round">
        <circle cx="640" cy="150" r="52" pathLength="100" class="draw"/>
        <path d="M640 98V202" pathLength="100" class="draw d2"/>
        <path d="M640 150L603 187M640 150L677 187" pathLength="100" class="draw d3"/>
        <g class="const-stars" style="fill:var(--text)" stroke="none">
          <circle cx="640" cy="98" r="2.2"/><circle cx="640" cy="202" r="2.2"/><circle cx="640" cy="150" r="2.6"/><circle cx="603" cy="187" r="1.8"/><circle cx="677" cy="187" r="1.8"/>
          <circle cx="588" cy="150" r="1.6"/><circle cx="692" cy="150" r="1.6"/><circle cx="603" cy="113" r="1.4"/><circle cx="677" cy="113" r="1.4"/>
        </g>
      </g>
      <line class="shoot s1" x1="0" y1="0" x2="120" y2="0" stroke="url(#shootG)" stroke-width="1.6" stroke-linecap="round"/>
      <line class="shoot s2" x1="0" y1="0" x2="90" y2="0" stroke="url(#shootG)" stroke-width="1.3" stroke-linecap="round"/>
      <g class="ringed">
        <ellipse cx="1375" cy="120" rx="38" ry="9" fill="none" style="stroke:var(--p3)" stroke-opacity=".7" stroke-width="2"/>
        <circle cx="1375" cy="120" r="17" fill="url(#ringPlanet)"/>
        <path d="M1337 120a38 9 0 0 0 76 0" fill="none" style="stroke:var(--p3)" stroke-width="2"/>
      </g>
      <g fill="none" style="stroke:var(--text)" stroke-opacity=".14" stroke-width="1">
        <path d="{$inner}"/>
        <path d="{$outer}" stroke-dasharray="3 7"/>
      </g>
      {$orbiting}
      <g class="ridge" data-depth="16">
        <circle cx="720" cy="2080" r="1300" style="fill:var(--art-planet)"/>
        <path d="M-580 2080 A1300 1300 0 0 1 2020 2080" fill="none" stroke="url(#rimG)" stroke-width="3"/>
      </g>
    </svg>
  </div>

  <div class="wrap hero-grid">
    <div class="hero-copy">
      <div class="eyebrow">{$t('Technology')}<i>/</i>{$t('Freedom')}<i>/</i>{$t('Better tomorrow')}</div>
      <h1>{$t('Accounting automation and')} <span class="grad">{$t('open source projects')}</span></h1>
      <p class="lead">{$t('We save time, simplify work and give modern technology a meaning. We are Vitex Software –')} <b>{$t('cyber hippies with a clear head and working code.')}</b></p>
      <div class="hero-ctas">
        <a class="btn btn-glow" href="#produkty">{$t('What we automate for you')} <span class="arrow">→</span></a>
        <a class="btn btn-line" href="#onas">{$t('About us')} <span class="arrow">↓</span></a>
      </div>
    </div>
    <div class="live" aria-label="{$t('Example of a MultiFlexi morning')}">
      <div class="live-head"><span class="dot"></span><b>MultiFlexi</b> {$t('this morning · example')}</div>
      <div class="cycle" data-cycle="4">{$feed}</div>
    </div>
  </div>
  <div class="hero-note hand">{$t('A better world starts with good software')} ☮</div>
</section>
HTML;
    }

    public static function products(): string
    {
        $t = static fn (string $text): string => _($text);

        return <<<HTML
<section id="produkty">
  <div class="wrap">
    <div class="head-row">
      <div class="reveal">
        <div class="eyebrow">{$t('Products and services')}</div>
        <h2>{$t('Smart solutions for your business')}</h2>
      </div>
      <div class="aside reveal" style="--d:1">{$t('Less manual work.')}<br>{$t('More time for what matters.')}</div>
    </div>

    <div class="duo">
      <div class="glass big-card reveal" style="--c:var(--p1)">
        <div class="badge-ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8 7h8M8 11h2m2 0h2M8 14h2m2 0h2M8 17h2m2 0h2"/></svg></div>
        <h3>{$t('Accounting automation')}</h3>
        <div class="sub">{$t('AbraFlexi and Pohoda via MultiFlexi')}</div>
        <p>{$t('We connect your accounting with the bank, e-mail and other services. Statements, payment matching, reminders and reports run by themselves – we host and watch over it for you. 78 ready-made automations from 290 CZK a month.')}</p>
        <div class="foot">
          <div class="hero-ctas">
            <a class="btn btn-glow btn-sm" href="#cenik">{$t('Pricing')} <span class="arrow">→</span></a>
            <a class="btn btn-line btn-sm" href="automatizace.php">{$t('All automations')}</a>
          </div>
          <div class="mini-icons">
            <span>{$t('Banks')}</span><span>AbraFlexi</span><span>Pohoda</span><span>{$t('E-mail')}</span>
          </div>
        </div>
      </div>
      <div class="glass big-card reveal" style="--c:var(--p3);--d:1">
        <div class="badge-ic"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M8 7l-5 5 5 5M16 7l5 5-5 5M14 4l-4 16"/></svg></div>
        <h3>{$t('Open source projects')}</h3>
        <div class="sub">{$t('We share what works')}</div>
        <p>{$t('Everything the automations run on is open – on GitHub and as 500+ packages for Debian and Ubuntu.')}</p>
        <div class="foot">
          <a class="btn btn-line btn-sm" href="projects.php">{$t('Projects')} <span class="arrow">→</span></a>
          <div class="mini-icons">
            <span><i class="fa-brands fa-github"></i> GitHub</span><span><i class="fa-solid fa-box"></i> {$t('Packages')}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="steps">
      <div class="glass step reveal" style="--c:var(--p2)"><span class="n">01 · {$t('WE SHOW')}</span><h3>{$t('15 minutes on your data')}</h3><p>{$t('We show you what can be automated in your company. No obligation.')}</p></div>
      <div class="glass step reveal" style="--c:var(--p5);--d:1"><span class="n">02 · {$t('WE SET UP')}</span><h3>{$t('We connect and configure')}</h3><p>{$t('Credentials are kept safely in one place by MultiFlexi.')}</p></div>
      <div class="glass step reveal" style="--c:var(--p4);--d:2"><span class="n">03 · {$t('WE WATCH')}</span><h3>{$t('It runs and we watch over it')}</h3><p>{$t('Monitoring reports problems before you notice them.')}</p></div>
    </div>
  </div>
</section>
HTML;
    }

    public static function pricing(): string
    {
        $t = static fn (string $text): string => _($text);
        $plans = '';

        foreach ([
            ['', $t('Start'), $t('try one automation'), '290 '.$t('CZK'), $t('setup 2 900 CZK one-off'), [$t('1 automation of your choice'), $t('hosting included'), $t('tool updates'), $t('e-mail support')]],
            ['hot', $t('Operation'), $t('a typical company on AbraFlexi / Pohoda'), '690 '.$t('CZK'), $t('setup 4 900 CZK one-off'), [$t('2–3 automations of your choice'), $t('hosting + monitoring'), $t('automatic updates'), $t('priority support')]],
            ['', $t('Turnkey'), $t('complex operation and customisation'), $t('from').' 1 490 '.$t('CZK'), $t('setup from 9 900 CZK one-off'), [$t('unlimited automations'), $t('custom changes'), $t('priority SLA + phone'), $t('monthly report')]],
        ] as $i => [$class, $name, $for, $amount, $setup, $features]) {
            $tag = $class === 'hot' ? '<span class="tag">'.$t('most popular').'</span>' : '';
            $button = $class === 'hot' ? 'btn-glow' : 'btn-line';
            $plans .= '<div class="glass price '.$class.' reveal" style="--d:'.$i.'">'.$tag
                .'<h3>'.$name.'</h3><span class="dim">'.$for.'</span>'
                .'<div class="amount">'.$amount.' <small>/ '.$t('month').'</small></div>'
                .'<div class="setup">'.$setup.'</div>'
                .'<ul><li>'.implode('</li><li>', $features).'</li></ul>'
                .'<a class="btn '.$button.'" href="kontakt.php">'.$t('I am interested').'</a></div>';
        }

        return <<<HTML
<section id="cenik" style="padding-top:20px">
  <div class="wrap">
    <div class="center-head reveal">
      <div class="eyebrow">{$t('Pricing')}</div>
      <h2>{$t('One automation saves more than it costs')}</h2>
      <p class="dim" style="margin:12px 0 0">{$t('Paying a year in advance = 2 months of operation free.')}</p>
    </div>
    <div class="pricing">{$plans}</div>
    <p class="fine">{$t('Prices are final, we are not VAT payers.')}</p>
  </div>
</section>
HTML;
    }

    public static function projects(): string
    {
        $t = static fn (string $text): string => _($text);
        $cards = '';

        foreach ([
            ['--p1', 'https://multiflexi.eu/', 'img/multiflexi.svg', 'MultiFlexi', $t('Runs, schedules and watches integrations on top of AbraFlexi and Pohoda.')],
            ['--p3', 'mcprack.php', 'img/mcprack.svg', 'MCPRack', $t('Catalog of MCP servers and configuration generator for AI tools.')],
            ['--p4', 'https://github.com/VitexSoftware/jaspercompiler', 'img/jaspercompiler.svg', 'Jasper Compiler', $t('Jasper report compiler with AbraFlexi support.')],
            ['--p2', 'https://github.com/Spoje-NET/php-flexibee', 'img/php-flexibee.svg', 'PHP AbraFlexi', $t('Library for the AbraFlexi REST API.')],
        ] as $i => [$color, $url, $icon, $name, $text]) {
            $cards .= '<a class="glass proj reveal" style="--c:var('.$color.');--d:'.$i.'" href="'.$url.'"><div class="top"><img src="'.$icon.'" alt=""><b>'.$name.'</b></div><p>'.$text.'</p><span class="go" aria-hidden="true">→</span></a>';
        }

        return <<<HTML
<section id="projekty">
  <div class="wrap">
    <div class="head-row">
      <div class="reveal">
        <div class="eyebrow">{$t('Selected projects')}</div>
        <h2>{$t('Open source that makes sense')}</h2>
      </div>
      <a class="link-more reveal" href="projects.php">{$t('Show all projects')} <span class="arrow">→</span></a>
    </div>
    <div class="projects">{$cards}</div>
  </div>
</section>
HTML;
    }

    /**
     * Tool catalog: the original homepage menus as tabs.
     *
     * @param array<string, \Ease\Html\DivTag> $menus tab label => menu
     */
    public static function catalog(array $menus): \Ease\Html\DivTag
    {
        $tabs = '';
        $panels = new \Ease\Html\DivTag(null, ['class' => 'catalog-panels']);
        $first = true;

        foreach ($menus as $label => $menu) {
            $key = 'cat'.substr(md5($label), 0, 6);
            $tabs .= '<button type="button" role="tab" data-tab="'.$key.'" aria-selected="'.($first ? 'true' : 'false').'"'.($first ? ' class="active"' : '').'>'.$label.'</button>';
            $panels->addItem(new \Ease\Html\DivTag($menu, ['class' => 'catalog-panel'.($first ? ' active' : ''), 'data-panel' => $key, 'role' => 'tabpanel']));
            $first = false;
        }

        $section = new \Ease\Html\DivTag(null, ['class' => 'wrap']);
        $section->addItem('<div class="head-row"><div class="reveal"><div class="eyebrow">'._('Tool catalog').'</div><h2>'._('Everything we have built').'</h2></div></div>');
        $section->addItem(new \Ease\Html\DivTag([
            '<div class="catalog-tabs" role="tablist">'.$tabs.'</div>',
            $panels,
        ], ['data-tabs' => '', 'class' => 'reveal']));

        return new \Ease\Html\DivTag($section, ['id' => 'katalog', 'class' => 'catalog-section', 'style' => 'padding:40px 0 100px']);
    }

    /**
     * Latest articles in the current language.
     */
    public static function news(): string
    {
        try {
            $rows = (new \VSCZ\News())->listingQuery()
                ->where('language', \Ease\Locale::singleton()->get2Code())
                ->orderBy('news.DatCreate DESC')
                ->limit(3)
                ->fetchAll();
        } catch (\Throwable $exception) {
            return '';
        }

        if (empty($rows)) {
            return '';
        }

        $cards = '';

        foreach ($rows as $i => $row) {
            $cards .= '<a class="glass proj reveal" style="--c:var(--p'.($i + 1).');--d:'.$i.'" href="article.php?id='.(int) $row['id'].'">'
                .'<span class="dim" style="font-size:.82rem">'.date('j. n. Y', strtotime((string) $row['DatCreate'])).'</span>'
                .'<b>'.htmlspecialchars((string) $row['title']).'</b><span class="go" aria-hidden="true">→</span></a>';
        }

        $head = _('From the workshop');
        $title = _('News and releases');
        $all = _('All articles');

        return <<<HTML
<section id="novinky" style="padding-top:0">
  <div class="wrap">
    <div class="head-row">
      <div class="reveal"><div class="eyebrow">{$head}</div><h2>{$title}</h2></div>
      <a class="link-more reveal" href="articles.php">{$all} <span class="arrow">→</span></a>
    </div>
    <div class="projects" style="grid-template-columns:repeat(auto-fit,minmax(240px,1fr))">{$cards}</div>
  </div>
</section>
HTML;
    }

    public static function about(): string
    {
        $t = static fn (string $text): string => _($text);

        return <<<HTML
<section id="onas" style="padding-top:30px">
  <div class="wrap">
    <div class="portrait-card reveal">
      <div class="portrait-media">
        <img src="img/vitex-portrait-1536.webp" srcset="img/vitex-portrait-900.webp 900w, img/vitex-portrait-1536.webp 1536w" sizes="(max-width: 900px) 100vw, 760px" alt="Vítězslav Dvořák" width="1536" height="1024" loading="lazy">
        <div class="portrait-tint"></div>
      </div>
      <div class="portrait-copy">
        <div class="eyebrow reveal" style="--d:1">{$t('About us')}</div>
        <blockquote class="reveal" style="--d:2">{$t('A small workshop with a big heart for open source. We write, set up and watch over the automations ourselves.')}</blockquote>
        <p class="reveal" style="--d:3">{$t('Vitex Software builds integrations for AbraFlexi and Pohoda and gives everything it writes back to the community – on GitHub and as packages for Debian and Ubuntu.')}</p>
        <div class="facts reveal" style="--d:4">
          <div style="--c:#6b8cff"><b>78</b><span>{$t('automations')}</span></div>
          <div style="--c:#4fd8ff"><b>500+</b><span>{$t('packages')}</span></div>
          <div style="--c:#ffc857"><b>2012</b><span>{$t('since')}</span></div>
        </div>
        <div class="portrait-foot reveal" style="--d:5">
          <a class="btn btn-glow" href="kontakt.php">{$t('Book 15 minutes')} <span class="arrow">→</span></a>
          <span class="hand signature">Vítězslav Dvořák ☮</span>
        </div>
      </div>
    </div>
  </div>
</section>
HTML;
    }

    public static function cta(): string
    {
        $t = static fn (string $text): string => _($text);

        return <<<HTML
<section id="kontakt" style="padding-top:30px">
  <div class="wrap">
    <div class="glass cta reveal">
      <img class="cta-avatar" src="img/vitex-avatar-240.webp" alt="Vítězslav Dvořák" width="96" height="96" loading="lazy">
      <div class="hand" style="font-size:1.8rem;color:var(--p4);margin-bottom:8px">{$t('so, shall we try it?')}</div>
      <h2>{$t('15 minutes and we will show you')} <span class="grad">{$t('on your own data.')}</span></h2>
      <p>{$t('One automation usually saves more working hours in a month than it costs for a whole year.')}</p>
      <div class="hero-ctas">
        <a class="btn btn-glow" href="mailto:info@vitexsoftware.cz">info@vitexsoftware.cz</a>
        <a class="btn btn-line" href="tel:+420739778202">+420 739 778 202</a>
      </div>
    </div>
  </div>
</section>
HTML;
    }

    private static function satellite(string $label, string $icon, string $color, string $path, int $duration, float $begin): string
    {
        return '<g class="sat" style="--sc:var('.$color.')"><circle r="17" class="sat-body"/><path d="'.self::ICONS[$icon].'" class="sat-ic"/>'
            .'<text y="33" text-anchor="middle" class="sat-label">'.htmlspecialchars($label).'</text>'
            .'<animateMotion dur="'.$duration.'s" begin="'.$begin.'s" repeatCount="indefinite" path="'.$path.'"/></g>';
    }

    private static function pulse(string $path, int $duration, float $begin, string $color): string
    {
        return '<circle r="2.6" class="pulse" style="fill:var('.$color.')"><animateMotion dur="'.$duration.'s" begin="'.$begin.'s" repeatCount="indefinite" path="'.$path.'"/></circle>';
    }

    private static function uiIcon(string $name): string
    {
        $paths = [
            'bank' => 'M3 10h18M5 10v8m4-8v8m6-8v8m4-8v8M3 21h18M12 3l9 5H3z',
            'link' => 'M9 15l6-6M10 6l1-1a4 4 0 0 1 6 6l-1 1M14 18l-1 1a4 4 0 0 1-6-6l1-1',
            'mail' => 'M4 6h16v12H4zM4 7l8 6 8-6',
            'down' => 'M12 3v12m-5-5l5 5 5-5M4 19h16',
            'chart' => 'M4 19V9m6 10V5m6 14v-7m4 7H2',
        ];

        return '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="'.$paths[$name].'"/></svg>';
    }
}
