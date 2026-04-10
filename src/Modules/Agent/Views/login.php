<!DOCTYPE html>
<html lang="<?= config('app.locale', 'es') ?>">
<head>
    <meta charset="<?= config('app.charset', 'utf-8') ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= __('Acceso Portal Agente') ?> – <?= config('app.company.name') ?></title>
    
    <!-- Design System Loading -->
    <link href="<?= config('ui.typography.url') ?>" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet"/>

    <style>
        :root {
            --primary: <?= config('ui.colors.primary', '#00113a') ?>;
            --secondary: <?= config('ui.colors.secondary', '#002366') ?>;
            --accent: <?= config('ui.colors.tertiary', '#00a371') ?>;
            --ff-head: <?= config('ui.typography.heading', "'Manrope', sans-serif") ?>;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--ff-head);
            color: #fff;
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: <?= config('ui.radius.md', '12px') ?>;
            padding: 3rem 2.5rem;
            width: min(440px, 92vw);
            box-shadow: 0 40px 80px rgba(0,0,0,.4);
            animation: rise .5s cubic-bezier(.22,.68,0,1.2) both;
        }

        @keyframes rise {
            from { opacity:0; transform:translateY(28px) scale(.97); }
            to   { opacity:1; transform:none; }
        }

        .brand { text-align: center; margin-bottom: 2.2rem; }
        .brand-logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 56px; height: 56px;
            background: var(--accent);
            border-radius: 12px;
            margin-bottom: 1rem;
        }
        .brand-logo svg { width:28px; height:28px; fill:var(--primary); }
        .brand h1 { font-size: 1.65rem; font-weight: 800; letter-spacing: -.5px; }
        .brand p  { font-size: .78rem; color: rgba(255,255,255,.5); margin-top: .35rem; font-family: 'JetBrains Mono', monospace; }

        .alert {
            background: rgba(186, 26, 26, 0.2);
            border: 1px solid rgba(186, 26, 26, 0.5);
            color: #ffb4ab;
            border-radius: 8px;
            padding: .7rem 1rem;
            font-size: .82rem;
            margin-bottom: 1.4rem;
        }

        label { 
            display:block; font-size:.72rem; font-weight:600; text-transform:uppercase; 
            letter-spacing:.8px; color:rgba(255,255,255,.55); margin-bottom:.45rem; 
        }

        input {
            width: 100%;
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            border-radius: 10px;
            padding: .75rem 1rem;
            font-size: .95rem;
            font-family: inherit;
            outline: none;
            margin-bottom: 1.2rem;
            transition: all .2s;
        }

        input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(78,222,163,.2);
        }

        .btn {
            width: 100%;
            background: var(--accent);
            color: var(--primary);
            border: none;
            border-radius: 10px;
            padding: .9rem;
            font-size: .95rem;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: all .2s;
            margin-top: .4rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(78,222,163,.35);
            filter: brightness(1.08);
        }

        .footer-note { text-align:center; margin-top:1.6rem; font-size:.72rem; color:rgba(255,255,255,.3); font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body>
<div class="card">
    <div class="brand">
        <div class="brand-logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 1L3 5v6c0 5.5 3.8 10.7 9 12 5.2-1.3 9-6.5 9-12V5L12 1zm0 4.5l5 2.25V11c0 3.5-2.3 6.8-5 7.9-2.7-1.1-5-4.4-5-7.9V7.75L12 5.5z"/>
            </svg>
        </div>
        <h1><?= config('app.company.name') ?></h1>
        <p>Portal Agente · Zero-Trust Access</p>
    </div>

    <?php if ($error): ?>
        <div class="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="<?= config('app.url') ?>/login">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

        <label for="email"><?= __('Email Corporativo') ?></label>
        <input id="email" type="email" name="email" placeholder="agente@<?= strtolower(str_replace(' ', '', config('app.company.name'))) ?>.com" required autofocus>

        <label for="password"><?= __('Contraseña') ?></label>
        <input id="password" type="password" name="password" placeholder="••••••••" required>

        <button type="submit" class="btn"><?= __('Ingresar al Portal') ?></button>
    </form>

    <p class="footer-note">HIPAA Compliant System · v3.0</p>
</div>
</body>
</html>
