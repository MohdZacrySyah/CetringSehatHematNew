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
                        Dashboard
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 text-gray-600 rounded-lg hover:bg-gray-100">
                        Kelola Pesanan
                    </a>
                    <a href="{{ route('admin.menus') }}" 
                       class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.menus*') ? 'bg-gray-200 text-gray-900 font-bold' : 'text-gray-600 hover:bg-gray-100' }}">
                        Daftar Menu
                    </a>
                </nav>
                <div class="p-4 border-t border-gray-200">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 sticky top-0 z-10">
                <div class="font-semibold text-xl text-gray-800">{{ $header ?? 'Dashboard' }}</div>
                <div class="text-sm text-gray-600">Halo, {{ Auth::user()->name }}</div>
            </header>
            <div class="p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>