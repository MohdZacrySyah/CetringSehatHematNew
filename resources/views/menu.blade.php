<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Catering</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .page-container {
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(-45deg, #a8b87c, #7a9447, #6b8e3d, #879b55);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px 20px;
            box-sizing: border-box;
            position: relative;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Partikel mengambang */
        .particle {
            position: fixed;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
            animation: float 20s infinite;
            pointer-events: none;
            z-index: 0;
        }

        .particle:nth-child(1) { width: 80px; height: 80px; left: 10%; animation-delay: 0s; animation-duration: 18s; }
        .particle:nth-child(2) { width: 60px; height: 60px; left: 25%; animation-delay: 2s; animation-duration: 22s; }
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

        /* Header Title */
        .menu-header {
            text-align: center;
            margin-bottom: 30px;
            animation: headerFadeIn 0.8s ease-out;
        }

        @keyframes headerFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .menu-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #2d3a1a 0%, #4A572A 50%, #5d6b35 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
            letter-spacing: 2px;
        }

        .menu-header p {
            color: #2d3a1a;
            font-size: 1.1rem;
            margin: 0;
            font-weight: 500;
            text-shadow: 0 1px 3px rgba(255,255,255,0.5);
        }

        .menu-container {
            width: 100%;
            max-width: 1300px;
            margin: auto;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(250, 250, 245, 0.25) 100%);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            padding: 40px 30px;
            box-shadow: 
                0 25px 60px rgba(0,0,0,0.25),
                0 10px 30px rgba(0,0,0,0.15),
                inset 0 1px 0 rgba(255,255,255,0.5);
            box-sizing: border-box;
            border: 3px solid rgba(255,255,255,0.3);
            position: relative;
            z-index: 1;
            animation: containerFadeIn 1s ease-out;
        }

        @keyframes containerFadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
        }

        .menu-item-link {
            text-decoration: none;
            color: inherit;
            display: block;
            animation: itemFadeIn 0.6s ease-out backwards;
        }

        .menu-item-link:nth-child(1) { animation-delay: 0.1s; }
        .menu-item-link:nth-child(2) { animation-delay: 0.15s; }
        .menu-item-link:nth-child(3) { animation-delay: 0.2s; }
        .menu-item-link:nth-child(4) { animation-delay: 0.25s; }
        .menu-item-link:nth-child(5) { animation-delay: 0.3s; }
        .menu-item-link:nth-child(6) { animation-delay: 0.35s; }
        .menu-item-link:nth-child(7) { animation-delay: 0.4s; }
        .menu-item-link:nth-child(8) { animation-delay: 0.45s; }
        .menu-item-link:nth-child(9) { animation-delay: 0.5s; }
        .menu-item-link:nth-child(10) { animation-delay: 0.55s; }
        .menu-item-link:nth-child(11) { animation-delay: 0.6s; }
        .menu-item-link:nth-child(12) { animation-delay: 0.65s; }

        @keyframes itemFadeIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .menu-item {
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 248, 245, 0.95) 100%);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 
                0 10px 25px rgba(0,0,0,0.15),
                0 5px 10px rgba(0,0,0,0.1);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            position: relative;
            border: 2px solid rgba(255,255,255,0.5);
        }

        /* Efek shimmer pada card */
        .menu-item::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.4) 50%, transparent 70%);
            transform: rotate(45deg);
            opacity: 0;
            transition: opacity 0.5s;
        }

        .menu-item:hover::before {
            animation: shimmer 1.5s ease-in-out;
        }

        @keyframes shimmer {
            0% { 
                transform: translateX(-100%) translateY(-100%) rotate(45deg);
                opacity: 1;
            }
            100% { 
                transform: translateX(100%) translateY(100%) rotate(45deg);
                opacity: 0;
            }
        }

        .menu-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 
                0 20px 40px rgba(0,0,0,0.25),
                0 10px 20px rgba(0,0,0,0.15),
                0 0 0 4px rgba(74, 87, 42, 0.2);
        }

        .menu-item:active {
            transform: translateY(-5px) scale(1.02);
        }

        .menu-item-image {
            position: relative;
            overflow: hidden;
        }

        .menu-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            display: block;
            transition: transform 0.5s ease;
        }

        .menu-item:hover img {
            transform: scale(1.15);
        }

        /* Overlay gradien pada gambar */
        .menu-item-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
            opacity: 0;
            transition: opacity 0.4s;
        }

        .menu-item:hover .menu-item-image::after {
            opacity: 1;
        }

        .menu-item-name {
            padding: 18px 15px;
            background: linear-gradient(to bottom, rgba(255,255,255,0.9), rgba(250,250,245,0.9));
        }

        .menu-item p {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
            color: #2d3a1a;
            transition: color 0.3s;
            text-transform: capitalize;
        }

        .menu-item:hover p {
            color: #4A572A;
        }

        /* Badge "New" atau "Popular" (opsional) */
        .badge {
            position: absolute;
            top: 12px;
            right: 12px;
            background: linear-gradient(135deg, #4A572A 0%, #5d6b35 100%);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(74, 87, 42, 0.4);
            z-index: 2;
            opacity: 0;
            transform: scale(0.8);
            transition: all 0.3s;
        }

        .menu-item:hover .badge {
            opacity: 1;
            transform: scale(1);
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .menu-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 22px;
            }
        }

        @media (max-width: 992px) {
            .menu-header h1 {
                font-size: 2rem;
            }
            
            .menu-container {
                padding: 35px 25px;
            }
            
            .menu-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 20px;
            }
            
            .menu-item img {
                height: 160px;
            }
        }
        
        @media (max-width: 768px) {
            .page-container {
                padding: 20px 15px;
            }

            .menu-header h1 {
                font-size: 1.7rem;
            }

            .menu-header p {
                font-size: 1rem;
            }
            
            .menu-container {
                padding: 30px 20px;
                border-radius: 25px;
            }
            
            .menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 18px;
            }
            
            .menu-item img {
                height: 140px;
            }

            .menu-item p {
                font-size: 0.9rem;
            }

            .menu-item-name {
                padding: 15px 12px;
            }
        }

        @media (max-width: 480px) {
            .menu-header h1 {
                font-size: 1.5rem;
                letter-spacing: 1px;
            }

            .menu-grid {
                gap: 15px;
            }

            .menu-item img {
                height: 120px;
            }

            .menu-item p {
                font-size: 0.85rem;
            }
        }

    </style>
