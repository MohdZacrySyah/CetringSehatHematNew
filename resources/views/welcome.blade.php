<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catering</title>
    <style>
        /* Pengaturan Dasar */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden;
            color: #333;
        }

        /* Latar belakang gradien animasi dengan partikel */
        .container {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(-45deg, #a8b87c, #7a9447, #6b8e3d, #879b55);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            position: relative;
            overflow: hidden;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Partikel mengambang */
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            animation: float 20s infinite;
            pointer-events: none;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; animation-duration: 18s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 20%; animation-delay: 2s; animation-duration: 22s; }
        .particle:nth-child(3) { width: 100px; height: 100px; left: 60%; animation-delay: 4s; animation-duration: 20s; }
        .particle:nth-child(4) { width: 50px; height: 50px; left: 80%; animation-delay: 6s; animation-duration: 25s; }
        .particle:nth-child(5) { width: 70px; height: 70px; left: 40%; animation-delay: 8s; animation-duration: 19s; }

        @keyframes float {
            0%, 100% { 
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            50% { 
                transform: translateY(-10vh) rotate(180deg);
                opacity: 0.6;
            }
        }

        /* Efek cahaya bergerak */
        .container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: 
                radial-gradient(circle at 30% 50%, rgba(255,255,255,0.15) 0%, transparent 30%),
                radial-gradient(circle at 70% 50%, rgba(255,255,255,0.1) 0%, transparent 30%);
            animation: lightMove 10s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes lightMove {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50% { transform: translate(10%, 10%) rotate(10deg); }
        }

        /* Penampung untuk setiap layar */
        .screen {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.5s ease-out;
            box-sizing: border-box;
            padding: 20px;
            z-index: 1;
        }

        /* Layar 1: Splash */
        #splash-screen {
            cursor: pointer;
        }

        #splash-screen .logo-container {
            position: relative;
            animation: logoAppear 0.8s ease-out;
        }

        /* Efek glow di belakang logo */
        #splash-screen .logo-container::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
            animation: pulse 3s ease-in-out infinite;
            z-index: -1;
        }

        @keyframes pulse {
            0%, 100% { transform: translate(-50%, -50%) scale(1); opacity: 0.5; }
            50% { transform: translate(-50%, -50%) scale(1.2); opacity: 0.8; }
        }

        #splash-screen .logo {
            width: 180px;
            filter: drop-shadow(0 15px 30px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
            position: relative;
            z-index: 1;
        }

        #splash-screen:hover .logo {
            transform: scale(1.08) rotate(2deg);
        }

        @keyframes logoAppear {
            from {
                opacity: 0;
                transform: scale(0.5) rotate(-10deg);
            }
            to {
                opacity: 1;
                transform: scale(1) rotate(0deg);
            }
        }

        #splash-screen .welcome-text {
            font-size: 1.3rem;
            font-weight: 600;
            color: #fff;
            margin-top: 30px;
            opacity: 0;
            transition: opacity 1s ease-in;
            text-shadow: 
                0 2px 10px rgba(0,0,0,0.3),
                0 0 20px rgba(255,255,255,0.3);
            letter-spacing: 0.5px;
            padding: 15px 30px;
            background: linear-gradient(135deg, rgba(74, 87, 42, 0.3), rgba(122, 148, 71, 0.3));
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.2);
        }

        /* Layar 2: Onboarding */
        #onboarding-screen {
            opacity: 0;
            visibility: hidden;
            justify-content: flex-start;
            padding-top: 40px;
            overflow-y: auto;
            padding-bottom: 50px;
        }

        /* Custom Scrollbar dengan gradien */
        #onboarding-screen::-webkit-scrollbar {
            width: 10px;
        }

        #onboarding-screen::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            margin: 10px;
        }

        #onboarding-screen::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #4A572A 0%, #7a9447 100%);
            border-radius: 10px;
            border: 2px solid rgba(255,255,255,0.2);
        }

        #onboarding-screen .logo {
            width: 140px;
            filter: drop-shadow(0 10px 25px rgba(0,0,0,0.2));
            animation: logoFadeIn 0.6s ease-out;
        }

        @keyframes logoFadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        #onboarding-screen h1 {
            font-size: 2.2rem;
            background: linear-gradient(135deg, #2d3a1a 0%, #4A572A 50%, #5d6b35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(255,255,255,0.3);
            letter-spacing: 2px;
            animation: titleSlideIn 0.8s ease-out 0.2s both;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        @keyframes titleSlideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #onboarding-screen .content-box {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(250, 250, 245, 0.95) 100%);
            padding: 35px;
            margin-top: 25px;
            border-radius: 30px;
            width: 85%;
            max-width: 500px;
            text-align: left;
            color: #333;
            box-shadow: 
                0 20px 50px rgba(0,0,0,0.2),
                0 10px 25px rgba(0,0,0,0.1),
                inset 0 1px 0 rgba(255,255,255,0.8);
            animation: boxFadeIn 1s ease-out 0.4s both;
            border: 3px solid rgba(255,255,255,0.6);
            position: relative;
            overflow: visible;
            min-height: auto;
            height: auto;
        }

        /* Efek shine di dalam box */
        #onboarding-screen .content-box::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            transform: rotate(45deg);
            animation: shine 3s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        @keyframes boxFadeIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        #onboarding-screen .content-box h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #4A572A 0%, #6b8e3d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.5rem;
            font-weight: 800;
            border-bottom: 4px solid transparent;
            border-image: linear-gradient(90deg, transparent, #a8b87c, transparent) 1;
            padding-bottom: 18px;
            position: relative;
            z-index: 1;
        }

        #onboarding-screen .content-box p {
            line-height: 1.8;
            margin-bottom: 18px;
            font-size: 0.97rem;
            color: #444;
            position: relative;
            z-index: 1;
            text-align: justify;
        }

        #onboarding-screen .content-box p:last-of-type {
            margin-bottom: 0;
        }

        /* Tombol Mulai dengan gradien animasi */
        .start-button {
            margin-top: 35px;
            padding: 16px 55px;
            background: linear-gradient(135deg, #4A572A 0%, #5d6b35 50%, #6b8e3d 100%);
            background-size: 200% 200%;
            color: white;
            border: none;
            border-radius: 35px;
            font-size: 1.15rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 
                0 10px 25px rgba(74, 87, 42, 0.5),
                0 5px 10px rgba(0,0,0,0.15),
                inset 0 1px 0 rgba(255,255,255,0.3);
            flex-shrink: 0;
            text-decoration: none;
            display: inline-block;
            transition: all 0.4s ease;
            animation: buttonFadeIn 1.2s ease-out 0.6s both;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            overflow: hidden;
            border: 2px solid rgba(255,255,255,0.2);
        }

        /* Efek shimmer pada tombol */
        .start-button::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
            transform: rotate(45deg);
            animation: buttonShimmer 3s ease-in-out infinite;
        }

        @keyframes buttonShimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        @keyframes buttonFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .start-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 
                0 15px 35px rgba(74, 87, 42, 0.6),
                0 8px 15px rgba(0,0,0,0.2),
                inset 0 1px 0 rgba(255,255,255,0.4);
            background-position: 100% 0;
            animation: buttonGlow 1.5s ease-in-out infinite;
        }

        @keyframes buttonGlow {
            0%, 100% { filter: brightness(1); }
            50% { filter: brightness(1.2); }
        }

        .start-button:active {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 
                0 8px 20px rgba(74, 87, 42, 0.5),
                0 4px 8px rgba(0,0,0,0.15);
        }

        /* Responsive Design */
        @media (max-width: 600px) {
            #onboarding-screen h1 {
                font-size: 1.7rem;
            }

            #onboarding-screen .content-box {
                width: 90%;
                padding: 28px 22px;
            }

            #onboarding-screen .content-box h2 {
                font-size: 1.25rem;
            }

            #onboarding-screen .content-box p {
                font-size: 0.92rem;
            }

            .start-button {
                padding: 14px 45px;
                font-size: 1rem;
            }

            #splash-screen .welcome-text {
                font-size: 1.1rem;
                padding: 12px 25px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Partikel mengambang -->
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>

        <div class="screen" id="splash-screen">
            <div class="logo-container">
                <img src="{{ asset('image/LOGO1.png') }}" alt="Logo Catering" class="logo">
            </div>
            <p class="welcome-text" id="welcome-text">
                Selamat datang di Cetering Sehat Hemat
            </p>
        </div>

        <div class="screen" id="onboarding-screen">
            <img src="{{ asset('image/LOGO1.png') }}" alt="Logo Catering" class="logo">
            <h1>CETERING FREAST</h1>
            
            <div class="content-box">
                <h2>HALO PELANGGAN..!!</h2>
                <p>Aplikasi CATERING SEHAT HEMAT adalah aplikasi yang membantu memesan makanan dalam jumlah besar. Dalam aplikasi ini juga memudahkan pelanggan dalam memilih dan request makanan. Pelanggan juga akan bisa berhubungan langsung owner dan tim dapur</p>
                <p>Aplikasi ini juga meringkaskan waktu dalam pembayaran dalam mode digital / online</p>
            </div>

            <a href="{{ url('/menu') }}" class="start-button">MULAI</a>
        </div>

    </div>

    <script>
        // Ambil elemen-elemen yang kita butuhkan
        const splashScreen = document.getElementById('splash-screen');
        const welcomeText = document.getElementById('welcome-text');
        const onboardingScreen = document.getElementById('onboarding-screen');

        // FUNGSI 1: (Gambar 1 -> Gambar 2)
        // Setelah 1.5 detik, tampilkan teks "Selamat datang"
        setTimeout(() => {
            welcomeText.style.opacity = '1';
        }, 1500); // 1.5 detik

        // FUNGSI 2: (Gambar 2 -> Gambar 3)
        // Ketika layar splash (Gambar 1 atau 2) diklik...
        splashScreen.addEventListener('click', () => {
            // 1. Sembunyikan layar splash
            splashScreen.style.opacity = '0';
            // Biarkan 'visibility' tetap pada 'hidden' setelah transisi
            setTimeout(() => {
                splashScreen.style.visibility = 'hidden';
            }, 500); // Waktu yang sama dengan transisi opacity

            // 2. Tampilkan layar onboarding
            onboardingScreen.style.visibility = 'visible';
            onboardingScreen.style.opacity = '1';
        });

    </script>
</body>
</html>