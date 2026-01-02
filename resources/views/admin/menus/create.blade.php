@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="container px-6 mx-auto grid py-8">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Tambah Menu
            </h2>
            <p class="text-gray-500 text-sm mt-1">Tambahkan makanan atau minuman baru ke daftar menu.</p>
        </div>
        
        <a href="{{ route('admin.menus') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 font-medium rounded-xl hover:bg-gray-50 hover:text-[#556B2F] transition-all flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <div class="max-w-4xl mx-auto w-full">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="px-8 py-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-700 text-lg flex items-center gap-2">
                    <i class="fa-solid fa-circle-plus text-[#556B2F]"></i>
                    Formulir Menu Baru
                </h3>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm"
                                placeholder="Contoh: Nasi Goreng Spesial">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="category" required class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="makanan">Makanan Berat</option>
                                    <option value="minuman">Minuman</option>
                                    <option value="snack">Cemilan / Snack</option>
                                    <option value="paket_hemat">Paket Hemat</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Harga Satuan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span class="text-gray-500 font-bold">Rp</span>
                            </div>
                            <input type="number" name="price" required
                                class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm"
                                placeholder="0">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Deskripsi Menu</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm resize-none"
                            placeholder="Jelaskan bahan utama, rasa, atau detail lainnya..."></textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Foto Menu</label>
                        <div class="w-full">
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 hover:border-[#556B2F] transition-all group">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <div class="p-3 bg-gray-100 rounded-full mb-3 group-hover:bg-[#f5f7ee] transition-colors">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-[#556B2F]"></i>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-[#556B2F]">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                </div>
                                <input type="file" name="image" class="hidden" accept="image/*" />
                            </label>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.menus') }}" class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-semibold transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl text-white bg-gradient-to-r from-[#556B2F] to-[#4A572A] hover:shadow-lg hover:shadow-[#556B2F]/40 font-bold transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            <i class="fa-solid fa-save"></i>
                            <span>Simpan Menu</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
@endsection