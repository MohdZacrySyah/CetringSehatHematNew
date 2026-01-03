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
                {{-- Pastikan enctype ada untuk upload file --}}
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
                                    <option value="makanan_sehat">Makanan Sehat</option>
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

                    {{-- AREA UPLOAD GAMBAR YANG DIPERBAIKI --}}
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Foto Menu</label>
                        <div class="w-full">
                            {{-- PERUBAHAN: Menggunakan DIV bukan LABEL untuk area drop agar event handler lebih stabil --}}
                            <div id="drop-area" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-xl cursor-pointer hover:bg-gray-50 hover:border-[#556B2F] transition-all group relative overflow-hidden bg-white">
                                
                                <div id="upload-content" class="flex flex-col items-center justify-center pt-5 pb-6 pointer-events-none">
                                    <div class="p-3 bg-gray-100 rounded-full mb-3 group-hover:bg-[#f5f7ee] transition-colors">
                                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-400 group-hover:text-[#556B2F]"></i>
                                    </div>
                                    <p class="mb-1 text-sm text-gray-500"><span class="font-semibold text-[#556B2F]">Klik untuk upload</span> </p>
                                    <p class="text-xs text-gray-400">PNG, JPG, JPEG (Max. 2MB)</p>
                                </div>

                                <div id="preview-container" class="absolute inset-0 w-full h-full bg-white hidden flex-col items-center justify-center pointer-events-none">
                                    <img id="image-preview" src="#" alt="Preview" class="h-32 object-contain mb-2 rounded-lg shadow-sm">
                                    <p class="text-xs text-green-600 font-semibold bg-green-50 px-2 py-1 rounded-full flex items-center gap-1">
                                        <i class="fa-solid fa-check-circle"></i> Foto Terpilih
                                    </p>
                                    <p class="text-[10px] text-gray-400 mt-1">Klik area ini untuk mengganti</p>
                                </div>
                            </div>

                            {{-- Input file diletakkan terpisah (hidden) --}}
                            <input id="file-input" type="file" name="image" class="hidden" accept="image/png, image/jpeg, image/jpg" />
                            <p id="error-message" class="text-red-500 text-xs mt-2 hidden"></p>
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

{{-- SCRIPT JAVASCRIPT FIX --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropArea = document.getElementById('drop-area');
        const fileInput = document.getElementById('file-input');
        const uploadContent = document.getElementById('upload-content');
        const previewContainer = document.getElementById('preview-container');
        const imagePreview = document.getElementById('image-preview');
        const errorMessage = document.getElementById('error-message');

        // 1. Klik area drop -> Buka file explorer
        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // 2. Mencegah default behavior untuk semua event drag di seluruh window
        // Ini PENTING agar browser tidak membuka gambar di tab baru
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // 3. Efek Visual saat file di-drag
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

        // 4. Handle DROP Event (Bagian Kritis)
        dropArea.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                // Gunakan DataTransfer untuk memindahkan file drop ke input form secara legal
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);
                
                // Assign file ke input element
                fileInput.files = dataTransfer.files;

                // Tampilkan preview
                handleFiles(files);
            }
        }

        // 5. Handle Klik Manual (Change Event)
        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        // 6. Fungsi Validasi & Preview
        function handleFiles(files) {
            // Reset error
            errorMessage.classList.add('hidden');
            errorMessage.innerText = '';

            if (files.length > 0) {
                const file = files[0];

                // Validasi Tipe
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!validTypes.includes(file.type)) {
                    showError("Format file tidak didukung. Harap upload JPG atau PNG.");
                    fileInput.value = ''; // Reset input
                    return;
                }

                // Validasi Ukuran (Max 2MB = 2 * 1024 * 1024)
                // Error 419 sering terjadi karena file > post_max_size di PHP
                if (file.size > 2 * 1024 * 1024) { 
                    showError("Ukuran gambar terlalu besar! Maksimal 2MB.");
                    fileInput.value = ''; // Reset input
                    return;
                }

                // Tampilkan Preview
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

        function showError(msg) {
            errorMessage.innerText = msg;
            errorMessage.classList.remove('hidden');
            // Reset UI preview
            uploadContent.classList.remove('hidden');
            previewContainer.classList.add('hidden');
            previewContainer.classList.remove('flex');
        }
    });
</script>
@endsection