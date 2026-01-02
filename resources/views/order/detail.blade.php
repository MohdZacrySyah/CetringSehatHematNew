@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number)

@push('styles')
<style>
    /* === GLOBAL STYLES === */
    body {
        background-color: #8B9D5E; /* Background Hijau Utama */
        color: #1a1a1a;
        font-family: 'Poppins', sans-serif;
    }

    /* === HEADER === */
    .custom-header {
        display: flex;
        align-items: center;
        padding: 20px 15px;
        color: white;
        margin-bottom: 10px;
    }
    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-right: 15px;
        transition: background 0.3s;
    }
    .back-btn:hover {
        background: rgba(255, 255, 255, 0.4);
    }
    .header-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
    }

    /* === CARD UTAMA === */
    .detail-card {
        background-color: #fcfdf9; /* Putih Gading */
        border-radius: 24px 24px 0 0;
        padding: 25px 20px 40px 20px;
        min-height: 80vh;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        position: relative;
    }

    /* === STATUS BADGE === */
    .status-badge {
        text-align: center;
        margin-bottom: 25px;
    }
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .badge-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-paid { background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
    .badge-process { background: #cfe2ff; color: #084298; border: 1px solid #b6d4fe; }
    .badge-cancel { background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }

    /* === INFO BARIS === */
    .info-group {
        margin-bottom: 20px;
    }
    .info-label {
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .info-value {
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        background: #f0f4e8;
        padding: 12px 15px;
        border-radius: 12px;
        line-height: 1.5;
    }
    
    /* === LIST ITEM === */
    .item-card {
        display: flex;
        gap: 15px;
        background: white;
        border: 1px solid #e0e6d5;
        border-radius: 16px;
        padding: 15px;
        margin-bottom: 12px;
        align-items: center;
    }
    .item-img {
        width: 70px;
        height: 70px;
        border-radius: 12px;
        object-fit: cover;
        background: #eee;
    }
    .item-details {
        flex: 1;
    }
    .item-name {
        font-weight: 700;
        font-size: 0.95rem;
        color: #333;
        margin-bottom: 4px;
    }
    .item-price {
        font-size: 0.85rem;
        color: #666;
    }
    .item-total {
        font-weight: 700;
        color: #556B2F;
    }

    /* === TOTAL SECTION === */
    .total-section {
        margin-top: 30px;
        border-top: 2px dashed #ddd;
        padding-top: 20px;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.9rem;
        color: #666;
    }
    .grand-total {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        font-size: 1.2rem;
        font-weight: 800;
        color: #4A572A;
    }

    /* === BUTTONS === */
    .btn-action {
        display: block;
        width: 100%;
        padding: 14px;
        border-radius: 12px;
        text-align: center;
        font-weight: 700;
        margin-top: 20px;
        text-decoration: none;
        transition: transform 0.2s;
    }
    .btn-green { background: #556B2F; color: white; box-shadow: 0 4px 10px rgba(85,107,47,0.3); }
    .btn-green:hover { background: #435725; transform: translateY(-2px); }
    .btn-outline { border: 2px solid #556B2F; color: #556B2F; background: transparent; }
</style>
@endpush

@section('content')

<div class="custom-header">
    <button class="back-btn" onclick="window.history.back()">
        <i class="fa-solid fa-arrow-left"></i>
    </button>
    <div>
        <h1 class="header-title">Detail Pesanan</h1>
        <div style="font-size: 0.8rem; opacity: 0.9;">#{{ $order->order_number }}</div>
    </div>
</div>

<div class="detail-card">
    
    <div class="status-badge">
        @if($order->status == 'pending')
            <span class="badge badge-pending"><i class="fa-regular fa-clock"></i> Menunggu Pembayaran</span>
        @elseif($order->status == 'paid')
            <span class="badge badge-paid"><i class="fa-solid fa-check"></i> Lunas / Diproses</span>
        @elseif($order->status == 'processing')
            <span class="badge badge-process"><i class="fa-solid fa-fire-burner"></i> Sedang Dimasak</span>
        @elseif($order->status == 'shipped')
            <span class="badge badge-process"><i class="fa-solid fa-truck-fast"></i> Sedang Diantar</span>
        @elseif($order->status == 'completed')
            <span class="badge badge-paid"><i class="fa-solid fa-star"></i> Selesai</span>
        @elseif($order->status == 'cancelled')
            <span class="badge badge-cancel"><i class="fa-solid fa-ban"></i> Dibatalkan</span>
        @endif
    </div>

    <div class="info-group">
        <div class="info-label">Alamat Pengiriman</div>
        <div class="info-value">
            <i class="fa-solid fa-location-dot text-[#556B2F] mr-2"></i>
            {{ $order->delivery_address }}
        </div>
    </div>

    @if($order->customer_notes)
    <div class="info-group">
        <div class="info-label">Catatan Pesanan</div>
        <div class="info-value bg-yellow-50 text-yellow-800 border border-yellow-100">
            <i class="fa-regular fa-note-sticky mr-2"></i>
            "{{ $order->customer_notes }}"
        </div>
    </div>
    @endif

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <div class="info-label">Metode Bayar</div>
            <div class="info-value text-center uppercase">
                {{ $order->payment_method }}
            </div>
        </div>
        <div>
            <div class="info-label">Waktu Pesan</div>
            <div class="info-value text-center">
                {{ $order->created_at->format('d M, H:i') }}
            </div>
        </div>
    </div>

    <hr class="border-dashed border-gray-300 my-6">

    <h3 class="font-bold text-lg mb-4 text-[#4A572A]">Menu Dipesan</h3>
    
    @foreach($order->items as $item)
    <div class="item-card">
        @php
            $imgSrc = 'https://via.placeholder.com/150?text=No+Img';
            // Cek relasi menu dulu (lebih update)
            if ($item->menu && $item->menu->image) {
                $imgSrc = asset('storage/' . $item->menu->image);
            } 
            // Fallback ke data tersimpan di order_items
            elseif ($item->menu_image) {
                $imgSrc = asset('storage/' . $item->menu_image);
            }
        @endphp
        
        <img src="{{ $imgSrc }}" alt="{{ $item->menu_name }}" class="item-img">
        
        <div class="item-details">
            <div class="item-name">{{ $item->menu_name }}</div>
            <div class="item-price">
                {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
            </div>
        </div>
        
        <div class="item-total">
            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
        </div>
    </div>
    @endforeach

    <div class="total-section">
        <div class="total-row">
            <span>Subtotal Produk</span>
            <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Ongkos Kirim</span>
            <span>Rp {{ number_format($order->biaya_pengiriman, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Biaya Layanan</span>
            <span>Rp {{ number_format($order->biaya_aplikasi, 0, ',', '.') }}</span>
        </div>
        
        <div class="grand-total">
            <span>Total Bayar</span>
            <span>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
        </div>
    </div>

    @if($order->status == 'pending')
        <a href="{{ route('order.payment.show', $order->id) }}" class="btn-action btn-green">
            Lanjut Pembayaran
        </a>
    @elseif($order->status == 'completed')
        <a href="{{ route('review.create', $order->id) }}" class="btn-action btn-green">
            <i class="fa-solid fa-star"></i> Beri Ulasan
        </a>
    @endif

    <a href="{{ url('/menu') }}" class="btn-action btn-outline mt-3">
        Pesan Lagi
    </a>

</div>

@endsection