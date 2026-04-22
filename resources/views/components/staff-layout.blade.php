<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Staff Dashboard' }} - Flowtask</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --bg: #f0ece3;
            --fg: #0d0d14;
            --muted: #9a9aaa;
            --accent: #5cb85c;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(92, 184, 92, 0.3);
            --input-bg: rgba(0, 0, 0, 0.03);
            --input-border: rgba(0, 0, 0, 0.1);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.15);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.2);
            --shadow-xl: 0 12px 32px rgba(0, 0, 0, 0.25);
            --border-radius-sm: 8px;
            --border-radius-md: 12px;
            --border-radius-lg: 16px;
            --border-radius-xl: 20px;
            --text-primary: #0d0d14;
            --text-secondary: #9a9aaa;
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
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background: repeating-linear-gradient(
                0deg,
                rgba(0, 0, 0, 0.03) 0,
                rgba(0, 0, 0, 0.03) 1px,
                transparent 1px,
                transparent 48px
            ),
            repeating-linear-gradient(
                90deg,
                rgba(0, 0, 0, 0.03) 0,
                rgba(0, 0, 0, 0.03) 1px,
                transparent 1px,
                transparent 48px
            );
            pointer-events: none;
            z-index: -1;
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
            box-shadow: var(--shadow-sm);
        }

        .nav-link.active {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent) !important;
            box-shadow: var(--shadow-sm);
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
            z-index: 9999;
            min-width: 200px;
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
            border: 1px solid var(--card-border);
            border-radius: var(--border-radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .card:hover {
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            background: rgba(92, 184, 92, 0.1) !important;
            border: none !important;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .card-title {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.5rem;
            font-family: 'Bebas Neue', sans-serif;
            letter-spacing: 0.05em;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .card-body {
            padding: 2.5rem;
            background: var(--card-bg);
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

        .btn {
            border-radius: var(--border-radius-md);
            font-weight: 700;
            padding: 1rem 2.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn:hover {
            box-shadow: var(--shadow-xl);
        }

        
        .btn-success {
            background: var(--accent);
            border: none;
            color: var(--bg);
        }

        .btn-success:hover {
            background: rgba(92, 184, 92, 0.8);
            color: var(--bg);
        }

        .btn-secondary {
            background: var(--accent);
            border: none;
            color: var(--bg);
        }

        .btn-secondary:hover {
            background: rgba(92, 184, 92, 0.8);
            color: var(--bg);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.75rem;
            font-size: 0.875rem;
            color: var(--accent);
            font-weight: 600;
            animation: slideDown 0.3s ease;
            background: rgba(92, 184, 92, 0.1);
            padding: 0.5rem;
            border-radius: var(--border-radius-sm);
            border-left: 3px solid var(--accent);
        }

        .is-invalid {
            border-color: var(--accent) !important;
            background: rgba(92, 184, 92, 0.05);
            animation: shake 0.5s ease;
        }

        .is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.15) !important;
        }

        .form-text {
            color: var(--text-secondary);
            font-style: italic;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .text-danger {
            color: var(--accent) !important;
            font-weight: 700;
        }

        .text-muted {
            color: var(--text-secondary) !important;
            font-weight: 500;
        }

        /* Status dropdown hover effects */
        .change-status {
            transition: all 0.3s ease;
        }

        .change-status:hover {
            background: rgba(92, 184, 92, 0.1);
            color: var(--accent);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* Premium scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(92, 184, 92, 0.8);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-body {
                padding: 2rem;
            }
            
            .btn {
                padding: 0.875rem 2rem;
                font-size: 0.875rem;
            }

            .navbar-brand {
                font-size: 1.5rem;
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
            <a class="navbar-brand" href="{{ route('staff.dashboard') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24" style="color: var(--accent); margin-right: 8px;">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                </svg>
                Flowtask Staff
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.tasks.index') }}">
                            <i class="fas fa-list me-1"></i>Tasks
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('staff.tasks.create') }}">
                            <i class="fas fa-plus me-1"></i>New Task
                        </a>
                    </li>
                </ul>
                {{-- USER DROPDOWN --}}
<div class="dropdown">
    <a class="nav-link dropdown-toggle text-white fw-semibold d-flex align-items-center gap-2"
       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-circle fa-lg" style="color: var(--accent);"></i> {{ $staff->name }}
    </a>

    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
        style="min-width: 200px; border-radius: 0.75rem; z-index: 99999 !important;">

        {{-- Dashboard --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
               href="{{ route('staff.dashboard') }}">
                <i class="fas fa-gauge-high" style="color: var(--accent);"></i> Dashboard
            </a>
        </li>

        {{-- My Tasks --}}
        <li>
            <a class="dropdown-item d-flex align-items-center gap-2 py-2"
               href="{{ route('staff.tasks.index') }}">
                <i class="fas fa-list-check" style="color: var(--accent);"></i> My Tasks
            </a>
        </li>

        <li><hr class="dropdown-divider my-1"></li>

        {{-- Add New Task — styled as CTA but CONTAINED inside dropdown --}}
        <li class="px-2 pb-1">
            <a href="{{ route('staff.tasks.create') }}"
               class="d-flex align-items-center gap-2 fw-bold text-uppercase rounded-3 px-3 py-2 text-decoration-none"
               style="background: var(--accent); 
                      color: var(--bg); 
                      font-size: 0.78rem; 
                      letter-spacing: 0.04em;">
                <i class="fas fa-plus-circle"></i> Add New Task
            </a>
        </li>

        <li><hr class="dropdown-divider my-1"></li>

        {{-- Logout --}}
        <li>
            <form action="{{ route('staff.logout') }}" method="POST">
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
    <main class="container-fluid py-4">
        {{ $slot }}
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toaster CSS -->
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
        z-index: 999999;
        animation: slideIn 0.3s ease-out;
        border-left: 4px solid var(--accent);
        pointer-events: auto;
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
        font-size: 14px;
        font-weight: 600;
        color: #333;
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
        z-index: 1000000;
        position: relative;
        pointer-events: auto;
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

    <!-- Toaster JavaScript -->
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

    // Add event listener for close button
    document.addEventListener('DOMContentLoaded', function() {
        var closeButton = document.querySelector('.toaster-close');
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                closeToaster();
            });
        }
    });
    </script>

    {{ $scripts ?? '' }}
</body>
</html>
