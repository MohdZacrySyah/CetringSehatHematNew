<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        
        <aside class="w-64 bg-white border-r border-gray-200 hidden md:block">
            <div class="h-full flex flex-col">
                <div class="h-16 flex items-center justify-center border-b border-gray-200">
                    <span class="text-xl font-bold text-gray-800">Admin Panel</span>
                </div>

                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        Dashboard
                    </a>

                    <a href="#" class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Kelola Pesanan
                    </a>

                     <a href="{{ route('admin.menus') }}" 
                        class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.menus*') ? 'bg-gray-200 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Daftar Menu
                    </a>

                </nav>

                <div class="p-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="font-semibold text-xl text-gray-800">
                    {{ $header ?? 'Dashboard' }}
                </div>
                <div class="flex items-center">
                    <span class="text-sm text-gray-600 mr-2">Halo, {{ Auth::user()->name }}</span>
                    <div class="h-8 w-8 rounded-full bg-gray-300 overflow-hidden border border-gray-200">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-full w-full object-cover">
                        @else
                            <svg class="h-full w-full text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                        @endif
                    </div>
                </div>
            </header>

            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>