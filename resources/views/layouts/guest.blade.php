<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
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

            /* Form Styles */
            .form-label {
                display: block;
                font-size: 0.95rem;
                font-weight: 500;
                color: #374151;
                margin-bottom: 0.5rem;
            }

            .form-input {
                width: 100%;
                padding: 0.75rem;
                border: 1px solid #d1d5db;
                border-radius: 0.5rem;
                font-size: 1rem;
                transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            }

            .form-input:focus {
                outline: none;
                border-color: #00b2a7;
                box-shadow: 0 0 0 3px rgba(0, 178, 167, 0.1);
            }

            .form-button {
                width: 100%;
                background: #00b2a7;
                color: #ffffff;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                font-size: 1rem;
                font-weight: 500;
                border: none;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 4px 12px rgba(0, 178, 167, 0.3);
            }

            .form-button:hover {
                background: #009688;
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 178, 167, 0.4);
            }

            .form-link {
                color: #00b2a7;
                text-decoration: none;
                font-size: 0.875rem;
                transition: color 0.2s ease;
            }

            .form-link:hover {
                color: #009688;
                text-decoration: underline;
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

                {{ $slot }}
            </div>
        </div>

        <!-- Footer -->
        <footer class="site-footer">
            <p>&copy; {{ date('Y') }} APIIT Sri Lanka. All rights reserved.</p>
        </footer>
    </body>
</html>
