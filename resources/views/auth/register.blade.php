<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Catering</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-y: auto;
            color: #333;
            background: #879b55;
        }
        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            flex-direction: column;
            padding: 40px 20px;
            box-sizing: border-box;
            min-height: 100vh;
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
        .auth-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #4A572A;
            font-size: 1.5rem;
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
        .register-button {
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
        .register-button:hover {
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
        .password-note {
            font-size: 0.75rem;
            color: #666;
            margin-top: 3px;
            margin-bottom: 0;
        }
        .error-message {
            font-size: 0.8rem;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 8px 10px;
            border-radius: 5px;
            margin-top: 5px;
            list-style: none;
            padding-left: 10px;
        }
        .error-message li {
            margin: 3px 0;
        }
        .back-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4A572A;
            font-size: 0.9rem;
            text-decoration: none;
            margin-bottom: 15px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .back-link i {
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <img src="{{ asset('image/LOGO1.png') }}" alt="Logo Catering" class="logo">

        <div class="auth-box">
            
            <a href="{{ route('login') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                <span>kembali ke login</span>
            </a>

            <h2>Daftar Akun</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="input-group">
                    <label for="name">Username*</label>
                    <input id="name" type="text" name="name" class="input-field" 
                           placeholder="masukkan nama anda" 
                           value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <ul class="error-message">
                            @foreach ($errors->get('name') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="input-group">
                    <label for="email">Email*</label>
                    <input id="email" type="email" name="email" class="input-field" 
                           placeholder="aaaa@gmail.com" 
                           value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <ul class="error-message">
                            @foreach ($errors->get('email') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="input-group">
                    <label for="password">Password*</label>
                    <div class="input-wrapper">
                        <input id="password" type="password" name="password" 
                               class="input-field with-icon" 
                               placeholder="minimal 8 karakter" required>
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <p class="password-note">Password minimal 8 karakter</p>
                    @if ($errors->has('password'))
                        <ul class="error-message">
                            @foreach ($errors->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="input-group">
                    <label for="password_confirmation">Konfirmasi Password*</label>
                    <div class="input-wrapper">
                        <input id="password_confirmation" type="password" 
                               name="password_confirmation" 
                               class="input-field with-icon" 
                               placeholder="masukkan ulang password anda" required>
                        <i class="fa-solid fa-eye toggle-password" id="togglePasswordConfirm"></i>
                    </div>
                </div>

                <button type="submit" class="register-button">
                    register
                </button>

                <div class="auth-links">
                    sudah punya akun? <a href="{{ route('login') }}">login</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle password confirmation visibility
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmField = document.getElementById('password_confirmation');

        togglePasswordConfirm.addEventListener('click', function() {
            const type = passwordConfirmField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
