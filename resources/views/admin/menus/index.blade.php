@extends('layouts.admin')

@section('title', 'Daftar Menu Katering')

@section('content')
<div class="container px-6 mx-auto grid py-8">

    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Daftar Menu
            </h2>
            <p class="text-gray-500 text-sm mt-1">Kelola makanan & minuman yang tersedia untuk pelanggan.</p>
        </div>
        
        <a href="{{ route('admin.menus.create') }}" class="px-5 py-2.5 bg-[#556B2F] hover:bg-[#4A572A] text-white font-semibold rounded-xl shadow-lg shadow-[#556B2F]/30 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            <span>Tambah Menu Baru</span>
        </a>
    </div>

    <div class="w-full overflow-hidden bg-white rounded-2xl shadow-lg border border-gray-100 ring-1 ring-black/5">
        
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
            <h3 class="font-bold text-gray-700">Semua Item</h3>
            <span class="text-xs font-semibold text-[#556B2F] bg-[#f5f7ee] px-2.5 py-1 rounded-full">
                {{ $menus->count() }} Menu
            </span>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-bold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50/50">
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($menus as $menu)
                    <tr class="text-gray-700 hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="relative w-16 h-16 mr-4 rounded-xl overflow-hidden shadow-sm border border-gray-200 group-hover:shadow-md transition-shadow">
                                    @if($menu->image)
                                        <img class="object-cover w-full h-full" src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" loading="lazy" />
                                    @else
                                        <div class="flex items-center justify-center w-full h-full bg-gray-100 text-gray-400 text-xs text-center p-1">
                                            No Img
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-bold text-gray-800 text-sm mb-1 group-hover:text-[#556B2F] transition-colors">
                                        {{ $menu->name }}
                                    </p>
                                    <p class="text-xs text-gray-400 line-clamp-1 max-w-[200px]">
                                        {{ $menu->description ?? 'Tidak ada deskripsi' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @php
                                $catColor = match(strtolower($menu->category)) {
                                    'makanan' => 'bg-orange-100 text-orange-700 border-orange-200',
                                    'minuman' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'paket hemat' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    default => 'bg-gray-100 text-gray-700 border-gray-200'
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold leading-tight rounded-full border {{ $catColor }}">
                                {{ ucfirst($menu->category) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm font-bold text-gray-700">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center space-x-3 text-sm">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                   class="flex items-center justify-center w-8 h-8 text-yellow-500 bg-yellow-50 border border-yellow-200 rounded-lg hover:bg-yellow-500 hover:text-white transition-colors shadow-sm"
                                   title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="flex items-center justify-center w-8 h-8 text-red-500 bg-red-50 border border-red-200 rounded-lg hover:bg-red-500 hover:text-white transition-colors shadow-sm"
                                            title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-utensils text-3xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-600">Menu Kosong</h3>
                                <p class="text-sm text-gray-400 mt-1">Belum ada makanan atau minuman yang ditambahkan.</p>
                                <a href="{{ route('admin.menus.create') }}" class="mt-4 text-[#556B2F] font-semibold hover:underline text-sm">
                                    + Tambah Menu Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{-- {{ $menus->links() }} --}}
        </div>
    </div>
</div>
@endsection