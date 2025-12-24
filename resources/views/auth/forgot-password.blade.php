<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Catering</title>
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
        .auth-box h2 {
            text-align: center;
            margin-bottom: 10px;
            color: #4A572A;
            font-size: 1.5rem;
        }
        .description {
            text-align: center;
            font-size: 0.85rem;
            color: #555;
            margin-bottom: 20px;
            line-height: 1.5;
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
        .input-field {
            width: 100%;
            padding: 12px 15px;
            border: none;
            border-radius: 10px;
            box-sizing: border-box;
            background: #e6e6d1;
        }
        .submit-button {
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
        .submit-button:hover {
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
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .back-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4A572A;
            font-size: 0.9rem;
            text-decoration: none;
            margin-bottom: 20px;
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

            <h2>Lupa Password?</h2>
            
            <p class="description">
                Tidak masalah! Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
            </p>

            {{-- Menampilkan pesan sukses --}}
            @if (session('status'))
                <div class="success-message">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Menampilkan pesan error --}}
            @if($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="input-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" class="input-field" 
                           placeholder="masukkan email anda" 
                           value="{{ old('email') }}" required autofocus>
                </div>

                <button type="submit" class="submit-button">
                    kirim link reset password
                </button>

                <div class="auth-links">
                    sudah ingat password? <a href="{{ route('login') }}">login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
