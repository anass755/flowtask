<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Login - FlowTask</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #f0ece3;
            --fg: #0d0d14;
            --muted: #9a9aaa;
            --accent: #5cb85c;
            --card-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(92, 184, 92, 0.3);
            --input-bg: rgba(0, 0, 0, 0.03);
            --input-border: rgba(0, 0, 0, 0.1);
        }

        body {
            background: var(--bg);
            color: var(--fg);
            font-family: 'DM Mono', monospace;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
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
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 520px;
            padding: 20px;
        }

        .login-card {
            background: var(--card-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #5cb85c 0%, #f0ece3 100%);
            border: 2px solid var(--accent);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: var(--accent);
            box-shadow: 0 10px 30px rgba(92, 184, 92, 0.2);
        }

        .login-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 42px;
            font-weight: 400;
            color: var(--fg);
            margin-bottom: 8px;
            letter-spacing: 0.05em;
            line-height: 1.1;
        }

        .login-subtitle {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.15em;
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 12px;
            color: var(--fg);
            font-family: 'DM Mono', monospace;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: var(--muted);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(92, 184, 92, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 16px 24px;
            background: var(--accent);
            border: none;
            border-radius: 12px;
            color: var(--bg);
            font-family: 'DM Mono', monospace;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(92, 184, 92, 0.3);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(92, 184, 92, 0.4);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .error-message {
            background: rgba(92, 184, 92, 0.1);
            border: 1px solid rgba(92, 184, 92, 0.3);
            color: var(--accent);
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .back-link {
            text-align: center;
            margin-top: 24px;
        }

        .back-link a {
            color: var(--muted);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: var(--accent);
        }

        .role-badge {
            display: inline-block;
            padding: 4px 12px;
            background: rgba(92, 184, 92, 0.1);
            border: 1px solid var(--accent);
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--accent);
            margin-bottom: 16px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }

            .login-title {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="40" height="40">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
                <span class="role-badge">Staff Portal</span>
                <h1 class="login-title">STAFF LOGIN</h1>
                <p class="login-subtitle">FlowTask Staff Portal</p>
            </div>

            <form action="{{ route('staff.login') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Enter your email"
                        required
                        autocomplete="email"
                        value="{{ old('email') }}"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <button type="submit" class="btn-submit">
                    Sign In
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('admin.login') }}">Admin Login →</a>
            </div>
        </div>
    </div>
</body>
</html>
