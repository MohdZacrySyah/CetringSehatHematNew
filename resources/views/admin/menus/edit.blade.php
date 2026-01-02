@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Edit Menu: {{ $menu->name }}</h1>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Data</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Nama Menu</label>
                            <input type="text" name="name" value="{{ old('name', $menu->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Kategori</label>
                            <select name="category" class="form-select form-control">
                                <option value="makanan" {{ $menu->category == 'makanan' ? 'selected' : '' }}>Makanan Berat</option>
                                <option value="minuman" {{ $menu->category == 'minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="snack" {{ $menu->category == 'snack' ? 'selected' : '' }}>Cemilan/Snack</option>
                                <option value="paket_hemat" {{ $menu->category == 'paket_hemat' ? 'selected' : '' }}>Paket Hemat</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Harga (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="price" value="{{ old('price', $menu->price) }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label font-weight-bold">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="4">{{ old('description', $menu->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label font-weight-bold">Foto Menu</label>
                            
                            @if($menu->image)
                                <div class="mb-2 p-2 border rounded bg-light d-inline-block">
                                    <p class="text-muted small mb-1">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            @endif

                            <input type="file" name="image" class="form-control mt-2">
                            <div class="form-text text-muted small">
                                <i class="fas fa-info-circle"></i> Biarkan kosong jika tidak ingin mengubah foto. Format: jpg, jpeg, png (Max 2MB).
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.menus') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection