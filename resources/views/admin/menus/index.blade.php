@extends('layouts.admin')

@section('header')
    Daftar Menu Katering
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-bold">Semua Menu</h3>
            <a href="{{ route('admin.menus.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Menu
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full border-collapse border border-gray-200">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Gambar</th>
                    <th class="border p-2">Nama</th>
                    <th class="border p-2">Harga</th>
                    <th class="border p-2">Kategori</th>
                    <th class="border p-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menus as $menu)
                <tr>
                    <td class="border p-2 text-center">
                        @if($menu->image)
                            <img src="{{ asset('storage/' . $menu->image) }}" class="w-16 h-16 object-cover mx-auto rounded">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td class="border p-2">{{ $menu->name }}</td>
                    <td class="border p-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="border p-2">{{ $menu->category }}</td>
                    <td class="border p-2 text-center">
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('admin.menus.edit', $menu->id) }}" class="text-yellow-600 hover:text-yellow-800 font-bold">
                                Edit
                            </a>

                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection