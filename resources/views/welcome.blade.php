<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Carnets et liste de diffusion</title>
    <meta name="description"
          content="Gérez vos carnets d'adresses et vos contacts, composez vos newsletters et envoyez-les en voyant exactement qui les reçoit.">

    <script>document.documentElement.classList.add('is-ready');</script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet"/>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css'])
    @endif

    <style>
        :root {
            /* Palette (DESIGN.md "The Control Room") */
            --primary: oklch(0.623 0.214 259.815);
            --primary-strong: oklch(0.546 0.245 262.881);
            --primary-wash: oklch(0.623 0.214 259.815 / 0.10);
            --success: oklch(0.627 0.194 149.214);
            --ink: oklch(0.21 0.006 286);
            --ink-soft: oklch(0.39 0.012 286);
            --muted: oklch(0.455 0.015 286);
            --hairline: oklch(0.91 0.003 286);
            --surface: oklch(0.995 0.0015 264);
            --sunken: oklch(0.984 0.002 264);
            --field: oklch(0.975 0.003 264);

            /* Status badge tints (paired light fill + dark text) */
            --badge-draft-bg: oklch(0.932 0.032 255.585);
            --badge-draft-fg: oklch(0.488 0.243 264.376);
            --badge-sending-bg: oklch(0.962 0.059 95.617);
            --badge-sending-fg: oklch(0.473 0.137 46.201);
            --badge-sent-bg: oklch(0.962 0.044 156.743);
            --badge-sent-fg: oklch(0.448 0.119 151.328);
            --badge-failed-bg: oklch(0.936 0.032 17.717);
            --badge-failed-fg: oklch(0.444 0.177 26.899);

            /* Spacing (4pt) */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 40px;
            --space-2xl: 64px;
            --space-3xl: 96px;

            --radius-sm: 6px;
            --radius-md: 8px;
            --radius-lg: 12px;
            --radius-pill: 9999px;

            --measure: 1120px;
            --ease-out: cubic-bezier(0.22, 1, 0.36, 1);

            --shadow-float: 0 4px 12px oklch(0.21 0.006 286 / 0.07);
            --shadow-modal: 0 18px 48px oklch(0.21 0.006 286 / 0.18);

            --z-sticky: 100;
            --z-modal: 400;

            --font: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html { -webkit-text-size-adjust: 100%; scroll-behavior: smooth; }

        body {
            margin: 0;
            font-family: var(--font);
            background: var(--sunken);
            color: var(--ink);
            line-height: 1.55;
            font-size: 1rem;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            font-kerning: normal;
        }

        h1, h2, h3 { margin: 0; text-wrap: balance; letter-spacing: -0.02em; line-height: 1.08; }
        p { margin: 0; text-wrap: pretty; }
        a { color: inherit; }

        .skip-link {
            position: absolute;
            left: var(--space-md);
            top: -100px;
            z-index: var(--z-modal);
            background: var(--surface);
            color: var(--ink);
            padding: 10px 16px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-modal);
            transition: top 0.2s var(--ease-out);
        }
        .skip-link:focus { top: var(--space-md); }

        :focus-visible {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
            border-radius: 3px;
        }

        .wrap {
            width: 100%;
            max-width: var(--measure);
            margin-inline: auto;
            padding-inline: clamp(20px, 5vw, 48px);
        }

        /* ---------- Buttons ---------- */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: var(--space-sm);
            font: inherit;
            font-weight: 600;
            font-size: 0.95rem;
            line-height: 1;
            padding: 13px 20px;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.15s var(--ease-out), border-color 0.15s var(--ease-out), color 0.15s var(--ease-out);
        }
        .btn svg { width: 18px; height: 18px; }
        .btn--primary { background: var(--primary); color: var(--surface); }
        .btn--primary:hover { background: var(--primary-strong); }
        .btn--ghost { background: transparent; color: var(--ink); border-color: var(--hairline); }
        .btn--ghost:hover { border-color: var(--ink-soft); background: var(--surface); }
        .btn--sm { padding: 9px 14px; font-size: 0.875rem; }
        @media (pointer: coarse) { .btn--sm { min-height: 44px; } }

        /* ---------- Header ---------- */
        .site-header {
            position: sticky;
            top: 0;
            z-index: var(--z-sticky);
            background: var(--surface);
            border-bottom: 1px solid var(--hairline);
        }
        .site-header__row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: var(--space-md);
            min-height: 68px;
        }
        .brand { display: inline-flex; align-items: center; gap: 10px; font-weight: 600; letter-spacing: -0.01em; text-decoration: none; }
        .brand__mark {
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            background: var(--primary);
            color: var(--surface);
            flex: none;
        }
        .brand__mark svg { width: 19px; height: 19px; }
        .brand__name { font-size: 0.98rem; }
        .brand__name span { color: var(--muted); }

        /* ---------- Hero ---------- */
        .hero { padding-top: clamp(48px, 8vw, 96px); padding-bottom: clamp(48px, 7vw, 88px); }
        .hero__grid {
            display: grid;
            grid-template-columns: 1.04fr 0.96fr;
            gap: clamp(32px, 5vw, 72px);
            align-items: center;
        }
        .hero h1 {
            font-size: clamp(2.4rem, 5.4vw, 3.9rem);
            font-weight: 700;
            max-width: 16ch;
        }
        .hero h1 em { font-style: normal; color: var(--primary); }
        .hero__lead {
            margin-top: var(--space-lg);
            font-size: clamp(1.05rem, 1.6vw, 1.2rem);
            color: var(--ink-soft);
            max-width: 56ch;
        }
        .hero__cta { margin-top: var(--space-xl); display: flex; flex-wrap: wrap; gap: var(--space-md); }
        .hero__note { margin-top: var(--space-md); font-size: 0.85rem; color: var(--muted); }

        .hero__media { position: relative; }
        .hero__media::before {
            content: "";
            position: absolute;
            inset: -14% -8% -10% -6%;
            background: radial-gradient(60% 60% at 70% 30%, var(--primary-wash), transparent 70%);
            z-index: -1;
        }

        /* ---------- Product preview ---------- */
        .preview {
            position: relative;
            background: var(--surface);
            border: 1px solid var(--hairline);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-float);
            overflow: hidden;
        }
        .preview__bar {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 12px 16px;
            border-bottom: 1px solid var(--hairline);
            background: var(--sunken);
        }
        .preview__dot { width: 10px; height: 10px; border-radius: 50%; background: var(--hairline); }
        .preview__tab { margin-left: 8px; font-size: 0.8rem; font-weight: 600; color: var(--ink-soft); }
        .preview__body { position: relative; padding: 20px; }
        .compose { display: grid; gap: 14px; filter: blur(1px); opacity: 0.55; }
        .compose__field { display: grid; gap: 6px; }
        .compose__label { font-size: 0.72rem; font-weight: 600; color: var(--muted); letter-spacing: 0.01em; }
        .compose__input {
            border: 1px solid var(--hairline);
            border-radius: var(--radius-md);
            background: var(--field);
            padding: 10px 12px;
            font-size: 0.85rem;
            color: var(--ink);
        }
        .compose__lines { display: grid; gap: 8px; padding-top: 4px; }
        .compose__lines span { height: 9px; border-radius: 4px; background: var(--hairline); }
        .compose__lines span:nth-child(2) { width: 92%; }
        .compose__lines span:nth-child(3) { width: 78%; }

        .modal {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: min(330px, 88%);
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-modal);
            padding: 22px;
            z-index: var(--z-modal);
        }
        .modal__icon {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            background: var(--badge-sent-bg);
            color: var(--badge-sent-fg);
            margin-bottom: 14px;
        }
        .modal__icon svg { width: 22px; height: 22px; }
        .modal h3 { font-size: 1.06rem; font-weight: 600; }
        .modal p { margin-top: 7px; font-size: 0.88rem; color: var(--ink-soft); }
        .modal p b { color: var(--ink); font-weight: 700; }
        .modal__actions { margin-top: 18px; display: flex; gap: 10px; justify-content: flex-end; }

        /* ---------- Badges ---------- */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: var(--radius-sm);
            white-space: nowrap;
        }
        .badge svg { width: 14px; height: 14px; }
        .badge--draft { background: var(--badge-draft-bg); color: var(--badge-draft-fg); }
        .badge--sending { background: var(--badge-sending-bg); color: var(--badge-sending-fg); }
        .badge--sent { background: var(--badge-sent-bg); color: var(--badge-sent-fg); }
        .badge--failed { background: var(--badge-failed-bg); color: var(--badge-failed-fg); }

        /* ---------- Section scaffold ---------- */
        .section { padding-block: clamp(56px, 9vw, 112px); }
        .section--alt { background: var(--surface); border-block: 1px solid var(--hairline); }
        .section__head { max-width: 48ch; }
        .section__head h2 { font-size: clamp(1.8rem, 3.4vw, 2.6rem); font-weight: 700; }
        .section__head p { margin-top: var(--space-md); font-size: 1.08rem; color: var(--ink-soft); }

        /* ---------- Features bento ---------- */
        .features {
            margin-top: clamp(32px, 5vw, 56px);
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: var(--space-md);
        }
        .tile {
            border: 1px solid var(--hairline);
            border-radius: var(--radius-lg);
            background: var(--surface);
            padding: clamp(20px, 2.6vw, 28px);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .section--alt .tile { background: var(--sunken); }
        .tile__icon {
            display: grid;
            place-items: center;
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: var(--primary-wash);
            color: var(--primary-strong);
            flex: none;
        }
        .tile__icon svg { width: 21px; height: 21px; }
        .tile h3 { font-size: 1.12rem; font-weight: 600; letter-spacing: -0.01em; }
        .tile p { font-size: 0.94rem; color: var(--ink-soft); }
        .tile--feature { grid-column: span 2; }
        .tile--wide { grid-column: span 3; }

        /* tile visuals */
        .mini-list { margin-top: 6px; display: grid; gap: 8px; }
        .mini-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border: 1px solid var(--hairline);
            border-radius: var(--radius-md);
            background: var(--surface);
        }
        .section--alt .mini-row { background: var(--field); }
        .mini-avatar { width: 28px; height: 28px; border-radius: 50%; background: var(--primary-wash); color: var(--primary-strong); display: grid; place-items: center; font-size: 0.72rem; font-weight: 700; flex: none; }
        .mini-row__text { display: grid; gap: 3px; min-width: 0; }
        .mini-row__name { font-size: 0.82rem; font-weight: 600; }
        .mini-row__mail { font-size: 0.74rem; color: var(--muted); overflow: hidden; text-overflow: ellipsis; }
        .mini-list__foot { display: flex; align-items: center; gap: 8px; font-size: 0.78rem; color: var(--muted); padding-top: 2px; }

        .status-stack { margin-top: 8px; display: grid; gap: 10px; }
        .status-line { display: flex; align-items: center; gap: 12px; }
        .status-line__time { font-size: 0.76rem; color: var(--muted); font-variant-numeric: tabular-nums; min-width: 42px; }

        /* ---------- Safety section ---------- */
        .safety { display: grid; grid-template-columns: 1fr 0.92fr; gap: clamp(36px, 6vw, 80px); align-items: center; }
        .safety__points { margin: var(--space-xl) 0 0; padding: 0; list-style: none; display: grid; gap: var(--space-md); }
        .safety__points li { display: flex; gap: 12px; font-size: 1.02rem; color: var(--ink-soft); }
        .safety__check { flex: none; width: 24px; height: 24px; border-radius: 50%; background: var(--badge-sent-bg); color: var(--badge-sent-fg); display: grid; place-items: center; margin-top: 2px; }
        .safety__check svg { width: 15px; height: 15px; }
        .safety__points b { color: var(--ink); font-weight: 600; }

        .send-states { display: grid; gap: var(--space-md); background: var(--surface); border: 1px solid var(--hairline); border-radius: var(--radius-lg); padding: clamp(22px, 3vw, 32px); }
        .send-states__title { font-size: 0.74rem; font-weight: 700; letter-spacing: 0.04em; text-transform: uppercase; color: var(--muted); }
        .send-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .btn--send { background: var(--success); color: var(--surface); width: 100%; justify-content: center; }
        .btn--disabled { background: var(--field); color: var(--muted); border-color: var(--hairline); width: 100%; justify-content: center; cursor: not-allowed; }
        .send-hint { font-size: 0.82rem; color: var(--muted); }
        .send-hint--ok { color: var(--badge-sent-fg); }

        /* ---------- Final CTA ---------- */
        .cta-band { background: var(--ink); color: var(--surface); }
        .cta-band__inner { padding-block: clamp(56px, 8vw, 100px); display: flex; flex-direction: column; align-items: flex-start; gap: var(--space-lg); }
        .cta-band h2 { font-size: clamp(1.9rem, 3.6vw, 2.8rem); font-weight: 700; color: var(--surface); max-width: 18ch; line-height: 1.12; }
        .cta-band p { color: oklch(0.82 0.01 286); font-size: 1.08rem; max-width: 52ch; line-height: 1.6; }

        /* ---------- Footer ---------- */
        .site-footer { background: var(--ink); color: oklch(0.74 0.012 286); border-top: 1px solid oklch(0.32 0.008 286); }
        .site-footer__row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: var(--space-md); padding-block: var(--space-xl); font-size: 0.86rem; }
        .site-footer .brand { color: var(--surface); }

        /* ---------- Reveal motion ---------- */
        .is-ready [data-reveal] {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity 0.6s var(--ease-out), transform 0.6s var(--ease-out);
            transition-delay: var(--reveal-delay, 0ms);
        }
        .is-ready [data-reveal].in-view { opacity: 1; transform: none; }

        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
            .is-ready [data-reveal] { opacity: 1; transform: none; transition: none; }
            .btn, .mini-row, .skip-link { transition: none; }
        }

        /* ---------- Responsive ---------- */
        @media (max-width: 1000px) {
            .tile--wide { grid-column: span 3; }
            .tile--feature { grid-column: span 3; }
        }
        @media (max-width: 860px) {
            .hero__grid { grid-template-columns: 1fr; }
            .hero__media { order: -1; }
            .safety { grid-template-columns: 1fr; }
        }
        @media (max-width: 640px) {
            .features { grid-template-columns: 1fr; }
            .tile--feature, .tile--wide { grid-column: 1 / -1; }
            .hero h1 { font-size: clamp(2.1rem, 9vw, 2.8rem); }
            .hero__cta .btn { flex: 1; }
            .brand__name span { display: none; }
        }
    </style>
