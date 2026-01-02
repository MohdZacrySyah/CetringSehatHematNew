@extends('layouts.admin')

@section('title', 'Edit Menu Katering')

@section('content')
<div class="container px-6 mx-auto grid py-8">

    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Edit Menu
            </h2>
            <p class="text-gray-500 text-sm mt-1">Perbarui informasi untuk menu: <span class="font-semibold text-[#556B2F]">{{ $menu->name }}</span></p>
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
                    <i class="fa-solid fa-pen-to-square text-[#556B2F]"></i>
                    Formulir Perubahan Data
                </h3>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Nama Menu</label>
                            <input type="text" name="name" value="{{ old('name', $menu->name) }}" required
                                class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm"
                                placeholder="Contoh: Ayam Bakar Madu">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-semibold text-gray-700">Kategori</label>
                            <div class="relative">
                                <select name="category" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm appearance-none cursor-pointer">
                                    <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan Berat</option>
                                    <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                    <option value="snack" {{ $menu->category == 'snack' ? 'selected' : '' }}>Cemilan / Snack</option>
                                    <option value="paket_hemat" {{ $menu->category == 'paket_hemat' ? 'selected' : '' }}>Paket Hemat</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Harga Satuan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <span class="text-gray-500 font-bold">Rp</span>
                            </div>
                            <input type="number" name="price" value="{{ old('price', $menu->price) }}" required
                                class="w-full pl-12 pr-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm"
                                placeholder="0">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Deskripsi Menu</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-xl bg-gray-50 border-transparent focus:border-[#556B2F] focus:bg-white focus:ring-0 transition-all text-sm resize-none"
                            placeholder="Jelaskan detail menu ini...">{{ old('description', $menu->description) }}</textarea>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Foto Menu</label>
                        
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            @if($menu->image)
                                <div class="w-32 h-32 flex-shrink-0 rounded-xl overflow-hidden border border-gray-200 shadow-sm relative group">
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="Preview" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <span class="text-white text-xs font-bold">Saat Ini</span>
                                    </div>
                                </div>
                            @endif

                            <div class="flex-1 w-full">
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 hover:border-[#556B2F] transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-[#556B2F] mb-2 transition-colors"></i>
                                        <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-[#556B2F]">Klik untuk upload</span> gambar baru</p>
                                        <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                    </div>
                                    <input type="file" name="image" class="hidden" />
                                </label>
                                <p class="text-[11px] text-gray-400 mt-2">*Biarkan kosong jika tidak ingin mengubah foto saat ini.</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                        <a href="{{ route('admin.menus') }}" class="px-6 py-3 rounded-xl text-gray-600 bg-gray-100 hover:bg-gray-200 font-semibold transition-all">
                            Batal
                        </a>
                        <button type="submit" class="px-8 py-3 rounded-xl text-white bg-gradient-to-r from-[#556B2F] to-[#4A572A] hover:shadow-lg hover:shadow-[#556B2F]/40 font-bold transition-all transform hover:-translate-y-0.5">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
@endsection