</head>
<body>

    <!-- Partikel mengambang -->
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>
    <div class="particle"></div>

    <div class="page-container">
        <div class="menu-container">
            
            <div class="menu-header">
                <h1>MENU CATERING</h1>
            </div>

            <div class="menu-grid">

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ayam_sambal.jpeg') }}" alt="Nasi Sambal ayam">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Sambal Ayam</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ikan_sambal.jpeg') }}" alt="Nasi sambal ikan">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Sambal Ikan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ayam_geprek.jpeg') }}" alt="Ayam geprek">
                        </div>
                        <div class="menu-item-name">
                            <p>Ayam Geprek</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ikan_bakar.jpeg') }}" alt="Nasi Ikan Bakar">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Ikan Bakar</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_goreng_umi.jpeg') }}" alt="Nasi Goreng Umi">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Goreng Umi</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ayam_bakar.jpeg') }}" alt="Nasi Ayam Bakar">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Ayam Bakar</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_gulai_ayam.jpeg') }}" alt="Nasi Gulai Ayam">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Gulai Ayam</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_sambal_tempe.jpeg') }}" alt="Nasi Sambal Tempe">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Sambal Tempe</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/sambal_terong.jpeg') }}" alt="Sambal Terong">
                        </div>
                        <div class="menu-item-name">
                            <p>Sambal Terong</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/tumis_buncis.jpeg') }}" alt="Tumis Buncis Terong">
                        </div>
                        <div class="menu-item-name">
                            <p>Tumis Buncis Terong</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/nasi_ayam_geprek.jpeg') }}" alt="Nasi Ayam Geprek">
                        </div>
                        <div class="menu-item-name">
                            <p>Nasi Ayam Geprek</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('login') }}" class="menu-item-link">
                    <div class="menu-item">
                        <div class="menu-item-image">
                            <img src="{{ asset('image/mie_goreng_umi.jpeg') }}" alt="Mie Goreng Umi">
                        </div>
                        <div class="menu-item-name">
                            <p>Mie Goreng Umi</p>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>

</body>
</html>