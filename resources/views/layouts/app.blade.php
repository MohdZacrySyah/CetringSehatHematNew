<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catering Sehat Hemat')</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        /* === GLOBAL STYLES === */
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #e0e9cf;
            color: #333;
            min-height: 100vh;
        }
        .main-wrapper {
            min-height: 100vh;
            background: linear-gradient(135deg, #a8b87c 0%, #879b55 100%);
            padding-bottom: 70px;
            position: relative;
            transition: margin-left 0.3s ease;
        }
        
        /* === SIDEBAR (Drawer) === */
        .sidebar {
            position: fixed;
            left: -260px;
            top: 0;
            width: 260px;
            height: 100vh;
            background: #c2d5a0;
            z-index: 2000;
            transition: left 0.3s ease;
            box-shadow: 2px 0 15px rgba(0,0,0,0.2);
            display: flex;
            flex-direction: column;
            padding-top: 20px;
            overflow-y: auto;
        }
        .sidebar.open {
            left: 0;
        }
        .sidebar-header {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin-bottom: 10px;
        }
        .sidebar-header .close-btn {
            font-size: 1.8rem;
            color: #4A572A;
            cursor: pointer;
            margin-right: 15px;
        }
        .sidebar-header .title {
            font-size: 1.4rem;
            font-weight: bold;
            color: #4A572A;
        }
        .sidebar-btn {
            width: 200px;
            margin: 0 auto 18px auto;
            padding: 14px 20px;
            background: #fff;
            color: #3d4621;
            border: none;
            border-radius: 10px;
            font-size: 1.08rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            text-align: center;
            text-decoration: none;
            display: block;
        }
        .sidebar-btn.active, .sidebar-btn:hover {
            background: #879b55;
            color: #fff;
        }
        .sidebar-btn.logout {
            background: #fbe7e7;
            color: #ab3d36;
            margin-top: auto;
            margin-bottom: 20px;
        }
        .sidebar-btn.logout:hover {
            background: #f5d0d0;
        }
        
        /* === OVERLAY === */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1500;
            display: none;
            transition: opacity 0.3s ease;
        }
        .overlay.show {
            display: block;
        }
        
        /* === MODAL KONFIRMASI LOGOUT === */
        .logout-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            z-index: 3000;
            justify-content: center;
            align-items: center;
        }
        .logout-modal.show {
            display: flex;
        }
        .logout-modal-content {
            background: #fff;
            border-radius: 15px;
            padding: 30px 25px;
            max-width: 340px;
            width: 90%;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            animation: modalSlideIn 0.3s ease;
        }
        @keyframes modalSlideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .logout-modal-icon {
            font-size: 3.5rem;
            color: #c74a43;
            margin-bottom: 18px;
        }
        .logout-modal-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 12px;
        }
        .logout-modal-text {
            font-size: 1rem;
            color: #666;
            margin-bottom: 28px;
            line-height: 1.5;
        }
        .logout-modal-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
        }
        .logout-modal-btn {
            padding: 12px 28px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .logout-modal-btn-cancel {
            background: #e8e8e8;
            color: #333;
        }
        .logout-modal-btn-cancel:hover {
            background: #d5d5d5;
        }
        .logout-modal-btn-confirm {
            background: #c74a43;
            color: #fff;
        }
        .logout-modal-btn-confirm:hover {
            background: #a83832;
        }
        
        /* === BOTTOM NAVIGATION === */
        .bottom-nav {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 60px;
            background: #a8b87c;
            display: flex;
            justify-content: space-around;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.1);
        }
        .nav-item {
            color: #fff;
            font-size: 1.6rem;
            padding: 8px 12px;
            border-radius: 10px;
            transition: all 0.25s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-item.active, .nav-item:hover {
            background: #879b55;
            color: #C2D5A0;
            transform: translateY(-3px);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    
    <!-- SIDEBAR -->
    <div id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <span class="close-btn" onclick="closeSidebar()">
                <i class="fa-solid fa-arrow-left"></i>
            </span>
            <div class="title">Pengaturan</div>
        </div>
        
        <a href="{{ route('dashboard') }}" class="sidebar-btn {{ request()->is('dashboard') ? 'active' : '' }}">
            Beranda
        </a>
        <a href="{{ route('profile.index') }}" class="sidebar-btn {{ request()->is('profile') ? 'active' : '' }}">
            Profil
        </a>
        <a href="{{ route('notifikasi') }}" class="sidebar-btn {{ request()->is('notifikasi') ? 'active' : '' }}">
            Notifikasi
        </a>
        <a href="{{ route('tentang') }}" class="sidebar-btn {{ request()->is('tentang-kami') ? 'active' : '' }}">
            Tentang Kami
        </a>
        <a href="{{ route('arsip.index') }}" class="sidebar-btn {{ request()->is('arsip-pesanan*') ? 'active' : '' }}">
            Arsip Pesanan
        </a>
        <a href="{{ route('ratings.index') }}" class="sidebar-btn {{ request()->is('ratings') ? 'active' : '' }}">
            Rating
        </a>
        
        <button type="button" class="sidebar-btn logout" onclick="showLogoutModal()">
            Logout
        </button>
    </div>
    
    <!-- OVERLAY -->
    <div id="overlay" class="overlay" onclick="closeSidebar()"></div>
    
    <!-- MODAL KONFIRMASI LOGOUT -->
    <div id="logoutModal" class="logout-modal">
        <div class="logout-modal-content">
            <div class="logout-modal-icon">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <h3 class="logout-modal-title">Konfirmasi Logout</h3>
            <p class="logout-modal-text">Apakah Anda yakin ingin keluar dari akun?</p>
            <div class="logout-modal-buttons">
                <button type="button" class="logout-modal-btn logout-modal-btn-cancel" onclick="hideLogoutModal()">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="logout-modal-btn logout-modal-btn-confirm">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- MAIN WRAPPER -->
    <div class="main-wrapper" id="mainContent">
        @yield('content')
    </div>
    
    <!-- BOTTOM NAVIGATION -->
    <div class="bottom-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i>
        </a>
        <a href="{{ route('cart') }}" class="nav-item {{ request()->is('keranjang') ? 'active' : '' }}">
            <i class="fa-solid fa-basket-shopping"></i>
        </a>
        <a href="{{ route('notifikasi') }}" class="nav-item {{ request()->is('notifikasi') ? 'active' : '' }}">
            <i class="fa-solid fa-bell"></i>
        </a>
        <a href="{{ route('profile.index') }}" class="nav-item {{ request()->is('profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user"></i>
        </a>
    </div>
    
    <!-- JAVASCRIPT -->
    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('overlay').classList.add('show');
        }
        
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('overlay').classList.remove('show');
        }

        function showLogoutModal() {
            document.getElementById('logoutModal').classList.add('show');
        }

        function hideLogoutModal() {
            document.getElementById('logoutModal').classList.remove('show');
        }

        // Tutup modal jika klik di luar content
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideLogoutModal();
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>
