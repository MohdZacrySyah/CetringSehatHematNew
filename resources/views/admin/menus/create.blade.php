@extends('layouts.admin')

@section('header')
    Tambah Menu Baru
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
        <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700">Nama Menu</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                <select name="category" class="w-full border-gray-300 rounded mt-1">
                    <option value="makanan">Makanan Berat</option>
                    <option value="minuman">Minuman</option>
                    <option value="snack">Cemilan/Snack</option>
                    <option value="paket_hemat">Paket Hemat</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" class="w-full border-gray-300 rounded mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Deskripsi</label>
                <textarea name="description" class="w-full border-gray-300 rounded mt-1" rows="3"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700">Foto Menu</label>
                <input type="file" name="image" class="w-full mt-1">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Simpan Menu
            </button>
        </form>
    </div>
@endsection