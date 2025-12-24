@extends('layouts.admin')

@section('header')
    Edit Menu: {{ $menu->name }}
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <div class="mb-4">
                <label class="block text-gray-700">Nama Menu</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="category" class="w-full border-gray-300 rounded mt-1">
                    <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan Berat</option>
                    <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="snack" {{ $menu->category == 'snack' ? 'selected' : '' }}>Cemilan/Snack</option>
                    <option value="paket_hemat" {{ $menu->category == 'paket_hemat' ? 'selected' : '' }}>Paket Hemat</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border-gray-300 rounded mt-1" rows="3">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Foto Menu</label>
                
                @if($menu->image)
                    <div class="mb-2">
                        <p class="text-xs text-gray-500 mb-1">Gambar saat ini:</p>
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="Preview" class="w-32 h-32 object-cover rounded border">
                    </div>
                @endif

                <input type="file" name="image" class="w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                <p class="text-xs text-gray-500 mt-1">*Biarkan kosong jika tidak ingin mengubah foto.</p>
            </div>

            <div class="flex justify-end gap-4 mt-6">
                <a href="{{ route('admin.menus') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection