@extends('layouts.admin')

@section('title', 'Tambah Menu Baru')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah Menu Baru</h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Menu</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Menu</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kategori</label>
                            <select name="category" class="form-select form-control">
                                <option value="makanan">Makanan Berat</option>
                                <option value="minuman">Minuman</option>
                                <option value="snack">Cemilan/Snack</option>
                                <option value="paket_hemat">Paket Hemat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" class="form-control" placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan detail menu..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Foto Menu</label>
                            <input type="file" name="image" class="form-control">
                            <div class="form-text text-muted small">
                                <i class="fas fa-info-circle"></i> Format: jpg, jpeg, png (Max 2MB).
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.menus') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Menu
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection