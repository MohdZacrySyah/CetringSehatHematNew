<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Catering</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            color: #333;
            background: #879b55; 
        }
        .container {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 20px;
            box-sizing: border-box;
        }
        .logo {
            width: 180px;
            margin-bottom: 20px;
        }
        .auth-box {
            background: rgba(230, 230, 210, 0.7);
            padding: 30px 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            text-align: left;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 0.9rem;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-field {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            background: #e6e6d1;
        }
        .input-field.with-icon {
            padding-right: 45px;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: #4A572A;
            font-size: 1.2rem;
            user-select: none;
        }
        .toggle-password:hover {
            color: #2d3518;
        }
        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #4A572A;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }
        .login-button:hover {
            background-color: #3a4521;
        }
        .auth-links {
            text-align: center;
            margin-top: 15px;
            font-size: 0.9rem;
        }
        .auth-links a {
            color: #4A572A;
            font-weight: bold;
            text-decoration: none;
        }
        .auth-links a:hover {
            text-decoration: underline;
        }
        .forgot-password {
            text-align: right;
            font-size: 0.8rem;
            margin-top: -5px;
            margin-bottom: 15px;
        }
        .forgot-password a {
            color: #4A572A;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <img src="{{ asset('image/LOGO1.png') }}" alt="Logo Catering" class="logo">

        <div class="auth-box">

            {{-- Menampilkan pesan sukses setelah registrasi --}}
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="error-message">
                    Email atau password salah, silahkan masukkan email dan password yg benar
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="input-field" 
                           placeholder="masukkan email anda" 
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="input-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" name="password" 
                               class="input-field with-icon" 
                               placeholder="masukkan password anda" required>
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                </div>

                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="login-button">
                    login
                </button>

                <div class="auth-links">
                    belum punya akun? <a href="{{ route('register') }}">register</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle tipe input
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle icon mata
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
