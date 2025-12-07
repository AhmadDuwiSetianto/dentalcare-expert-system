<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - DentalCare</title>
    <link rel="shortcut icon" href="{{ asset('images/favicon_fixed.png') }}" type="image/png">
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

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 50px 40px;
            width: 100%;
            max-width: 500px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.8s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-text {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
        }

        .register-title {
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #FFFFFF 0%, #a8c0ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #b0b0b0;
            font-weight: 500;
            font-size: 14px;
        }

        .form-input {
            width: 100%;
            padding: 15px 20px;
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.08);
            color: white;
            font-size: 16px;
            transition: all 0.3s;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
            background: rgba(255, 255, 255, 0.12);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .password-strength {
            margin-top: 8px;
            font-size: 12px;
            color: #b0b0b0;
        }

        .register-button {
            width: 100%;
            padding: 16px;
            border: none;
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
            margin-top: 10px;
        }

        .register-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .register-button:hover:before {
            left: 100%;
        }

        .register-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .login-link {
            text-align: center;
            margin-top: 30px;
            color: #b0b0b0;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .login-link a:hover {
            color: #a8c0ff;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a {
            color: #b0b0b0;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }

        .back-home a:hover {
            color: white;
        }

        .error-message {
            color: #ff6b6b;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .success-message {
            color: #4ade80;
            font-size: 14px;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        @media (max-width: 480px) {
            .register-card {
                padding: 30px 25px;
            }
            
            .register-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Animation -->
    <div class="background-animation" id="shapes"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="logo">
                <div class="logo-text">DentalCare</div>
            </div>

            <h1 class="register-title">Buat Akun Baru</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="name">
                        <i class="fas fa-user mr-2"></i>Nama Lengkap
                    </label>
                    <input id="name" type="text" class="form-input @error('name') error @enderror" 
                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                           placeholder="Masukkan nama lengkap Anda">

                    @error('name')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope mr-2"></i>Alamat Email
                    </label>
                    <input id="email" type="email" class="form-input @error('email') error @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email"
                           placeholder="nama@email.com">

                    @error('email')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <input id="password" type="password" class="form-input @error('password') error @enderror" 
                           name="password" required autocomplete="new-password"
                           placeholder="Buat password yang kuat">
                    
                    <div class="password-strength">
                        <i class="fas fa-info-circle mr-1"></i>
                        Minimal 8 karakter dengan kombinasi huruf dan angka
                    </div>

                    @error('password')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password-confirm">
                        <i class="fas fa-lock mr-2"></i>Konfirmasi Password
                    </label>
                    <input id="password-confirm" type="password" class="form-input" 
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Ketik ulang password Anda">
                </div>

                <button type="submit" class="register-button">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>

                <div class="back-home">
                    <a href="{{ url('/') }}">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Membuat shape animasi untuk background
        document.addEventListener('DOMContentLoaded', function() {
            const shapesContainer = document.getElementById('shapes');
            const shapesCount = 8;
            
            for (let i = 0; i < shapesCount; i++) {
                const shape = document.createElement('div');
                shape.classList.add('shape');
                
                // Random size
                const size = Math.random() * 120 + 30;
                shape.style.width = `${size}px`;
                shape.style.height = `${size}px`;
                
                // Random position
                shape.style.left = `${Math.random() * 100}vw`;
                shape.style.top = `${Math.random() * 100}vh`;
                
                // Random animation delay
                shape.style.animationDelay = `${Math.random() * 20}s`;
                
                shapesContainer.appendChild(shape);
            }

            // Password strength indicator (optional enhancement)
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.addEventListener('input', function() {
                    const password = this.value;
                    const strengthText = document.querySelector('.password-strength');
                    
                    if (password.length === 0) {
                        strengthText.innerHTML = '<i class="fas fa-info-circle mr-1"></i>Minimal 8 karakter dengan kombinasi huruf dan angka';
                        strengthText.style.color = '#b0b0b0';
                    } else if (password.length < 8) {
                        strengthText.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Password terlalu pendek';
                        strengthText.style.color = '#ff6b6b';
                    } else if (!/(?=.*[a-zA-Z])(?=.*[0-9])/.test(password)) {
                        strengthText.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i>Gunakan kombinasi huruf dan angka';
                        strengthText.style.color = '#ffa726';
                    } else {
                        strengthText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Password kuat';
                        strengthText.style.color = '#4ade80';
                    }
                });
            }
        });
    </script>
</body>
</html>