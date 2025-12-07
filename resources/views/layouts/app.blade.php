<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DentalCare Expert')</title>
    <link rel="shortcut icon" href="{{ asset('images/logo-baru.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 50%, #16213e 100%);
            color: white;
            line-height: 1.6;
            overflow-x: hidden;
            min-height: 100vh;
        }

        .background-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            opacity: 0.1;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            animation: float 20s infinite linear;
        }

        .shape:nth-child(2n) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            animation-duration: 25s;
            animation-direction: reverse;
        }

        .shape:nth-child(3n) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            animation-duration: 30s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) translateX(0) rotate(0deg) scale(1);
            }

            33% {
                transform: translateY(-30vh) translateX(20vw) rotate(120deg) scale(1.2);
            }

            66% {
                transform: translateY(20vh) translateX(-20vw) rotate(240deg) scale(0.8);
            }

            100% {
                transform: translateY(0) translateX(0) rotate(360deg) scale(1);
            }
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .card-glass {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s;
        }

        .card-glass:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .btn-outline {
            background: transparent;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            flex-shrink: 0;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
        }

        /* ===== IMPROVED RESPONSIVE HEADER ===== */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .logo {
            flex-shrink: 0;
        }

        .auth-buttons {
            flex-shrink: 0;
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 16px;
            }

            header nav {
                flex-direction: row;
                gap: 12px;
                padding: 12px 0;
                align-items: center;
            }

            .logo {
                font-size: 1.4rem;
                text-align: left;
                width: auto;
            }

            .auth-buttons {
                width: auto;
                justify-content: flex-end;
                gap: 8px;
                flex-wrap: nowrap;
            }

            .btn-gradient,
            .btn-outline {
                padding: 10px 20px;
                font-size: 0.9rem;
                min-width: auto;
            }
        }

        @media (max-width: 640px) {
            .logo {
                font-size: 1.3rem;
            }

            .auth-buttons {
                gap: 6px;
            }

            .btn-gradient,
            .btn-outline {
                padding: 8px 16px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }

            header nav {
                gap: 8px;
                padding: 10px 0;
            }

            .logo {
                font-size: 1.2rem;
            }

            .logo i {
                margin-right: 4px;
            }

            .auth-buttons {
                gap: 6px;
            }

            .btn-gradient,
            .btn-outline {
                padding: 8px 14px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 360px) {
            .container {
                padding: 0 10px;
            }

            .logo {
                font-size: 1.1rem;
            }

            .auth-buttons {
                gap: 4px;
            }

            .btn-gradient,
            .btn-outline {
                padding: 7px 12px;
                font-size: 0.75rem;
            }
        }

        .hero-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: bold;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
        }

        /* Responsive adjustments for hero */
        @media (max-width: 768px) {
            .hero-section {
                min-height: 70vh;
                text-align: center;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
                margin-top: 2rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .stat-number {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                min-height: 60vh;
            }

            .stat-number {
                font-size: 2rem;
            }

            .stat-label {
                font-size: 1rem;
            }
        }

        /* Smooth transitions */
        .btn-gradient,
        .btn-outline,
        .auth-buttons a,
        .logo {
            transition: all 0.2s ease-in-out;
        }

        /* Ensure no wrapping occurs di header */
        .auth-buttons>* {
            flex-shrink: 0;
        }
    </style>
</head>

<body>
    <!-- Background Animation -->
    <div class="background-animation" id="shapes"></div>

    <!-- Header -->
    <header class="sticky top-0 z-50 bg-transparent backdrop-blur-lg border-b border-white/10">
        <div class="container">
            <nav class="flex justify-between items-center py-4">
                <div class="logo text-2xl font-bold gradient-text">
                    <i class="fas fa-tooth mr-2"></i>DentalCare
                </div>
                <div class="auth-buttons flex gap-4">
                    @auth
                    <div class="flex items-center gap-4">
                        <!-- <span class="text-white">Halo, {{ Auth::user()->name }}</span>
                        <a href="{{ route('diagnosis.index') }}" class="btn-gradient">
                            <i class="fas fa-stethoscope mr-2"></i>Diagnosa
                        </a> -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-outline">
                                <i class=""></i>Logout
                            </button>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('register') }}" class="btn-outline">Register</a>
                    <a href="{{ route('login') }}" class="btn-gradient">Sign Up</a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <script>
        // Background shapes animation
        document.addEventListener('DOMContentLoaded', function() {
            const shapesContainer = document.getElementById('shapes');
            const shapesCount = 8;

            for (let i = 0; i < shapesCount; i++) {
                const shape = document.createElement('div');
                shape.classList.add('shape');

                const size = Math.random() * 100 + 50;
                shape.style.width = `${size}px`;
                shape.style.height = `${size}px`;
                shape.style.left = `${Math.random() * 100}vw`;
                shape.style.top = `${Math.random() * 100}vh`;
                shape.style.animationDelay = `${Math.random() * 20}s`;

                shapesContainer.appendChild(shape);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>