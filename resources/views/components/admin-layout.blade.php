<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Dashboard' }} - Flowtask</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg: #1a1a2e;
            --fg: #f5f0e6;
            --muted: #d4c8b8;
            --accent: #5cb85c;
            --card-bg: rgba(20, 20, 36, 0.95);
            --card-border: rgba(92, 184, 92, 0.4);
            --input-bg: rgba(255, 255, 255, 0.08);
            --input-border: rgba(255, 255, 255, 0.15);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
            --shadow-xl: 0 16px 40px rgba(0, 0, 0, 0.25);
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 16px;
            --border-radius-xl: 24px;
            --text-primary: #f5f0e6;
            --text-secondary: #d4c8b8;
            --text-light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            min-height: 100vh;
            font-family: 'DM Mono', monospace;
            color: var(--fg);
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
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
            );
            pointer-events: none;
            z-index: 0;
        }

        .navbar {
            background: var(--card-bg) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: var(--shadow-lg);
            border-bottom: 1px solid var(--card-border);
            transition: all 0.3s ease;
            z-index: 1000;
            position: relative;
        }

        .navbar-brand {
            font-family: 'Bebas Neue', sans-serif;
            font-weight: 400;
            font-size: 1.75rem;
            color: var(--accent) !important;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
        }

        .nav-link {
            font-weight: 500;
            color: var(--fg) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: var(--border-radius-sm);
            margin: 0 4px;
            position: relative;
            overflow: hidden;
        }

        .nav-link:hover {
            color: var(--accent) !important;
            background: rgba(92, 184, 92, 0.1);
        }

        .dropdown-menu {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            box-shadow: var(--shadow-xl);
            border-radius: var(--border-radius-lg);
            margin-top: 12px;
            animation: slideDown 0.3s ease;
            min-width: 200px;
            z-index: 99999 !important;
        }

        .dropdown-item {
            color: var(--fg);
            transition: all 0.3s ease;
            border-radius: var(--border-radius-sm);
            margin: 4px 8px;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent);
        }

        .add-new-task-dropdown {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent);
            font-weight: 500;
            text-transform: uppercase;
            padding: 12px 16px;
            border-radius: 8px;
            margin: 8px;
            border: 1px solid var(--card-border);
        }

        .add-new-task-dropdown:hover {
            background: var(--accent);
            color: var(--bg);
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 48px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent);
            border-bottom: 1px solid var(--card-border);
            padding: 1.5rem;
            font-weight: 700;
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.05em;
        }

        .card-body {
            padding: 2.5rem;
            background: var(--card-bg);
        }

        .btn {
            padding: 0.875rem 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: var(--border-radius-md);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .btn-primary {
            background: var(--accent);
            color: var(--bg);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            background: rgba(92, 184, 92, 0.8);
            color: var(--bg);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(92, 184, 92, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
        }

        .table {
            background: var(--card-bg);
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            color: var(--fg);
        }

        .table thead {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent);
        }

        .table thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(92, 184, 92, 0.05);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius-md);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-label {
            color: var(--accent);
            font-weight: 500;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            display: flex;
            align-items: center;
        }

        .form-control, .form-select {
            border: 1px solid var(--input-border);
            border-radius: var(--border-radius-md);
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--input-bg);
            color: var(--fg);
            font-weight: 400;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.1);
            background: var(--input-bg);
        }

        .input-group {
            border-radius: var(--border-radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .input-group-text {
            background: rgba(92, 184, 92, 0.1);
            border: 1px solid var(--card-border);
            color: var(--accent);
            font-weight: 500;
            padding: 1rem 1.25rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .btn {
                padding: 0.75rem 1.5rem;
            }
        }
    </style>

    {{ $head ?? '' }}
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    @if(session('success'))
        <div class="toaster-notification toaster-success" id="toaster">
            <div class="toaster-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="toaster-content">
                <h6 class="toaster-title mb-1">Success</h6>
                <p class="toaster-message mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="toaster-close" onclick="closeToaster()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <script>
            setTimeout(function() {
                closeToaster();
            }, 10000);
        </script>
    @endif

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24" style="color: var(--accent); margin-right: 8px;">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Flowtask Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.staff.index') }}">
                            <i class="fas fa-users me-1"></i>Staff
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tasks.index') }}">
                            <i class="fas fa-tasks me-1"></i>Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.reports.index') }}">
                            <i class="fas fa-chart-bar me-1"></i>Reports
                        </a>
                    </li>
                </ul>
                {{-- USER DROPDOWN --}}
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white fw-semibold d-flex align-items-center gap-2"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-shield fa-lg" style="color: var(--accent);"></i> {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                        style="min-width: 200px; border-radius: 0.75rem; z-index: 99999 !important;">

                        {{-- Dashboard --}}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                               href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-gauge-high" style="color: var(--accent);"></i> Dashboard
                            </a>
                        </li>

                        {{-- Staff --}}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                               href="{{ route('admin.staff.index') }}">
                                <i class="fas fa-users" style="color: var(--muted);"></i> Staff
                            </a>
                        </li>

                        {{-- Reports --}}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                               href="{{ route('admin.reports.index') }}">
                                <i class="fas fa-chart-bar" style="color: var(--muted);"></i> Reports
                            </a>
                        </li>

                        <li><hr class="dropdown-divider my-1"></li>

                        {{-- Profile --}}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
                               href="{{ route('admin.profile') }}">
                                <i class="fas fa-user-circle" style="color: var(--accent);"></i> Profile
                            </a>
                        </li>

                        {{-- Logout --}}
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                                    <i class="fas fa-right-from-bracket"></i> Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container-fluid py-4" style="position: relative; z-index: 1;">
        {{ $slot }}
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .toaster-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--card-bg);
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            width: 300px;
            z-index: 99999;
            animation: slideIn 0.3s ease-out;
            border-left: 4px solid var(--accent);
        }

        .toaster-success {
            border-left-color: var(--accent);
        }

        .toaster-icon {
            width: 40px;
            height: 40px;
            background: rgba(92, 184, 92, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 20px;
            flex-shrink: 0;
        }

        .toaster-content {
            flex: 1;
        }

        .toaster-title {
            font-weight: 600;
            font-size: 14px;
            color: var(--fg);
            margin: 0;
        }

        .toaster-message {
            font-size: 13px;
            color: #666;
            margin: 0;
        }

        .toaster-close {
            background: none;
            border: none;
            color: #999;
            font-size: 16px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .toaster-close:hover {
            color: #333;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .toaster-notification.hiding {
            animation: slideOut 0.3s ease-in;
        }
    </style>
    <script>
        function closeToaster() {
            var toaster = document.getElementById('toaster');
            if (toaster) {
                toaster.classList.add('hiding');
                setTimeout(function() {
                    toaster.remove();
                }, 300);
            }
        }
    </script>
    {{ $scripts ?? '' }}
</body>
</html>