</head>
<body>
@php($loginUrl = filament()->getPanel('admin')->getLoginUrl())

<a class="skip-link" href="#contenu">Aller au contenu</a>

<header class="site-header">
    <div class="wrap site-header__row">
        <a class="brand" href="/" aria-label="Carnets et liste de diffusion, accueil">
            <span class="brand__mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
            </span>
            <span class="brand__name">Carnets <span>et liste de diffusion</span></span>
        </a>
        <a class="btn btn--primary btn--sm" href="{{ $loginUrl }}">Se connecter</a>
    </div>
</header>

<main id="contenu">

    <section class="hero wrap" aria-labelledby="hero-title">
        <div class="hero__grid">
            <div>
                <h1 id="hero-title" data-reveal>
                    Envoyez vos newsletters en sachant <em>exactement qui les reçoit</em>.
                </h1>
                <p class="hero__lead" data-reveal style="--reveal-delay:80ms">
                    Réunissez vos carnets d'adresses, vos contacts et vos campagnes au même endroit.
                    Rédigez un e-mail, envoyez-vous un aperçu, puis confirmez l'envoi en voyant le
                    nombre exact de destinataires.
                </p>
                <div class="hero__cta" data-reveal style="--reveal-delay:160ms">
                    <a class="btn btn--primary" href="{{ $loginUrl }}">
                        Se connecter
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a class="btn btn--ghost" href="#fonctionnalites">Voir les fonctionnalités</a>
                </div>
                <p class="hero__note" data-reveal style="--reveal-delay:220ms">Accès réservé aux membres de votre organisation.</p>
            </div>

            <div class="hero__media" data-reveal style="--reveal-delay:140ms">
                <div class="preview" role="img"
                     aria-label="Aperçu de l'application : avant l'envoi, une fenêtre de confirmation indique que l'e-mail sera envoyé à 248 destinataires.">
                    <div class="preview__bar" aria-hidden="true">
                        <span class="preview__dot"></span><span class="preview__dot"></span><span class="preview__dot"></span>
                        <span class="preview__tab">Newsletter de juin</span>
                        <span class="badge badge--draft" style="margin-left:auto">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.75 9v.91a2.25 2.25 0 0 1-1.18 1.98l-6.48 3.49M2.25 9v.91a2.25 2.25 0 0 0 1.18 1.98l6.48 3.49m8.84 2.51-4.66-2.51m0 0-1.02-.55a2.25 2.25 0 0 0-2.14 0l-1.02.55m0 0-4.66 2.51M21.75 8.84a2.25 2.25 0 0 0-1.18-1.98l-7.5-4.04a2.25 2.25 0 0 0-2.14 0l-7.5 4.04A2.25 2.25 0 0 0 2.25 8.84V19.5a2.25 2.25 0 0 0 2.25 2.25h15a2.25 2.25 0 0 0 2.25-2.25V8.84Z"/></svg>
                            Brouillon
                        </span>
                    </div>
                    <div class="preview__body">
                        <div class="compose" aria-hidden="true">
                            <div class="compose__field">
                                <span class="compose__label">Objet</span>
                                <div class="compose__input">Notre lettre de juin est arrivée</div>
                            </div>
                            <div class="compose__field">
                                <span class="compose__label">Expéditeur</span>
                                <div class="compose__input">Association &lt;contact@exemple.org&gt;</div>
                            </div>
                            <div class="compose__lines"><span></span><span></span><span></span></div>
                        </div>

                        <div class="modal">
                            <div class="modal__icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                            </div>
                            <h3>Envoyer la newsletter</h3>
                            <p>Cet e-mail sera envoyé à <b>248 destinataires</b>. Continuer ?</p>
                            <div class="modal__actions">
                                <span class="btn btn--ghost btn--sm">Annuler</span>
                                <span class="btn btn--send btn--sm" style="width:auto">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                                    Envoyer
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section--alt" id="fonctionnalites" aria-labelledby="features-title">
        <div class="wrap">
            <div class="section__head" data-reveal>
                <h2 id="features-title">Des carnets d'adresses à l'envoi</h2>
                <p>Tout ce qu'il faut pour tenir vos listes à jour et diffuser vos newsletters, réuni dans une seule application.</p>
            </div>

            <div class="features">
                <article class="tile tile--wide" data-reveal>
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 6.04A8.97 8.97 0 0 0 6 3.75c-1.05 0-2.06.18-3 .51v14.25A8.99 8.99 0 0 1 6 18c2.3 0 4.41.87 6 2.29m0-14.25a8.97 8.97 0 0 1 6-2.29c1.05 0 2.06.18 3 .51v14.25A8.99 8.99 0 0 0 18 18a8.97 8.97 0 0 0-6 2.29m0-14.25v14.25"/></svg>
                    </div>
                    <h3>Carnets d'adresses et contacts</h3>
                    <p>Regroupez vos contacts dans des carnets, importez-les depuis un fichier et partagez-les avec votre équipe.</p>
                    <div class="mini-list" aria-hidden="true">
                        <div class="mini-row">
                            <span class="mini-avatar">CM</span>
                            <span class="mini-row__text"><span class="mini-row__name">Claire Martin</span><span class="mini-row__mail">claire.martin@exemple.org</span></span>
                        </div>
                        <div class="mini-row">
                            <span class="mini-avatar">JD</span>
                            <span class="mini-row__text"><span class="mini-row__name">Jean Dubois</span><span class="mini-row__mail">j.dubois@exemple.org</span></span>
                        </div>
                        <div class="mini-list__foot">
                            <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                            Import depuis un fichier
                        </div>
                    </div>
                </article>

                <article class="tile tile--wide" data-reveal style="--reveal-delay:80ms">
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                    </div>
                    <h3>Suivi de chaque envoi</h3>
                    <p>Chaque campagne affiche son statut, du brouillon à l'envoi confirmé, et signale les échecs sans détour.</p>
                    <div class="status-stack" aria-hidden="true">
                        <div class="status-line"><span class="status-line__time">09:02</span><span class="badge badge--sending"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>Envoi en cours</span></div>
                        <div class="status-line"><span class="status-line__time">09:04</span><span class="badge badge--sent"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.24a2.25 2.25 0 0 1-1.07 1.92l-7.5 4.61a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.92V6.75"/></svg>Envoyé</span></div>
                    </div>
                </article>

                <article class="tile tile--feature" data-reveal>
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="m16.86 4.49 1.69-1.69a1.88 1.88 0 1 1 2.65 2.65L10.58 16.07a4.5 4.5 0 0 1-1.9 1.13L6 18l.8-2.69a4.5 4.5 0 0 1 1.13-1.9l8.93-8.92Zm0 0L19.5 7.13"/></svg>
                    </div>
                    <h3>Composition et pièces jointes</h3>
                    <p>Rédigez votre newsletter et joignez vos documents, jusqu'à 20 Mo par envoi.</p>
                </article>

                <article class="tile tile--feature" data-reveal style="--reveal-delay:60ms">
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M2.04 12.32a1.01 1.01 0 0 1 0-.64C3.42 7.51 7.36 4.5 12 4.5c4.64 0 8.57 3.01 9.96 7.18.07.21.07.43 0 .64C20.58 16.49 16.64 19.5 12 19.5c-4.64 0-8.57-3.01-9.96-7.18Z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    </div>
                    <h3>Aperçu avant envoi</h3>
                    <p>Envoyez-vous un e-mail de test pour vérifier le rendu réel avant de diffuser.</p>
                </article>

                <article class="tile tile--feature" data-reveal style="--reveal-delay:120ms">
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19.13a9.38 9.38 0 0 0 2.63.37 9.34 9.34 0 0 0 4.12-.95 4.13 4.13 0 0 0-7.53-2.5M15 19.13v-.01c0-1.11-.29-2.16-.79-3.06M15 19.13v.1A12.32 12.32 0 0 1 8.62 21c-2.33 0-4.51-.65-6.37-1.77v-.1a6.38 6.38 0 0 1 11.96-3.07M12 6.38a3.38 3.38 0 1 1-6.75 0 3.38 3.38 0 0 1 6.75 0Zm8.25 2.25a2.63 2.63 0 1 1-5.25 0 2.63 2.63 0 0 1 5.25 0Z"/></svg>
                    </div>
                    <h3>Plusieurs expéditeurs</h3>
                    <p>Gérez plusieurs adresses d'expédition et choisissez la bonne pour chaque campagne.</p>
                </article>

                <article class="tile tile--feature" data-reveal>
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12.75 11.25 15 15 9.75m-3-7.04A11.96 11.96 0 0 1 3.6 6 11.99 11.99 0 0 0 3 9.75c0 5.59 3.82 10.29 9 11.62 5.18-1.33 9-6.03 9-11.62 0-1.31-.21-2.57-.6-3.75h-.15c-3.2 0-6.1-1.25-8.25-3.29Z"/></svg>
                    </div>
                    <h3>Double authentification</h3>
                    <p>Protégez l'accès au compte avec une application d'authentification.</p>
                </article>

                <article class="tile tile--feature" data-reveal style="--reveal-delay:60ms">
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M19.5 14.25v-2.63a3.38 3.38 0 0 0-3.38-3.38h-1.5a1.13 1.13 0 0 1-1.12-1.12v-1.5A3.38 3.38 0 0 0 10.12 2.25H8.25m0 12.75h7.5m-7.5 3H12m-1.5-15.75H5.63c-.62 0-1.13.5-1.13 1.12v17.25c0 .62.5 1.13 1.13 1.13h12.75c.62 0 1.12-.5 1.12-1.13V11.25a9 9 0 0 0-9-9Z"/></svg>
                    </div>
                    <h3>Conformité RGPD</h3>
                    <p>Un guide du consentement intégré pour garder vos envois conformes.</p>
                </article>

                <article class="tile tile--feature" data-reveal style="--reveal-delay:120ms">
                    <div class="tile__icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14.86 17.08a23.85 23.85 0 0 0 5.45-1.31A8.97 8.97 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.97 8.97 0 0 1-2.31 6.02c1.73.64 3.56 1.09 5.45 1.31m5.72 0a24.26 24.26 0 0 1-5.72 0m5.72 0a3 3 0 1 1-5.72 0"/></svg>
                    </div>
                    <h3>Notifications dans l'application</h3>
                    <p>Suivez l'activité de vos envois directement dans l'application.</p>
                </article>
            </div>
        </div>
    </section>

    <section class="section" aria-labelledby="safety-title">
        <div class="wrap safety">
            <div>
                <div class="section__head" data-reveal>
                    <h2 id="safety-title">Voir la conséquence avant de valider</h2>
                    <p>Un envoi ne se rattrape pas. Avant chaque diffusion, l'application montre ce qui va réellement se passer.</p>
                </div>
                <ul class="safety__points">
                    <li data-reveal>
                        <span class="safety__check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></svg></span>
                        <span>Le <b>nombre exact de destinataires</b>, affiché dans la confirmation d'envoi.</span>
                    </li>
                    <li data-reveal style="--reveal-delay:70ms">
                        <span class="safety__check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></svg></span>
                        <span>Un <b>aperçu de test</b> à vous envoyer avant la diffusion réelle.</span>
                    </li>
                    <li data-reveal style="--reveal-delay:140ms">
                        <span class="safety__check" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m4.5 12.75 6 6 9-13.5"/></svg></span>
                        <span>Le bouton d'envoi <b>désactivé</b> tant qu'aucun contact n'est sélectionné.</span>
                    </li>
                </ul>
            </div>

            <div class="send-states" data-reveal style="--reveal-delay:80ms" role="img"
                 aria-label="Deux états du bouton d'envoi : désactivé lorsque la liste est vide, actif lorsque 248 contacts sont sélectionnés.">
                <div>
                    <p class="send-states__title">Liste vide</p>
                    <div class="send-row" style="margin-top:10px">
                        <span class="btn btn--disabled">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                            Envoyer à 0 destinataire
                        </span>
                    </div>
                    <p class="send-hint" style="margin-top:10px">Ajoutez des contacts pour activer l'envoi.</p>
                </div>
                <div style="border-top:1px solid var(--hairline); padding-top:var(--space-md)">
                    <p class="send-states__title">248 contacts sélectionnés</p>
                    <div class="send-row" style="margin-top:10px">
                        <span class="btn btn--send">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
                            Envoyer à 248 destinataires
                        </span>
                    </div>
                    <p class="send-hint send-hint--ok" style="margin-top:10px">Prêt à diffuser, après votre confirmation.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-band" aria-labelledby="cta-title">
        <div class="wrap cta-band__inner">
            <h2 id="cta-title" data-reveal>Prêt pour votre prochaine newsletter ?</h2>
            <p data-reveal style="--reveal-delay:70ms">Connectez-vous pour retrouver vos carnets d'adresses, reprendre un brouillon ou lancer une nouvelle diffusion.</p>
            <a class="btn btn--primary" href="{{ $loginUrl }}" data-reveal style="--reveal-delay:140ms">
                Se connecter
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    </section>
</main>

<footer class="site-footer">
    <div class="wrap site-footer__row">
        <a class="brand" href="/">
            <span class="brand__mark" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M6 12 3.27 3.13A59.77 59.77 0 0 1 21.49 12 59.77 59.77 0 0 1 3.27 20.88L6 12Zm0 0h7.5"/></svg>
            </span>
            <span class="brand__name">Carnets et liste de diffusion</span>
        </a>
        <span>&copy; {{ date('Y') }} Carnets et liste de diffusion</span>
    </div>
</footer>

<script>
    (function () {
        var els = document.querySelectorAll('[data-reveal]');
        var revealAll = function () { els.forEach(function (el) { el.classList.add('in-view'); }); };
        if (!('IntersectionObserver' in window)) { revealAll(); return; }
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });
        els.forEach(function (el) { io.observe(el); });
        // Safety net: anything still hidden (hidden tab, headless renderer,
        // observer never firing) is revealed so content never ships blank.
        setTimeout(revealAll, 1600);
    })();
</script>
</body>
</html>
