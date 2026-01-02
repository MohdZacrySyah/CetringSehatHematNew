@extends('layouts.admin')

@section('title', 'Daftar Menu Katering')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semua Menu</h1>
        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Makanan & Minuman</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th style="width: 10%;">Gambar</th>
                            <th style="width: 30%;">Nama Menu</th>
                            <th style="width: 20%;">Harga</th>
                            <th style="width: 20%;">Kategori</th>
                            <th style="width: 20%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                        <tr>
                            <td class="text-center align-middle">
                                @if($menu->image)
                                    <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <span class="badge bg-secondary p-2">No Image</span>
                                @endif
                            </td>
                            <td class="align-middle font-weight-bold">{{ $menu->name }}</td>
                            <td class="align-middle text-center">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                            <td class="align-middle text-center">
                                <span class="badge bg-info text-dark" style="font-size: 0.9rem;">{{ $menu->category }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-warning btn-sm text-white" title="Edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('Yakin hapus menu ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fas fa-utensils fa-2x mb-3 text-gray-300"></i><br>
                                Belum ada menu yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection