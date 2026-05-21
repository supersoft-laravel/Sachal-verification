<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sachal Consulting Services')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary:       #1a5cb8;
            --primary-dark:  #134a96;
            --primary-light: #e8f0fb;
            --accent:        #f47920;
            --accent-light:  #fff4ec;
            --bg:            #f5f7fa;
            --white:         #ffffff;
            --border:        #dde6f5;
            --text:          #1a2340;
            --muted:         #6b7a99;
            --success-bg:    #eafaf1;
            --success-text:  #1a7a45;
            --danger-bg:     #fdf0f0;
            --danger-text:   #c0392b;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        /* ── NAVBAR ── */
        .admin-navbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 1.8rem;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 6px rgba(26,92,184,0.07);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .admin-navbar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-navbar .brand img {
            height: 40px;
            object-fit: contain;
        }

        .admin-navbar .brand-text {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary);
            border-left: 2px solid var(--border);
            padding-left: 12px;
        }

        .admin-navbar .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .admin-navbar .nav-link-item {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .admin-navbar .nav-link-item:hover { color: var(--primary); }

        .btn-logout {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid #f5c6c6;
            padding: 0.38rem 1rem;
            border-radius: 7px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-logout:hover {
            background: var(--danger-text);
            color: white;
            border-color: var(--danger-text);
        }

        /* ── CONTENT WRAPPER ── */
        .main-content {
            padding: 1.8rem 2rem;
            max-width: 1280px;
            margin: 0 auto;
            width: 100%;
        }

        /* ── CARDS ── */
        .card-box {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 2px 12px rgba(26,92,184,0.06);
            overflow: hidden;
        }

        .card-box-header {
            padding: 1rem 1.4rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--white);
        }

        .card-box-header h5 {
            font-size: 0.97rem;
            font-weight: 700;
            color: var(--text);
            margin: 0;
        }

        .card-box-body { padding: 1.4rem; }

        /* ── STAT CARDS ── */
        .stat-card {
            background: var(--white);
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 1.2rem 1.4rem;
            box-shadow: 0 2px 10px rgba(26,92,184,0.05);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-icon {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }

        .stat-icon.blue  { background: var(--primary-light); color: var(--primary); }
        .stat-icon.green { background: var(--success-bg);    color: var(--success-text); }
        .stat-icon.red   { background: var(--danger-bg);     color: var(--danger-text); }

        .stat-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--text);
            line-height: 1.1;
        }

        /* ── TABLE ── */
        .tbl thead th {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.8rem 1rem;
            border: none;
            white-space: nowrap;
        }

        .tbl tbody td {
            padding: 0.78rem 1rem;
            font-size: 0.91rem;
            vertical-align: middle;
            border-color: var(--border);
        }

        .tbl tbody tr:hover { background: #fafbff; }

        /* ── BADGES ── */
        .badge-valid {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--success-bg);
            color: var(--success-text);
            padding: 0.28rem 0.7rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        .badge-invalid {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--danger-bg);
            color: var(--danger-text);
            padding: 0.28rem 0.7rem;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 700;
        }

        /* ── CERT ID CHIP ── */
        .cert-chip {
            font-family: 'Courier New', monospace;
            font-size: 0.82rem;
            font-weight: 700;
            background: var(--primary-light);
            color: var(--primary);
            padding: 0.22rem 0.6rem;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        /* ── COPY BUTTON ── */
        .btn-copy {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--muted);
            padding: 0.18rem 0.35rem;
            border-radius: 5px;
            font-size: 0.8rem;
            transition: all 0.2s;
            position: relative;
        }

        .btn-copy:hover { color: var(--primary); background: var(--primary-light); }

        .copy-tooltip {
            position: absolute;
            top: -28px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--primary);
            color: white;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.2rem 0.5rem;
            border-radius: 5px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .copy-tooltip.show { opacity: 1; }

        /* ── ACTION BUTTONS ── */
        .btn-edit {
            background: var(--primary-light);
            color: var(--primary);
            border: 1px solid #c5d5f0;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-edit:hover { background: var(--primary); color: white; }

        .btn-del {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid #f5c6c6;
            padding: 0.3rem 0.7rem;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-del:hover { background: var(--danger-text); color: white; }

        /* ── PRIMARY BUTTON ── */
        .btn-primary-c {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s, transform 0.15s;
        }

        .btn-primary-c:hover { background: var(--primary-dark); color: white; transform: translateY(-1px); }

        .btn-accent {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.5rem 1.2rem;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
        }

        .btn-accent:hover { background: #d4681a; color: white; }

        /* ── FORM CONTROLS ── */
        .f-label {
            font-size: 0.86rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 0.35rem;
            display: block;
        }

        .f-control {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            font-size: 0.93rem;
            color: var(--text);
            background: var(--white);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .f-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26,92,184,0.1);
        }

        /* ── ALERTS ── */
        .alert-ok {
            background: var(--success-bg);
            border: 1px solid #b2dfcc;
            color: var(--success-text);
            border-radius: 9px;
            padding: 0.8rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-err {
            background: var(--danger-bg);
            border: 1px solid #f5c6c6;
            color: var(--danger-text);
            border-radius: 9px;
            padding: 0.8rem 1.1rem;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--white);
            border-top: 1px solid var(--border);
            padding: 1rem 2rem;
            text-align: center;
            font-size: 0.82rem;
            color: var(--muted);
            margin-top: auto;
        }

/* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .admin-navbar {
                padding: 0.6rem 1rem;
                height: auto;
                min-height: 56px;
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .admin-navbar .brand img { height: 32px; }
            .admin-navbar .nav-actions { gap: 0.6rem; }
            .admin-navbar .nav-link-item { font-size: 0.82rem; }
            .btn-logout { font-size: 0.8rem; padding: 0.32rem 0.75rem; }
            .main-content { padding: 1rem; }
            .brand-text { display: none; }
        }

        @media (max-width: 375px) {
            .admin-navbar {
                padding: 0.55rem 0.85rem;
            }
            .admin-navbar .brand img { height: 28px; }
            #toast-container {
                top: 0.7rem;
                right: 0.7rem;
                max-width: calc(100% - 1.4rem);
            }
        }

        /* ── TOAST ── */
        #toast-container {
            position: fixed;
            top: 1.2rem;
            right: 1.2rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            max-width: 340px;
            width: calc(100% - 2rem);
        }

        .toast-msg {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 0.85rem 1rem;
            border-radius: 10px;
            font-size: 0.88rem;
            font-weight: 500;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            animation: toastIn 0.25s ease;
            position: relative;
            border: 1px solid transparent;
        }

        .toast-msg.ok {
            background: var(--success-bg);
            color: var(--success-text);
            border-color: #b2dfcc;
        }

        .toast-msg.err {
            background: var(--danger-bg);
            color: var(--danger-text);
            border-color: #f5c6c6;
        }

        .toast-msg .t-icon { font-size: 1rem; flex-shrink: 0; margin-top: 1px; }
        .toast-msg .t-text { flex: 1; line-height: 1.45; }

        .toast-msg .t-close {
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.55;
            font-size: 0.9rem;
            padding: 0;
            line-height: 1;
            flex-shrink: 0;
            transition: opacity 0.15s;
        }

        .toast-msg .t-close:hover { opacity: 1; }

        .toast-msg.hiding {
            animation: toastOut 0.25s ease forwards;
        }

        @keyframes toastIn {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes toastOut {
            from { opacity: 1; transform: translateX(0); }
            to   { opacity: 0; transform: translateX(30px); }
        }
    </style>
    @yield('extra-css')
</head>
<body>
    @yield('content')
    <footer class="site-footer">
        &copy; {{ date('Y') }} Sachal Consulting Services &mdash; All Rights Reserved.
    </footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    {{-- TOAST CONTAINER --}}
    <div id="toast-container"></div>

    <script>
        function showToast(message, type) {
            const container = document.getElementById('toast-container');
            const icon = type === 'ok'
                ? '<i class="fas fa-check-circle t-icon"></i>'
                : '<i class="fas fa-exclamation-circle t-icon"></i>';

            const toast = document.createElement('div');
            toast.className = 'toast-msg ' + type;
            toast.innerHTML = icon +
                '<span class="t-text">' + message + '</span>' +
                '<button class="t-close" onclick="dismissToast(this.parentElement)">' +
                    '<i class="fas fa-times"></i>' +
                '</button>';

            container.appendChild(toast);

            // Auto dismiss after 3 seconds
            setTimeout(() => dismissToast(toast), 3000);
        }

        function dismissToast(el) {
            if (!el || el.classList.contains('hiding')) return;
            el.classList.add('hiding');
            setTimeout(() => el && el.remove(), 250);
        }

        // Fire toasts from PHP session flashes
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                showToast(@json(session('success')), 'ok');
            @endif
            @if (session('error'))
                showToast(@json(session('error')), 'err');
            @endif
        });
    </script>

    @yield('extra-js')
</body>
</html>
