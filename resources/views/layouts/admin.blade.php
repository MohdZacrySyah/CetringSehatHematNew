<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Catering Sehat</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ isSideMenuOpen: false }">

    <div class="flex h-screen bg-gray-50 overflow-hidden">
        
        <aside class="z-20 hidden w-64 overflow-y-auto bg-white border-r border-gray-200 md:block flex-shrink-0">
            <div class="py-6 text-gray-500">
                <a class="ml-6 text-xl font-bold text-[#4A572A] flex items-center gap-2" href="#">
                    <i class="fa-solid fa-leaf text-[#556B2F]"></i>
                    Admin Panel
                </a>

                <ul class="mt-8 space-y-2">
                    <li class="relative px-6 py-1">
                        @if(request()->routeIs('admin.dashboard'))
                            <span class="absolute inset-y-0 left-0 w-1 bg-[#556B2F] rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        @endif
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('admin.dashboard') ? 'text-[#4A572A]' : 'text-gray-500 hover:text-gray-800' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-house w-5 h-5"></i>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>

                    <li class="relative px-6 py-1">
                        @if(request()->routeIs('admin.orders*'))
                            <span class="absolute inset-y-0 left-0 w-1 bg-[#556B2F] rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        @endif
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('admin.orders*') ? 'text-[#4A572A]' : 'text-gray-500 hover:text-gray-800' }}" 
                           href="{{ route('admin.orders') }}">
                            <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                            <span class="ml-4">Kelola Pesanan</span>
                        </a>
                    </li>

                    <li class="relative px-6 py-1">
                        @if(request()->routeIs('admin.menus*'))
                            <span class="absolute inset-y-0 left-0 w-1 bg-[#556B2F] rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        @endif
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('admin.menus*') ? 'text-[#4A572A]' : 'text-gray-500 hover:text-gray-800' }}" 
                           href="{{ route('admin.menus') }}">
                            <i class="fa-solid fa-utensils w-5 h-5"></i>
                            <span class="ml-4">Daftar Menu</span>
                        </a>
                    </li>

                    <li class="relative px-6 py-1">
                        @if(request()->routeIs('admin.reviews*'))
                            <span class="absolute inset-y-0 left-0 w-1 bg-[#556B2F] rounded-tr-lg rounded-br-lg" aria-hidden="true"></span>
                        @endif
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 {{ request()->routeIs('admin.reviews*') ? 'text-[#4A572A]' : 'text-gray-500 hover:text-gray-800' }}" 
                           href="{{ route('admin.reviews.index') }}">
                            <i class="fa-solid fa-star w-5 h-5"></i>
                            <span class="ml-4">Ulasan Pelanggan</span>
                        </a>
                    </li>
                </ul>
                
                <div class="px-6 my-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-[#c74a43] border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                            <span>Logout</span>
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <div id="mobile-backdrop" class="fixed inset-0 z-10 hidden bg-black bg-opacity-50 transition-opacity md:hidden" onclick="closeSidebar()"></div>
        
        <aside id="mobile-sidebar" class="fixed inset-y-0 left-0 z-20 w-64 overflow-y-auto bg-white md:hidden transform -translate-x-full sidebar-transition">
            <div class="py-6 text-gray-500">
                <a class="ml-6 text-xl font-bold text-[#4A572A] flex items-center gap-2" href="#">
                    <i class="fa-solid fa-leaf text-[#556B2F]"></i>
                    Admin Panel
                </a>
                <ul class="mt-8 space-y-2">
                    <li class="relative px-6 py-1">
                        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800" href="{{ route('admin.dashboard') }}">
                            <i class="fa-solid fa-house w-5 h-5"></i>
                            <span class="ml-4">Dashboard</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-1">
                        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800" href="{{ route('admin.orders') }}">
                            <i class="fa-solid fa-cart-shopping w-5 h-5"></i>
                            <span class="ml-4">Kelola Pesanan</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-1">
                        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800" href="{{ route('admin.menus') }}">
                            <i class="fa-solid fa-utensils w-5 h-5"></i>
                            <span class="ml-4">Daftar Menu</span>
                        </a>
                    </li>
                    <li class="relative px-6 py-1">
                        <a class="inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800" href="{{ route('admin.reviews.index') }}">
                            <i class="fa-solid fa-star w-5 h-5"></i>
                            <span class="ml-4">Ulasan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <div class="flex flex-col flex-1 w-full">
            
            <header class="z-10 py-4 bg-white shadow-sm border-b border-gray-100">
                <div class="container flex items-center justify-between h-full px-6 mx-auto text-[#556B2F]">
                    
                    <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" onclick="toggleSidebar()" aria-label="Menu">
                        <i class="fa-solid fa-bars text-2xl"></i>
                    </button>

                    <div class="flex justify-center flex-1 lg:mr-32">
                        <div class="relative w-full max-w-xl mr-6 focus-within:text-[#4A572A]">
                            <div class="absolute inset-y-0 flex items-center pl-2">
                                <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                            </div>
                            <input class="w-full pl-8 pr-2 text-sm text-gray-700 placeholder-gray-600 bg-gray-50 border-0 rounded-md focus:placeholder-gray-500 focus:bg-white focus:border-[#556B2F] focus:outline-none focus:ring-2 focus:ring-[#556B2F]/20 form-input py-2 transition-all" type="text" placeholder="Cari pesanan atau menu..." aria-label="Search" />
                        </div>
                    </div>

                    <ul class="flex items-center flex-shrink-0 space-x-6">
                        <li class="relative">
                            <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none flex items-center gap-2">
                                <span class="text-sm font-semibold text-gray-700 hidden md:block">{{ Auth::user()->name }}</span>
                                <img class="object-cover w-8 h-8 rounded-full border border-gray-200" 
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" 
                                    alt="" aria-hidden="true" />
                            </button>
                        </li>
                    </ul>
                </div>
            </header>

            <main class="h-full overflow-y-auto bg-[#f9fafb]">
                @if(session('success'))
                    <div class="container px-6 mx-auto mt-6">
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm relative" role="alert">
                            <p class="font-bold">Berhasil</p>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="container px-6 mx-auto mt-6">
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm relative" role="alert">
                            <p class="font-bold">Error</p>
                            <p>{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Buka Sidebar
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                // Tutup Sidebar
                closeSidebar();
            }
        }

        function closeSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const backdrop = document.getElementById('mobile-backdrop');
            
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    </script>
</body>
</html>