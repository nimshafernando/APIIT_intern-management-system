<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#00b2a7">
    <title>APIIT Internship Management System</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/webp" sizes="16x16" href="{{ asset('images/apiitlogo.webp') }}">
    <link rel="icon" type="image/webp" sizes="32x32" href="{{ asset('images/apiitlogo.webp') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apiitlogo.webp') }}">
    <meta name="msapplication-TileImage" content="{{ asset('images/apiitlogo.webp') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* General Styles */
        body {
            background: linear-gradient(135deg, #00b2a7 0%, #e0f7fa 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Background Image with Overlay */
        .login-background {
            background: url('{{ asset('images/portalbg.png') }}') no-repeat center center fixed;
            background-size: cover;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .login-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 2;
        }

        /* Ensure content is above the overlay */
        .site-header, .login-wrapper, .site-footer {
            position: relative;
            z-index: 3;
        }

        /* Header Styles */
        .site-header {
            background: #00b2a7;
            padding: 1.25rem 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 3px solid #009688;
            flex-shrink: 0;
        }
        .site-title {
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-size: 2.25rem;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
            line-height: 1.2;
        }

        /* Login Container Styles (White Solid Card) */
        .login-container {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.25);
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 480px;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.3);
        }

        /* Logo Section */
        .logo-section {
            text-align: center;
            margin-bottom: 1.25rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .logo-section img {
            height: 75px;
            width: auto;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }

        /* Center the Auth Login Button */
        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
            padding: 1rem;
            overflow-y: auto;
        }

        /* Login Buttons */
        .auth-button {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #00b2a7;
            color: #ffffff;
            padding: 15px 40px;
            border-radius: 10px;
            font-size: 17px;
            font-weight: 500;
            text-decoration: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 178, 167, 0.5);
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-bottom: 0.75rem;
        }
        .auth-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.3),
                transparent
            );
            transition: 0.6s;
        }
        .auth-button:hover::before {
            left: 100%;
        }
        .auth-button:hover {
            background: #009688;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 178, 167, 0.7);
        }
        .auth-button svg {
            width: 20px;
            height: 20px;
            margin-right: 8px;
            filter: brightness(0) invert(1);
        }

        .auth-button-secondary {
            background: rgba(255, 255, 255, 0.9);
            color: #00b2a7;
            border: 2px solid #00b2a7;
        }
        .auth-button-secondary svg {
            filter: none;
        }
        .auth-button-secondary:hover {
            background: rgba(255, 255, 255, 1);
            color: #009688;
            border-color: #009688;
        }

        /* Welcome Text */
        .welcome-text {
            text-align: center;
            margin-bottom: 1.25rem;
            color: #1f2937;
        }
        .welcome-text h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: #00b2a7;
        }
        .welcome-text p {
            font-size: 1.125rem;
            font-weight: 400;
            color: #4b5563;
        }

        /* Footer Styles */
        .site-footer {
            background: #00b2a7;
            padding: 1rem 0;
            color: #ffffff;
            font-size: 1.125rem;
            width: 100%;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            flex-shrink: 0;
        }
        .site-footer p {
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .site-header {
                padding: 1rem 0;
            }
            .site-title {
                font-size: 1.5rem;
                letter-spacing: 1px;
                padding: 0 0.5rem;
                text-align: center;
            }
            .login-container {
                padding: 1.5rem 1.5rem;
                margin: 0 0.5rem;
                max-width: 360px;
            }
            .logo-section img {
                height: 60px;
            }
            .auth-button {
                padding: 14px 32px;
                font-size: 16px;
            }
            .auth-button svg {
                width: 18px;
                height: 18px;
            }
            .welcome-text h2 {
                font-size: 1.75rem;
            }
            .welcome-text p {
                font-size: 1rem;
            }
            .site-footer {
                padding: 0.75rem 0;
                font-size: 0.875rem;
            }
            .login-wrapper {
                padding: 1rem 0.5rem;
            }
        }
        @media (max-width: 768px) {
            .login-wrapper {
                padding: 1rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Background with overlay -->
    <div class="login-background"></div>

    <!-- Header -->
    <header class="site-header">
        <h1 class="site-title">APIIT Internship Management System</h1>
    </header>

    <!-- Login Wrapper -->
    <div class="login-wrapper">
        <div class="login-container">
            <!-- APIIT Logo -->
            <div class="logo-section">
                <img src="{{ asset('images/apiitlogo.webp') }}" alt="APIIT Logo" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'font-size: 2.5rem; font-weight: 700; color: #00b2a7;\'>APIIT</div>';">
            </div>

            <div class="welcome-text">
                <h2>Welcome Back</h2>
                <p>Sign in to manage your internship activities</p>
            </div>
            
            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="auth-button">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="auth-button">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="auth-button auth-button-secondary">
                                Register
                            </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <p>&copy; {{ date('Y') }} APIIT Sri Lanka. All rights reserved.</p>
    </footer>
</body>
</html>