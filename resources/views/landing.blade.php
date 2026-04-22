<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlowTask - Task Management Made Simple</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@300;400&display=swap");

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            color-scheme: dark;

            --dark-bg: #1a1a2e;
            --dark-fg: #ede8df;
            --dark-muted: #8a7b6e;
            --light-bg: #f0ece3;
            --light-fg: #0d0d14;
            --light-muted: #9a9aaa;
            --accent-dark: #5cb85c;
            --accent-light: #5cb85c;

            --bg: var(--dark-bg);
            --fg: var(--dark-fg);
            --muted: var(--dark-muted);
            --accent: var(--accent-dark);

            --font-display: "Bebas Neue", sans-serif;
            --font-mono: "DM Mono", monospace;
            --hairline: 0.0625rem;
            --ui-inset: 2rem;
            --card-bg: rgba(26, 26, 46, 0.82);
            --card-border: rgba(58, 110, 0, 0.2);
            --nav-x: calc(var(--ui-inset) + 0.125rem);
            --reveal-offset: 0.625rem;
            --reveal-duration: 0.5s;
            --z-ui: 10;
        }

        html {
            color-scheme: dark;
        }

        body {
            background: var(--bg);
            color: var(--fg);
            font-family: var(--font-mono);
            overflow-x: hidden;
            transition: background 0.3s ease, color 0.3s ease;
        }

        #scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            perspective: 1100px;
            pointer-events: none;
        }

        #scroll_container {
            position: relative;
            z-index: 1;
        }

        section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 6rem calc(5rem + var(--ui-inset)) 6rem 5rem;
        }

        #cube {
            --s: min(74vw, 74vh, 560px);
            width: var(--s);
            height: var(--s);
            position: relative;
            transform-style: preserve-3d;
            transform: rotateX(90deg) rotateY(0deg);
            will-change: transform;
        }

        .face {
            position: absolute;
            inset: 0;
            overflow: hidden;
            backface-visibility: hidden;
            background: repeating-linear-gradient(
                0deg,
                rgba(255, 255, 255, 0.02) 0,
                rgba(255, 255, 255, 0.02) 1px,
                transparent 1px,
                transparent 48px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(255, 255, 255, 0.02) 0,
                rgba(255, 255, 255, 0.02) 1px,
                transparent 1px,
                transparent 48px
            ),
            #14100d;
        }

        .face-ph {
            position: absolute;
            bottom: 1.5rem;
            left: 1.75rem;
            font-family: var(--font-display);
            font-size: clamp(2rem, 8vw, 5rem);
            letter-spacing: 0.04em;
            color: rgba(255, 255, 255, 0.06);
            pointer-events: none;
            user-select: none;
        }

        .face[data-face="front"] {
            transform: translateZ(calc(var(--s) / 2));
        }
        .face[data-face="back"] {
            transform: rotateY(180deg) translateZ(calc(var(--s) / 2));
        }
        .face[data-face="right"] {
            transform: rotateY(90deg) translateZ(calc(var(--s) / 2));
        }
        .face[data-face="left"] {
            transform: rotateY(-90deg) translateZ(calc(var(--s) / 2));
        }
        .face[data-face="top"] {
            transform: rotateX(-90deg) translateZ(calc(var(--s) / 2));
        }
        .face[data-face="bottom"] {
            transform: rotateX(90deg) translateZ(calc(var(--s) / 2));
        }

        #hud {
            position: fixed;
            top: var(--ui-inset);
            right: var(--ui-inset);
            z-index: var(--z-ui);
            text-align: right;
            font-size: 0.65rem;
            letter-spacing: 0.15em;
            color: var(--muted);
            text-transform: uppercase;
        }

        .progress-bar {
            width: 7.5rem;
            height: var(--hairline);
            background: var(--muted);
            margin-block-start: 0.5rem;
            margin-inline-start: auto;
            position: relative;
            overflow: hidden;
        }

        .progress-fill {
            position: absolute;
            inset-block: 0;
            inset-inline-start: 0;
            width: 0%;
            background: #3a6e00;
            transition: width 0.1s linear;
        }

        .scene-label {
            font-size: 0.6rem;
            color: #3a6e00;
            margin-block-start: 0.4rem;
        }

        #scene_strip {
            position: fixed;
            left: var(--nav-x);
            top: 50%;
            translate: -50% -50%;
            z-index: var(--z-ui);
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .scene-dot {
            position: relative;
            display: block;
            width: 0.25rem;
            height: 0.25rem;
            border-radius: 50%;
            background: var(--muted);
            transition: background 0.3s, scale 0.3s;
            cursor: pointer;
        }

        .scene-dot::before {
            content: "";
            position: absolute;
            inset: -0.2rem;
        }

        .scene-dot.active {
            background: #3a6e00;
            scale: 1.8;
        }

        #theme_toggle {
            position: fixed;
            bottom: var(--ui-inset);
            left: var(--nav-x);
            translate: -50% 0;
            z-index: var(--z-ui);
            width: 2rem;
            height: 2rem;
            border: none;
            background: color-mix(in srgb, var(--muted) 35%, transparent);
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        #theme_toggle:hover {
            background: color-mix(in srgb, var(--muted) 55%, transparent);
        }

        #theme_toggle svg {
            width: 0.875rem;
            height: 0.875rem;
            position: absolute;
            transition: opacity 0.3s ease, rotate 0.3s ease;
            color: #3a6e00;
        }

        .icon-sun {
            opacity: 1;
            rotate: 0deg;
        }

        .icon-moon {
            opacity: 0;
            rotate: 90deg;
        }

        #face_caption {
            position: fixed;
            bottom: var(--ui-inset);
            left: 50%;
            translate: -50% 0;
            z-index: var(--z-ui);
            text-align: center;
            pointer-events: none;
            user-select: none;
        }

        #face_caption_num {
            font-size: 0.58rem;
            letter-spacing: 0.28em;
            color: #3a6e00;
            text-transform: uppercase;
            margin-block-end: 0.15rem;
        }

        #face_caption_name {
            font-family: var(--font-display);
            font-size: clamp(1.8rem, 5vw, 3.5rem);
            letter-spacing: 0.08em;
            color: var(--muted);
            opacity: 0.5;
            line-height: 1;
        }

        .text-card {
            max-width: 23.75rem;
            padding: 2.25rem 2rem;
            background: var(--card-bg);
            border-left: var(--hairline) solid var(--card-border);
            backdrop-filter: blur(6px) saturate(120%);
            -webkit-backdrop-filter: blur(6px) saturate(120%);
            overflow: hidden;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .text-card.right {
            margin-inline-start: auto;
            border-left: none;
            border-right: var(--hairline) solid var(--card-border);
            text-align: right;
        }

        .text-card.right .h-line {
            transform-origin: right;
            margin-inline-start: auto;
        }

        .text-card.center {
            margin-inline: auto;
            border-left: none;
            border-top: var(--hairline) solid var(--card-border);
            text-align: center;
            max-width: 28.75rem;
        }

        .text-card.center .h-line {
            transform-origin: center;
            margin-inline: auto;
        }

        .tag {
            font-size: 0.6rem;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: #3a6e00;
            margin-block-end: 1.1rem;
        }

        h1, h2 {
            font-family: var(--font-display);
            font-weight: 400;
            letter-spacing: 0.03em;
            line-height: 0.92;
        }

        h1 {
            font-size: clamp(3rem, 8vw, 6.5rem);
        }
        h2 {
            font-size: clamp(2.2rem, 5vw, 4rem);
        }

        .body-text {
            font-size: 0.78rem;
            line-height: 1.8;
            color: color-mix(in srgb, var(--fg) 55%, transparent);
            margin-block-start: 1.25rem;
        }

        .stat-row {
            display: flex;
            gap: 2.5rem;
            margin-block-start: 2rem;
            flex-wrap: wrap;
        }

        .stat {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .stat-num {
            font-family: var(--font-display);
            font-size: 2.2rem;
            color: #3a6e00;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.58rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .h-line {
            width: 3.125rem;
            height: var(--hairline);
            background: #3a6e00;
            margin-block-end: 1.2rem;
            transform-origin: left;
        }

        .cta-row {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
            margin-block-start: 1.75rem;
        }

        .text-card.right .cta-row {
            justify-content: flex-end;
        }

        .cta {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1.25rem;
            border: var(--hairline) solid #3a6e00;
            color: #3a6e00;
            font-family: var(--font-mono);
            font-size: 0.62rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .cta:hover {
            background: #3a6e00;
            color: var(--bg);
        }

        .cta svg {
            width: 0.6875rem;
            height: 0.6875rem;
        }

        .cta-back {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.6rem 1.25rem;
            border: var(--hairline) solid
                color-mix(in srgb, var(--muted) 45%, transparent);
            color: var(--muted);
            font-family: var(--font-mono);
            font-size: 0.62rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, border-color 0.2s;
        }

        .cta-back:hover {
            background: color-mix(in srgb, var(--muted) 12%, transparent);
            border-color: var(--muted);
            color: var(--fg);
        }

        .cta-back svg {
            width: 0.6875rem;
            height: 0.6875rem;
        }

        :is(.tag, h1, h2, .body-text, .stat-row, .cta, .cta-back) {
            opacity: 0;
            translate: 0 var(--reveal-offset);
        }

        :is(h1, h2) {
            translate: 0 1.125rem;
            transition: opacity var(--reveal-duration) ease 0.08s,
                translate var(--reveal-duration) ease 0.08s;
        }

        .tag {
            transition: opacity var(--reveal-duration) ease,
                translate var(--reveal-duration) ease;
        }

        .body-text {
            transition: opacity var(--reveal-duration) ease 0.2s,
                translate var(--reveal-duration) ease 0.2s;
        }

        .stat-row {
            transition: opacity var(--reveal-duration) ease 0.3s,
                translate var(--reveal-duration) ease 0.3s;
        }

        :is(.cta, .cta-back) {
            transition: opacity var(--reveal-duration) ease 0.35s,
                translate var(--reveal-duration) ease 0.35s, background 0.2s, color 0.2s,
                border-color 0.2s;
        }

        .h-line {
            opacity: 0;
            scale: 0 1;
            transition: opacity 0.4s ease, scale 0.4s ease;
        }

        :is(.tag, h1, h2, .body-text, .stat-row, .cta, .cta-back).visible {
            opacity: 1;
            translate: 0 0;
        }

        .h-line.visible {
            opacity: 1;
            scale: 1 1;
        }

        :root[data-theme="light"] {
            color-scheme: light;
            --bg: var(--light-bg);
            --fg: var(--light-fg);
            --muted: var(--light-muted);
            --accent: #3a6e00;
            --card-bg: rgba(240, 236, 227, 0.08);
            --card-border: rgba(58, 110, 0, 0.14);
        }

        :root[data-theme="light"] .face {
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.05) 0,
                rgba(0, 0, 0, 0.05) 1px,
                transparent 1px,
                transparent 48px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(0, 0, 0, 0.05) 0,
                rgba(0, 0, 0, 0.05) 1px,
                transparent 1px,
                transparent 48px
            ),
            #ddd8cf;
        }

        :root[data-theme="light"] .face-ph {
            color: rgba(0, 0, 0, 0.07);
        }

        :root[data-theme="light"] #theme_toggle svg {
            color: #3a6e00;
        }

        :root[data-theme="light"] .icon-sun {
            opacity: 0;
            rotate: -90deg;
        }

        :root[data-theme="light"] .icon-moon {
            opacity: 1;
            rotate: 0deg;
        }

        :root[data-theme="light"] #face_caption_name {
            opacity: 0.35;
        }

        @media (width <= 56.25em) {
            #hud {
                top: 1rem;
                right: 1rem;
            }

            #scene_strip {
                display: none;
            }

            #theme_toggle {
                bottom: 1rem;
                left: 1.25rem;
                translate: 0 0;
            }

            #face_caption {
                bottom: 1rem;
            }

            section {
                min-height: 150vh;
                align-items: flex-end;
                padding: 0 1.5rem 3.5rem;
            }

            #s0 {
                min-height: 100vh;
                align-items: center;
                padding: 4rem 1.5rem;
            }

            :is(.text-card, .text-card.right, .text-card.center) {
                max-width: 100%;
                padding: 1.5rem 1.25rem;
            }

            .body-text {
                line-height: 1.55;
            }

            .stat-row {
                gap: 1.5rem;
                margin-block-start: 1.25rem;
            }

            .cta-row {
                margin-block-start: 1.25rem;
            }
        }

        /* Login buttons styling */
        .login-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .login-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            padding: 0.8rem 1.5rem;
            border: var(--hairline) solid #3a6e00;
            color: #3a6e00;
            font-family: var(--font-mono);
            font-size: 0.7rem;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 4px;
        }

        .login-btn:hover {
            background: #3a6e00;
            color: var(--bg);
            transform: translateY(-2px);
        }

        .login-btn svg {
            width: 0.875rem;
            height: 0.875rem;
        }

        .login-btn.primary {
            background: #3a6e00;
            color: var(--bg);
        }

        .login-btn.primary:hover {
            background: color-mix(in srgb, #3a6e00 80%, transparent);
        }

        
            </style>
</head>
<body>
    <div id="scene">
        <div id="cube">
            <div class="face" data-face="top" data-i="0"><span class="face-ph">TOP</span></div>
            <div class="face" data-face="front" data-i="1"><span class="face-ph">FRONT</span></div>
            <div class="face" data-face="right" data-i="2"><span class="face-ph">RIGHT</span></div>
            <div class="face" data-face="back" data-i="3"><span class="face-ph">BACK</span></div>
            <div class="face" data-face="left" data-i="4"><span class="face-ph">LEFT</span></div>
            <div class="face" data-face="bottom" data-i="5"><span class="face-ph">BOTTOM</span></div>
        </div>
    </div>

    <div id="hud">
        <div id="hud_pct">000%</div>
        <div class="progress-bar">
            <div class="progress-fill" id="prog_fill"></div>
        </div>
        <div class="scene-label" id="scene_name">FLOWTASK</div>
    </div>

    <button id="theme_toggle" aria-label="Toggle light/dark mode">
        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <circle cx="12" cy="12" r="4" />
            <path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
        </svg>
        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
            <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z" />
        </svg>
    </button>

    <div id="scene_strip">
        <a href="#s0" class="scene-dot active"></a>
        <a href="#s1" class="scene-dot"></a>
        <a href="#s2" class="scene-dot"></a>
        <a href="#s3" class="scene-dot"></a>
        <a href="#s4" class="scene-dot"></a>
        <a href="#s5" class="scene-dot"></a>
    </div>

    <div id="face_caption">
        <div id="face_caption_num">01</div>
        <div id="face_caption_name">FLOWTASK</div>
    </div>

    <div id="scroll_container">

        <section id="s0">
            <div class="text-card center">
                <div class="tag">FlowTask — Task Management</div>
                <h1>FLOW<br>TASK</h1>
                <p class="body-text">
                    A modern task management system designed to streamline your workflow and boost productivity.
                    Create tasks, track time, monitor progress, and generate detailed reports.
                    Scroll to explore features.
                </p>
                <div class="login-buttons">
                    <a href="{{ route('admin.login') }}" class="login-btn primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        Admin Login
                    </a>
                    <a href="{{ route('staff.login') }}" class="login-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        Staff Login
                    </a>
                </div>
            </div>
        </section>

        <section id="s1">
            <div class="text-card right">
                <div class="h-line"></div>
                <div class="tag">01 — Task Management</div>
                <h2>CREATE<br>& MANAGE<br>TASKS</h2>
                <p class="body-text">
                    Create, edit, and delete tasks with ease. 
                    Add detailed descriptions, set priorities, 
                    and organize your work efficiently.
                    Everything you need to stay on track.
                </p>
                <div class="cta-row">
                    <a class="cta-back" href="#s0">
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 6H1M6 11L1 6l5-5" />
                        </svg>
                        Back
                    </a>
                    <a class="cta" href="#s2">
                        Next
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 6h10M6 1l5 5-5 5" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="s2">
            <div class="text-card">
                <div class="h-line"></div>
                <div class="tag">02 — Time Tracking</div>
                <h2>TRACK<br>YOUR<br>TIME</h2>
                <p class="body-text">
                    Log hours and minutes for accurate time tracking.
                    Monitor how long each task takes and 
                    identify productivity patterns.
                    Data-driven insights for better management.
                </p>
                <div class="cta-row">
                    <a class="cta-back" href="#s1">
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 6H1M6 11L1 6l5-5" />
                        </svg>
                        Back
                    </a>
                    <a class="cta" href="#s3">
                        Next
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 6h10M6 1l5 5-5 5" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="s3">
            <div class="text-card right">
                <div class="h-line"></div>
                <div class="tag">03 — Status Updates</div>
                <h2>MONITOR<br>PROGRESS<br>IN REAL-TIME</h2>
                <p class="body-text">
                    Update task status from pending to in-progress to completed.
                    Track the lifecycle of every task and 
                    never lose sight of what matters.
                    Stay informed, stay ahead.
                </p>
                <div class="stat-row" style="justify-content: flex-end">
                    <div class="stat">
                        <span class="stat-num">3</span>
                        <span class="stat-label">Statuses</span>
                    </div>
                    <div class="stat">
                        <span class="stat-num">100</span>
                        <span class="stat-label">Trackable</span>
                    </div>
                </div>
                <div class="cta-row">
                    <a class="cta-back" href="#s2">
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 6H1M6 11L1 6l5-5" />
                        </svg>
                        Back
                    </a>
                    <a class="cta" href="#s4">
                        Next
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 6h10M6 1l5 5-5 5" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="s4">
            <div class="text-card">
                <div class="h-line"></div>
                <div class="tag">04 — Admin Controls</div>
                <h2>MANAGE<br>WITH<br>CONTROL</h2>
                <p class="body-text">
                    Admins can lock/unlock tasks for better control.
                    Manage staff members, assign tasks,
                    and maintain oversight of all operations.
                    Empower your administrators.
                </p>
                <div class="cta-row">
                    <a class="cta-back" href="#s3">
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 6H1M6 11L1 6l5-5" />
                        </svg>
                        Back
                    </a>
                    <a class="cta" href="#s5">
                        Next
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 6h10M6 1l5 5-5 5" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section id="s5">
            <div class="text-card right">
                <div class="h-line"></div>
                <div class="tag">05 — Reports</div>
                <h2>DETAILED<br>REPORTS<br>& ANALYTICS</h2>
                <p class="body-text">
                    Generate comprehensive reports for staff performance.
                    Filter by day, month, or all-time.
                    Track time spent, completed tasks, and productivity metrics.
                    Data at your fingertips.
                </p>
                <div class="login-buttons">
                    <a href="{{ route('admin.login') }}" class="login-btn primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        Admin Login
                    </a>
                    <a href="{{ route('staff.login') }}" class="login-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                        Staff Login
                    </a>
                </div>
                <div class="cta-row">
                    <a class="cta-back" href="#s4">
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M11 6H1M6 11L1 6l5-5" />
                        </svg>
                        Back
                    </a>
                    <a class="cta" href="#s0">
                        Start again
                        <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M1 6h10M6 1l5 5-5 5" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

    </div>

    <script>
        const FACE_NAMES = [
            "FLOWTASK",
            "TASK MANAGEMENT",
            "TIME TRACKING",
            "STATUS UPDATES",
            "ADMIN CONTROLS",
            "REPORTS"
        ];

        const N = 6;
        const STOPS = [
            { rx: 90, ry: 0 },
            { rx: 0, ry: 0 },
            { rx: 0, ry: -90 },
            { rx: 0, ry: -180 },
            { rx: 0, ry: -270 },
            { rx: -90, ry: -360 }
        ];

        function faceAtStop(i) {
            if (i < 6) return i;
            return 1 + ((i - 2) % 4);
        }

        const dom = {
            cube: document.getElementById("cube"),
            faces: [...document.querySelectorAll(".face")],
            scrollEl: document.getElementById("scroll_container"),
            strip: document.getElementById("scene_strip"),
            hudPct: document.getElementById("hud_pct"),
            progFill: document.getElementById("prog_fill"),
            sceneName: document.getElementById("scene_name"),
            captionNum: document.getElementById("face_caption_num"),
            captionName: document.getElementById("face_caption_name"),
            themeToggle: document.getElementById("theme_toggle")
        };

        const sceneDots = [...document.querySelectorAll(".scene-dot")];
        const sections = [...document.querySelectorAll("#scroll_container section")];

        let currentStop = -1;

        const isDark = () =>
            document.documentElement.getAttribute("data-theme") === "dark";

        const applyTheme = (theme) => {
            document.documentElement.setAttribute("data-theme", theme);
            document.documentElement.style.colorScheme = theme;
        };

        const mq = window.matchMedia("(prefers-color-scheme: dark)");
        const getSystemTheme = () => (mq.matches ? "dark" : "light");
        applyTheme(getSystemTheme());
        mq.addEventListener("change", (e) => applyTheme(e.matches ? "dark" : "light"));

        dom.themeToggle.addEventListener("click", () => {
            const cur =
                document.documentElement.getAttribute("data-theme") || getSystemTheme();
            applyTheme(cur === "dark" ? "light" : "dark");
        });

        const mqSmall = window.matchMedia("(max-width: 56.25em)");

        let maxScroll = 1;
        let lastScrollHeight = 0;
        let lastInnerHeight = 0;

        const resize = () => {
            const h = document.documentElement.scrollHeight;
            const vh = innerHeight;
            if (h === lastScrollHeight && vh === lastInnerHeight) return;
            lastScrollHeight = h;
            lastInnerHeight = vh;
            maxScroll = Math.max(1, h - vh);
        };

        resize();

        let tgt = 0;
        let smooth = 0;
        let velocity = 0;

        const ease = 0.1;
        const dynamicFriction = (v) => (Math.abs(v) > 200 ? 0.8 : 0.9);

        window.addEventListener("resize", () => {
            resize();
            tgt = maxScroll > 0 ? scrollY / maxScroll : 0;
            smooth = tgt;
        });

        let resizePending = false;
        const ro = new ResizeObserver(() => {
            if (resizePending) return;
            resizePending = true;
            requestAnimationFrame(() => {
                resize();
                tgt = maxScroll > 0 ? scrollY / maxScroll : 0;
                smooth = tgt;
                resizePending = false;
            });
        });
        ro.observe(document.documentElement);

        window.addEventListener(
            "scroll",
            () => {
                tgt = maxScroll > 0 ? scrollY / maxScroll : 0;
                tgt = Math.max(0, Math.min(1, tgt));
            },
            { passive: true }
        );

        window.addEventListener(
            "wheel",
            (e) => {
                e.preventDefault();
                const linePx = 16;
                const pagePx = innerHeight * 0.9;
                const delta =
                    e.deltaMode === 1
                        ? e.deltaY * linePx
                        : e.deltaMode === 2
                        ? e.deltaY * pagePx
                        : e.deltaY;
                if (Math.abs(delta) < 5) return;
                stopAnchorAnim();
                velocity += delta;
                velocity = Math.max(-600, Math.min(600, velocity));
            },
            { passive: false }
        );

        const revealEls = [
            ...document.querySelectorAll(
                ".tag, h1, h2, .body-text, .stat-row, .cta, .cta-back, .h-line, .login-btn"
            )
        ];

        const io = new IntersectionObserver(
            (entries) =>
                entries.forEach((e) => {
                    if (e.isIntersecting) {
                        e.target.classList.add("visible");
                        io.unobserve(e.target);
                    }
                }),
            { threshold: 0.1 }
        );
        revealEls.forEach((el) => io.observe(el));

        let lastNow = performance.now();

        const updateHUD = (s) => {
            const p = Math.round(s * 100);
            const si = Math.min(N - 1, Math.floor(s * (N - 1)));
            currentStop = si;
            dom.hudPct.textContent = String(p).padStart(3, "0") + "%";
            dom.progFill.style.width = `${p}%`;
            if (si !== lastFaceIdx) {
                lastFaceIdx = si;
                const name = FACE_NAMES[si] ?? "";
                dom.sceneName.textContent = name;
                dom.captionNum.textContent = String(si + 1).padStart(2, "0");
                dom.captionName.textContent = name;
                sceneDots.forEach((d, i) => d.classList.toggle("active", i === si));
            }
        };

        let lastFaceIdx = -1;

        const easeIO = (t) => (t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t);

        const setCubeTransform = (s) => {
            if (N < 2 || STOPS.length < 2) return;
            const t = s * (N - 1);
            const i = Math.min(Math.floor(t), N - 2);
            const f = easeIO(t - i);
            const a = STOPS[i];
            const b = STOPS[i + 1];
            const rx = a.rx + (b.rx - a.rx) * f;
            const ry = a.ry + (b.ry - a.ry) * f;
            dom.cube.style.transform = `rotateX(${rx}deg) rotateY(${ry}deg)`;
        };

        const frame = (now) => {
            requestAnimationFrame(frame);

            if (document.hidden) {
                lastNow = now;
                return;
            }

            const dt = Math.min((now - lastNow) / 1000, 0.05);
            lastNow = now;

            velocity *= Math.pow(dynamicFriction(velocity), dt * 60);
            if (Math.abs(velocity) < 0.01) velocity = 0;

            if (Math.abs(velocity) > 0.2) {
                const next = Math.max(0, Math.min(scrollY + velocity * ease, maxScroll));
                window.scrollTo(0, next);
                tgt = next / maxScroll;
            }

            smooth += (tgt - smooth) * (1 - Math.exp(-dt * 8));
            smooth = Math.max(0, Math.min(1, smooth));

            updateHUD(smooth);
            setCubeTransform(smooth);
        };

        requestAnimationFrame(frame);

        let anchorAnim = null;
        let isAnchorScrolling = false;

        const stopAnchorAnim = () => {
            if (anchorAnim) {
                cancelAnimationFrame(anchorAnim);
                anchorAnim = null;
            }
            isAnchorScrolling = false;
        };

        const easeInOutCubic = (t) =>
            t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

        const smoothScrollToY = (targetY, duration = 900) => {
            stopAnchorAnim();
            velocity = 0;
            isAnchorScrolling = true;
            const startY = window.scrollY;
            const diff = targetY - startY;
            const start = performance.now();
            const tick = (now) => {
                const p = Math.min(1, (now - start) / duration);
                const y = startY + diff * easeInOutCubic(p);
                window.scrollTo(0, y);
                tgt = y / maxScroll;
                smooth = tgt;
                if (p < 1) {
                    anchorAnim = requestAnimationFrame(tick);
                } else {
                    anchorAnim = null;
                    isAnchorScrolling = false;
                }
            };
            anchorAnim = requestAnimationFrame(tick);
        };

        window.addEventListener("touchstart", stopAnchorAnim, { passive: true });
        window.addEventListener("mousedown", stopAnchorAnim, { passive: true });
        window.addEventListener("keydown", stopAnchorAnim);

        document.addEventListener("click", (e) => {
            const a = e.target.closest('a[href^="#s"]');
            if (!a) return;
            const target = document.querySelector(a.getAttribute("href"));
            if (!target) return;
            e.preventDefault();
            const isHero = a.getAttribute("href") === "#s0";
            const idx = sections.indexOf(target);
            const baseY = idx >= 0 ? target.offsetTop : target.getBoundingClientRect().top + window.scrollY;
            const extraOffset =
                mqSmall.matches && !isHero
                    ? Math.max(0, target.offsetHeight - innerHeight)
                    : 0;
            smoothScrollToY(Math.max(0, baseY + extraOffset));
        });

        // Modern Carousel JavaScript
        class MzaCarousel {
            constructor(root, opts = {}) {
                this.root = root;
                this.viewport = root.querySelector(".mzaCarousel-viewport");
                this.track = root.querySelector(".mzaCarousel-track");
                this.slides = Array.from(root.querySelectorAll(".mzaCarousel-slide"));
                this.prevBtn = root.querySelector(".mzaCarousel-prev");
                this.nextBtn = root.querySelector(".mzaCarousel-next");
                this.pagination = root.querySelector(".mzaCarousel-pagination");
                this.progressBar = root.querySelector(".mzaCarousel-progressBar");
                this.isFF = typeof InstallTrigger !== "undefined";
                this.n = this.slides.length;
                this.state = {
                    index: 0,
                    pos: 0,
                    width: 0,
                    height: 0,
                    gap: 28,
                    dragging: false,
                    pointerId: null,
                    x0: 0,
                    v: 0,
                    t0: 0,
                    animating: false,
                    hovering: false,
                    startTime: 0,
                    pausedAt: 0,
                    rafId: 0
                };
                this.opts = Object.assign(
                    {
                        gap: 28,
                        peek: 0.15,
                        rotateY: 34,
                        zDepth: 150,
                        scaleDrop: 0.09,
                        blurMax: 2.0,
                        activeLeftBias: 0.12,
                        interval: 4500,
                        transitionMs: 900,
                        keyboard: true,
                        breakpoints: [
                            {
                                mq: "(max-width: 1200px)",
                                gap: 24,
                                peek: 0.12,
                                rotateY: 28,
                                zDepth: 120,
                                scaleDrop: 0.08,
                                activeLeftBias: 0.1
                            },
                            {
                                mq: "(max-width: 1000px)",
                                gap: 18,
                                peek: 0.09,
                                rotateY: 22,
                                zDepth: 90,
                                scaleDrop: 0.07,
                                activeLeftBias: 0.09
                            },
                            {
                                mq: "(max-width: 768px)",
                                gap: 14,
                                peek: 0.06,
                                rotateY: 16,
                                zDepth: 70,
                                scaleDrop: 0.06,
                                activeLeftBias: 0.08
                            },
                            {
                                mq: "(max-width: 560px)",
                                gap: 12,
                                peek: 0.05,
                                rotateY: 12,
                                zDepth: 60,
                                scaleDrop: 0.05,
                                activeLeftBias: 0.07
                            }
                        ]
                    },
                    opts
                );
                if (this.isFF) {
                    this.opts.rotateY = 10;
                    this.opts.zDepth = 0;
                    this.opts.blurMax = 0;
                }
                this._init();
            }

            _init() {
                this._setupDots();
                this._bind();
                this._preloadImages();
                this._measure();
                this.goTo(0, false);
                this._startCycle();
                this._loop();
            }

            _preloadImages() {
                this.slides.forEach((sl) => {
                    const card = sl.querySelector(".mzaCard");
                    const bg = getComputedStyle(card).getPropertyValue("--mzaCard-bg");
                    const m = /url\((?:'|")?([^'")]+)(?:'|")?\)/.exec(bg);
                    if (m && m[1]) {
                        const img = new Image();
                        img.src = m[1];
                    }
                });
            }

            _setupDots() {
                this.pagination.innerHTML = "";
                this.dots = this.slides.map((_, i) => {
                    const b = document.createElement("button");
                    b.type = "button";
                    b.className = "mzaCarousel-dot";
                    b.setAttribute("role", "tab");
                    b.setAttribute("aria-label", `Go to slide ${i + 1}`);
                    b.addEventListener("click", () => {
                        this.goTo(i);
                    });
                    this.pagination.appendChild(b);
                    return b;
                });
            }

            _bind() {
                this.prevBtn.addEventListener("click", () => {
                    this.prev();
                });
                this.nextBtn.addEventListener("click", () => {
                    this.next();
                });
                if (this.opts.keyboard) {
                    this.root.addEventListener("keydown", (e) => {
                        if (e.key === "ArrowLeft") this.prev();
                        if (e.key === "ArrowRight") this.next();
                    });
                }
                const pe = this.viewport;
                pe.addEventListener("pointerdown", (e) => this._onDragStart(e));
                pe.addEventListener("pointermove", (e) => this._onDragMove(e));
                pe.addEventListener("pointerup", (e) => this._onDragEnd(e));
                pe.addEventListener("pointercancel", (e) => this._onDragEnd(e));
                this.root.addEventListener("mouseenter", () => {
                    this.state.hovering = true;
                    this.state.pausedAt = performance.now();
                });
                this.root.addEventListener("mouseleave", () => {
                    if (this.state.pausedAt) {
                        this.state.startTime += performance.now() - this.state.pausedAt;
                        this.state.pausedAt = 0;
                    }
                    this.state.hovering = false;
                });
                this.ro = new ResizeObserver(() => this._measure());
                this.ro.observe(this.viewport);
                this.opts.breakpoints.forEach((bp) => {
                    const m = window.matchMedia(bp.mq);
                    const apply = () => {
                        Object.keys(bp).forEach((k) => {
                            if (k !== "mq") this.opts[k] = bp[k];
                        });
                        this._measure();
                        this._render();
                    };
                    if (m.addEventListener) m.addEventListener("change", apply);
                    else m.addListener(apply);
                    if (m.matches) apply();
                });
                this.viewport.addEventListener("pointermove", (e) => this._onTilt(e));
                window.addEventListener("orientationchange", () =>
                    setTimeout(() => this._measure(), 250)
                );
            }

            _measure() {
                const viewRect = this.viewport.getBoundingClientRect();
                const rootRect = this.root.getBoundingClientRect();
                const pagRect = this.pagination.getBoundingClientRect();
                const bottomGap = Math.max(
                    12,
                    Math.round(rootRect.bottom - pagRect.bottom)
                );
                const pagSpace = pagRect.height + bottomGap;
                const availH = viewRect.height - pagSpace;
                const cardH = Math.max(320, Math.min(640, Math.round(availH)));
                this.state.width = viewRect.width;
                this.state.height = viewRect.height;
                this.state.gap = this.opts.gap;
                this.slideW = Math.min(880, this.state.width * (1 - this.opts.peek * 2));
                this.root.style.setProperty("--mzaPagH", `${pagSpace}px`);
                this.root.style.setProperty("--mzaCardH", `${cardH}px`);
            }

            _onTilt(e) {
                const r = this.viewport.getBoundingClientRect();
                const mx = (e.clientX - r.left) / r.width - 0.5;
                const my = (e.clientY - r.top) / r.height - 0.5;
                this.root.style.setProperty("--mzaTiltX", (my * -6).toFixed(3));
                this.root.style.setProperty("--mzaTiltY", (mx * 6).toFixed(3));
            }

            _onDragStart(e) {
                if (e.pointerType === "mouse" && e.button !== 0) return;
                e.preventDefault();
                this.state.dragging = true;
                this.state.pointerId = e.pointerId;
                this.viewport.setPointerCapture(e.pointerId);
                this.state.x0 = e.clientX;
                this.state.t0 = performance.now();
                this.state.v = 0;
                this.state.pausedAt = performance.now();
            }

            _onDragMove(e) {
                if (!this.state.dragging || e.pointerId !== this.state.pointerId) return;
                const dx = e.clientX - this.state.x0;
                const dt = Math.max(16, performance.now() - this.state.t0);
                this.state.v = dx / dt;
                const slideSpan = this.slideW + this.state.gap;
                this.state.pos = this._mod(this.state.index - dx / slideSpan, this.n);
                this._render();
            }

            _onDragEnd(e) {
                if (!this.state.dragging || (e && e.pointerId !== this.state.pointerId))
                    return;
                this.state.dragging = false;
                try {
                    if (this.state.pointerId != null)
                        this.viewport.releasePointerCapture(this.state.pointerId);
                } catch {}
                this.state.pointerId = null;
                if (this.state.pausedAt) {
                    this.state.startTime += performance.now() - this.state.pausedAt;
                    this.state.pausedAt = 0;
                }
                const v = this.state.v;
                const threshold = 0.18;
                let target = Math.round(
                    this.state.pos - Math.sign(v) * (Math.abs(v) > threshold ? 0.5 : 0)
                );
                this.goTo(this._mod(target, this.n));
            }

            _startCycle() {
                this.state.startTime = performance.now();
                this._renderProgress(0);
            }

            _loop() {
                const step = (t) => {
                    if (
                        !this.state.dragging &&
                        !this.state.hovering &&
                        !this.state.animating
                    ) {
                        const elapsed = t - this.state.startTime;
                        const p = Math.min(1, elapsed / this.opts.interval);
                        this._renderProgress(p);
                        if (elapsed >= this.opts.interval) this.next();
                    }
                    this.state.rafId = requestAnimationFrame(step);
                };
                this.state.rafId = requestAnimationFrame(step);
            }

            _renderProgress(p) {
                this.progressBar.style.transform = `scaleX(${p})`;
            }

            prev() {
                this.goTo(this._mod(this.state.index - 1, this.n));
            }

            next() {
                this.goTo(this._mod(this.state.index + 1, this.n));
            }

            goTo(i, animate = true) {
                const start = this.state.pos || this.state.index;
                const end = this._nearest(start, i);
                const dur = animate ? this.opts.transitionMs : 0;
                const t0 = performance.now();
                const ease = (x) => 1 - Math.pow(1 - x, 4);
                this.state.animating = true;
                const step = (now) => {
                    const t = Math.min(1, (now - t0) / dur);
                    const p = dur ? ease(t) : 1;
                    this.state.pos = start + (end - start) * p;
                    this._render();
                    if (t < 1) requestAnimationFrame(step);
                    else this._afterSnap(i);
                };
                requestAnimationFrame(step);
            }

            _afterSnap(i) {
                this.state.index = this._mod(Math.round(this.state.pos), this.n);
                this.state.pos = this.state.index;
                this.state.animating = false;
                this._render(true);
                this._startCycle();
            }

            _nearest(from, target) {
                let d = target - Math.round(from);
                if (d > this.n / 2) d -= this.n;
                if (d < -this.n / 2) d += this.n;
                return Math.round(from) + d;
            }

            _mod(i, n) {
                return ((i % n) + n) % n;
            }

            _render(markActive = false) {
                const span = this.slideW + this.state.gap;
                const tiltX = parseFloat(
                    this.root.style.getPropertyValue("--mzaTiltX") || 0
                );
                const tiltY = parseFloat(
                    this.root.style.getPropertyValue("--mzaTiltY") || 0
                );
                for (let i = 0; i < this.n; i++) {
                    let d = i - this.state.pos;
                    if (d > this.n / 2) d -= this.n;
                    if (d < -this.n / 2) d += this.n;
                    const weight = Math.max(0, 1 - Math.abs(d) * 2);
                    const biasActive = -this.slideW * this.opts.activeLeftBias * weight;
                    const tx = d * span + biasActive;
                    const depth = -Math.abs(d) * this.opts.zDepth;
                    const rot = -d * this.opts.rotateY;
                    const scale = 1 - Math.min(Math.abs(d) * this.opts.scaleDrop, 0.42);
                    const blur = Math.min(Math.abs(d) * this.opts.blurMax, this.opts.blurMax);
                    const z = Math.round(1000 - Math.abs(d) * 10);
                    const s = this.slides[i];
                    if (this.isFF) {
                        s.style.transform = `translate(${tx}px,-50%) scale(${scale})`;
                        s.style.filter = "none";
                    } else {
                        s.style.transform = `translate3d(${tx}px,-50%,${depth}px) rotateY(${rot}deg) scale(${scale})`;
                        s.style.filter = `blur(${blur}px)`;
                    }
                    s.style.zIndex = z;
                    if (markActive)
                        s.dataset.state =
                            Math.round(this.state.index) === i ? "active" : "rest";
                    const card = s.querySelector(".mzaCard");
                    const parBase = Math.max(-1, Math.min(1, -d));
                    const parX = parBase * 48 + tiltY * 2.0;
                    const parY = tiltX * -1.5;
                    const bgX = parBase * -64 + tiltY * -2.4;
                    card.style.setProperty("--mzaParX", `${parX.toFixed(2)}px`);
                    card.style.setProperty("--mzaParY", `${parY.toFixed(2)}px`);
                    card.style.setProperty("--mzaParBgX", `${bgX.toFixed(2)}px`);
                    card.style.setProperty("--mzaParBgY", `${(parY * 0.35).toFixed(2)}px`);
                }
                const active = this._mod(Math.round(this.state.pos), this.n);
                this.dots.forEach((d, i) =>
                    d.setAttribute("aria-selected", i === active ? "true" : "false")
                );
            }
        }

        // Initialize the carousel
        const mza = new MzaCarousel(document.getElementById("mzaCarousel"), {
            transitionMs: 900
        });

    </script>
</body>
</html>
