<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Login - SDN 3 Krenceng</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f0f0 0%, #f8f9fa 50%, #f5f0f0 100%);
            position: relative;
            overflow: hidden;
        }
        /* Background decorations */
        body::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(137,10,10,0.06) 0%, transparent 70%);
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            bottom: -100px;
            left: -100px;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(137,10,10,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-container {
            display: flex;
            width: 920px;
            max-width: 95vw;
            min-height: 540px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(137,10,10,0.1), 0 4px 20px rgba(0,0,0,0.05);
            position: relative;
            z-index: 1;
            background: #fff;
        }

        /* ── Left Panel (Image) ── */
        .login-left {
            flex: 1;
            background: linear-gradient(160deg, #890A0A 0%, #b01515 40%, #6b0808 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 40px;
        }
        .login-left::before {
            content: '';
            position: absolute;
            top: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .login-left::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -60px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.03);
            border-radius: 50%;
        }
        .login-left-img {
            max-width: 85%;
            max-height: 280px;
            object-fit: contain;
            position: relative;
            z-index: 1;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.2));
            animation: floatImg 3s ease-in-out infinite;
        }
        @keyframes floatImg {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .login-left-text {
            text-align: center;
            position: relative;
            z-index: 1;
            margin-top: 28px;
        }
        .login-left-text h3 {
            font-size: 1.4rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .login-left-text p {
            color: rgba(255,255,255,0.65);
            font-size: 0.85rem;
            font-weight: 500;
            max-width: 280px;
            line-height: 1.6;
        }

        /* ── Right Panel (Form) ── */
        .login-right {
            flex: 1;
            padding: 50px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
        }
        .login-logo img {
            height: 48px;
        }
        .login-logo-text {
            font-size: 1.1rem;
            font-weight: 800;
            color: #890A0A;
            line-height: 1.2;
        }
        .login-logo-text small {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            color: #999;
            letter-spacing: 0.5px;
        }
        .login-heading {
            font-size: 1.6rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 6px;
        }
        .login-subheading {
            color: #999;
            font-size: 0.88rem;
            font-weight: 500;
            margin-bottom: 28px;
        }

        /* ── Alert ── */
        .login-alert {
            background: rgba(220,53,69,0.08);
            color: #890A0A;
            border: 1px solid rgba(137,10,10,0.15);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            animation: shakeAlert 0.4s ease;
        }
        .login-alert i {
            font-size: 1.1rem;
        }
        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* ── Form Fields ── */
        .form-group-modern {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group-modern label {
            display: block;
            font-size: 0.82rem;
            font-weight: 700;
            color: #555;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-wrap {
            position: relative;
        }
        .input-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            font-size: 1rem;
            transition: color 0.3s ease;
        }
        .input-wrap input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #eee;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            color: #2c2c2c;
            outline: none;
            transition: all 0.3s ease;
            background: #fafafa;
        }
        .input-wrap input:focus {
            border-color: #890A0A;
            background: #fff;
            box-shadow: 0 4px 16px rgba(137,10,10,0.08);
        }
        .input-wrap input:focus + i,
        .input-wrap input:focus ~ i {
            color: #890A0A;
        }
        .input-wrap input::placeholder {
            color: #bbb;
            font-weight: 400;
        }
        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #aaa;
            font-size: 1rem;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
        }
        .toggle-password:hover {
            color: #890A0A;
        }

        /* ── Submit Button ── */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #890A0A, #b01515);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 20px rgba(137,10,10,0.25);
            margin-top: 6px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(137,10,10,0.35);
            background: linear-gradient(135deg, #a00c0c, #c91818);
        }
        .btn-login:active {
            transform: translateY(0);
        }

        .login-footer {
            margin-top: 28px;
            text-align: center;
            font-size: 0.8rem;
            color: #bbb;
            font-weight: 500;
        }
        .login-footer a {
            color: #890A0A;
            font-weight: 600;
            text-decoration: none;
        }
        .login-footer a:hover {
            text-decoration: underline;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .login-left { display: none; }
            .login-container { max-width: 440px; }
            .login-right { padding: 36px 28px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        {{-- Left Panel --}}
        <div class="login-left">
            <img src="{{ asset('assets/img/loginpage.png') }}" alt="Illustration" class="login-left-img">
            <div class="login-left-text">
                <h3>SDN 3 Krenceng</h3>
                <p>Portal sistem informasi sekolah untuk guru, siswa, dan administrator</p>
            </div>
        </div>

        {{-- Right Panel (Form) --}}
        <div class="login-right">
            <div class="login-logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                <div class="login-logo-text">
                    SDN 3 Krenceng
                    <small>Sistem Informasi Sekolah</small>
                </div>
            </div>

            <h2 class="login-heading">Masuk ke Akun</h2>
            <p class="login-subheading">Silakan masukkan email dan password Anda</p>

            @error('email')
                <div class="login-alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ $message }}
                </div>
            @enderror

            <form action="{{ route('login_store') }}" method="POST">
                @csrf

                <div class="form-group-modern">
                    <label for="email"><i class="bi bi-envelope me-1"></i> Email</label>
                    <div class="input-wrap">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" id="email" name="email" placeholder="contoh@email.com" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group-modern">
                    <label for="password"><i class="bi bi-lock me-1"></i> Password</label>
                    <div class="input-wrap">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required>
                        <button type="button" class="toggle-password" onclick="togglePass()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Masuk
                </button>
            </form>

            <div class="login-footer">
                <a href="/"><i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <script>
        function togglePass() {
            const passInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        }
    </script>
</body>
</html>
