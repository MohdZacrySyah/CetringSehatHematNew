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
                                    <option value="makanan_sehat" {{ in_array($menu->category, ['makanan_sehat', 'paket_hemat']) ? 'selected' : '' }}>Makanan Sehat</option>
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
                        <div class="w-full">
                            <label id="drop-area" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 hover:border-[#556B2F] transition-all group relative overflow-hidden">
                                
                                <div id="upload-content" class="flex flex-col items-center justify-center pt-5 pb-6 {{ $menu->image ? 'hidden' : '' }}">
                                    <div class="p-3 bg-gray-100 rounded-full mb-3 group-hover:bg-[#f5f7ee] transition-colors">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-[#556B2F]"></i>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-[#556B2F]">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-400">Ganti foto saat ini (Optional)</p>
                                </div>

                                <div id="preview-container" class="absolute inset-0 w-full h-full bg-white {{ $menu->image ? 'flex' : 'hidden' }} flex-col items-center justify-center">
                                    <img id="image-preview" src="{{ $menu->image ? asset('storage/' . $menu->image) : '#' }}" alt="Preview" class="h-32 object-contain mb-2 rounded-lg shadow-sm">
                                    <p class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded-full flex items-center gap-1">
                                        <i class="fa-solid fa-image"></i> Foto Saat Ini / Terpilih
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1">Klik area ini untuk mengganti</p>
                                </div>

                                <input id="file-input" type="file" name="image" class="hidden" accept="image/*" />
                            </label>
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

<script>
    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('file-input');
    const uploadContent = document.getElementById('upload-content');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');

    // Batas Ukuran File: 5MB (dalam bytes)
    const MAX_SIZE = 5 * 1024 * 1024; 

    // Prevent default behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight effect
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.classList.add('bg-green-50', 'border-[#556B2F]');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, () => {
            dropArea.classList.remove('bg-green-50', 'border-[#556B2F]');
        }, false);
    });

    // Handle Drop
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFiles(files);
        }
    }

    // Handle Click
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        if (files.length > 0) {
            const file = files[0];

            // 1. Validasi Tipe File (Harus Gambar)
            if (!file.type.startsWith('image/')) {
                alert("Mohon upload file gambar (JPG, PNG).");
                resetInput();
                return;
            }

            // 2. Validasi Ukuran File (PENTING AGAR TIDAK ERROR SERVER)
            if (file.size > MAX_SIZE) {
                alert("Ukuran gambar terlalu besar! Maksimal 5MB.");
                resetInput();
                return;
            }

            // Jika lolos, tampilkan preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                uploadContent.classList.add('hidden');
                previewContainer.classList.remove('hidden');
                previewContainer.classList.add('flex');
            }
            reader.readAsDataURL(file);
        }
    }

    function resetInput() {
        fileInput.value = ""; // Reset input file
        // Kembalikan tampilan ke awal (jika belum ada gambar database)
        // Atau biarkan gambar database tetap tampil jika ada
        // (Logika view blade di atas sudah menangani tampilan awal)
    }
</script>
@endsection