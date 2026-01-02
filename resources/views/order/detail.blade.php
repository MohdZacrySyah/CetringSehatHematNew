@extends('layouts.app')

@section('title', 'Detail Pesanan')

@push('styles')
<style>
    /* 1. Setting Latar Belakang Halaman (Hijau Tua) */
    body {
        background-color: #8c9e5e !important;
        color: #1a1a1a;
        font-family: 'Poppins', sans-serif;
    }

    /* 2. Header Halaman (Tombol Back & Judul) */
    .custom-header {
        display: flex;
        align-items: center;
        padding: 20px;
        color: #1a1a1a;
    }
    .back-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        margin-right: 15px;
        padding: 0;
        color: #000;
    }
    .header-title {
        font-size: 1.1rem;
        font-weight: bold;
        margin: 0;
    }

    /* 3. Kartu Utama (Hijau Muda Terang) */
    .detail-card {
        background-color: #dbe6b6; /* Hijau muda lembut */
        border-radius: 20px;
        margin: 0 15px 30px 15px; 
        padding: 25px 15px;
        min-height: 70vh;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    /* 4. Judul & Gambar Menu */
    .status-title {
        text-align: center;
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 20px;
        color: #000;
    }
    .menu-img-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
    .menu-img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        background-color: #fff;
    }
    .menu-name-main {
        text-align: center;
        font-weight: bold;
        font-size: 1rem;
        margin-bottom: 25px;
        color: #000;
    }

    /* 5. Baris Data (Kotak-kotak Cream) */
    .data-row {
        background-color: #f2f7e6; /* Warna cream kehijauan */
        border-radius: 12px;
        padding: 12px 20px;
        margin-bottom: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        font-weight: 600;
        color: #000;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    
    .label-text {
        color: #000;
        font-weight: 600;
    }
    .value-text {
        text-align: right;
        color: #000;
        max-width: 60%; /* Agar teks panjang tidak merusak layout */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Tombol Aksi di Bawah */
    .action-buttons {
        margin-top: 30px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .btn-review {
        background-color: #4a6f28; /* Hijau tombol */
        color: white;
        border: none;
        padding: 12px;
        border-radius: 12px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        display: block;
        width: 100%;
        transition: background 0.2s;
    }
    .btn-review:hover {
        background-color: #3a5820;
        color: #fff;
    }
</style>
@endpush

@section('content')

<div class="custom-header">
    <button class="back-btn" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-left"></i>
    </button>
    <h1 class="header-title">Detail Pesanan</h1>
</div>

<div class="detail-card">
    
    <div class="status-title">
        @if($order->status == 'completed')
            Pesanan Selesai
        @elseif($order->status == 'processing')
            Pesanan Sedang Dimasak
        @elseif($order->status == 'paid')
            Sudah Dibayar
        @elseif($order->status == 'cancelled')
            Pesanan Dibatalkan
        @else
            Status: {{ ucfirst($order->status) }}
        @endif
    </div>

    @php
        $firstItem = $order->items->first();
        $imgSrc = 'https://via.placeholder.com/150?text=No+Image'; // Gambar Default

        if ($firstItem) {
            // Cek 1: Ambil dari relasi Menu (Paling Akurat)
            if ($firstItem->menu && $firstItem->menu->image) {
                $imgSrc = asset('storage/' . $firstItem->menu->image);
            } 
            // Cek 2: Backup ambil dari kolom menu_image di order_items
            elseif ($firstItem->menu_image) {
                $imgSrc = asset('storage/' . $firstItem->menu_image);
            }
        }
    @endphp

    <div class="menu-img-container">
        <img src="{{ $imgSrc }}" 
             alt="Menu Image" 
             class="menu-img"
             onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=Err+Img';">
    </div>
    
    <div class="menu-name-main">
        {{ $firstItem->menu_name ?? 'Pesanan Katering' }}
    </div>

    @foreach($order->items as $item)
        {{-- Baris: Jumlah & Nama --}}
        <div class="data-row">
            <span class="label-text">{{ $item->quantity }} Porsi</span>
            <span class="value-text">{{ $item->menu_name }}</span>
        </div>

        {{-- Baris: Total Harga per Item --}}
        <div class="data-row">
            <span class="label-text">Total</span>
            <span class="value-text">Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
        </div>
    @endforeach

    <div class="data-row">
        <span class="label-text">Tanggal Pesan</span>
        <span class="value-text">{{ $order->created_at->format('d.m.Y') }}</span>
    </div>

    <div class="data-row">
        <span class="label-text">Tanggal Pengantaran</span>
        <span class="value-text">
            {{ $order->updated_at->format('d.m.Y') }}
        </span>
    </div>

    <div class="data-row">
        <span class="label-text">Alamat</span>
        <span class="value-text" style="font-size:0.85rem;">{{ Str::limit($order->user->address ?? 'Alamat belum diatur', 25) }}</span>
    </div>

    <div class="data-row">
        <span class="label-text">No.Telpon</span>
        <span class="value-text">{{ $order->user->phone ?? '-' }}</span>
    </div>
    
    <div class="data-row" style="margin-top: 20px; background-color: #fff; border: 1px solid #ddd;">
        <span class="label-text">Total Bayar</span>
        <span class="value-text" style="color: #d32f2f; font-size: 1.1rem; font-weight: bold;">
            Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
        </span>
    </div>

    <div class="action-buttons">
        @if($order->status == 'completed')
            <a href="{{ route('review.create', $order->id) }}" class="btn-review">
                <i class="fa-solid fa-star"></i> Beri Penilaian
            </a>
        @endif
        
        {{-- Tombol Pesan Lagi (Opsional) --}}
        {{-- <a href="{{ route('menu.index') }}" class="btn-review" style="background:#8c9e5e;">
            <i class="fa-solid fa-cart-plus"></i> Pesan Lagi
        </a> --}}
    </div>

</div>

@endsection