@extends('layouts.app')

@section('title', $menu->name)

@push('styles')
<style>
    /* UTAMA: Wrapper ini menutupi SELURUH layar termasuk navbar bawah layout */
    .detail-wrapper {
        background-color: #ffffff;
        position: fixed; /* Mengunci posisi agar menutupi layout utama */
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 2000; /* Layer sangat tinggi agar di atas Navbar Hijau */
        overflow-y: auto; /* Agar konten tetap bisa di-scroll */
        padding-bottom: 100px; /* Memberi ruang agar konten terakhir tidak ketutupan tombol */
    }

    /* 1. Header Hijau Besar */
    .hero-header {
        background-color: #8c9e5e; 
        height: 200px;
        position: relative;
        padding: 20px;
        border-bottom-left-radius: 25px;
        border-bottom-right-radius: 25px;
    }
    
    .back-btn {
        color: white;
        font-size: 1.5rem;
        background: rgba(255,255,255,0.2);
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 2002; /* Agar tombol back selalu bisa diklik */
    }

    /* 2. Gambar Menu */
    .menu-image-container {
        margin-top: -120px; 
        text-align: center;
        padding: 0 20px;
        position: relative;
        z-index: 2;
    }
    .menu-img-detail {
        width: 220px; 
        height: 220px;
        object-fit: cover;
        border-radius: 50%; 
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        background-color: #fff;
        border: 5px solid #fff;
    }

    /* 3. Info Produk */
    .product-info {
        padding: 20px;
        text-align: left;
    }
    .menu-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #222;
        margin-bottom: 5px;
    }
    .menu-price {
        font-size: 1.3rem;
        font-weight: 600;
        color: #222;
        margin-bottom: 10px;
    }
    .rating-mini {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #555;
    }
    .store-badge {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 15px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 12px;
        border: 1px solid #eee;
    }

    /* 4. Bagian Ulasan */
    .review-section {
        padding: 0 20px 20px 20px;
        margin-top: 10px;
        border-top: 8px solid #f5f5f5; 
        padding-top: 20px;
    }
    .review-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
    }
    .big-score {
        font-size: 3rem;
        font-weight: 800;
        color: #333;
        line-height: 1;
    }
    
    .bar-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 5px;
        font-size: 0.85rem;
        color: #666;
    }
    .progress-track {
        flex: 1;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background-color: #28a745; 
        border-radius: 10px;
    }

    /* 5. Footer Fixed (Tombol Beli) */
    .fixed-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 15px 20px;
        display: flex;
        gap: 15px;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.05);
        z-index: 2001; /* Pastikan di atas Wrapper (2000) dan Navbar Layout */
        border-top: 1px solid #eee;
    }
    .btn-cart {
        flex: 1;
        background-color: #28a745;
        color: white;
        border: none;
        padding: 14px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
    }
    .btn-buy {
        flex: 1;
        background-color: #fff;
        color: #28a745;
        border: 2px solid #28a745;
        padding: 14px;
        border-radius: 10px;
        font-weight: bold;
        font-size: 1rem;
        cursor: pointer;
    }
</style>
@endpush

@section('content')

<div class="detail-wrapper">

    <div class="hero-header">
        <a href="{{ route('dashboard') }}" class="back-btn">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>

    <div class="menu-image-container">
        @if($menu->image)
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="menu-img-detail">
        @else
            <img src="https://via.placeholder.com/220?text=Menu" class="menu-img-detail">
        @endif
    </div>

    <div class="product-info">
        <h1 class="menu-name">{{ $menu->name }}</h1>
        <div class="menu-price">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
        
        <div class="rating-mini">
            <i class="fa-solid fa-star text-warning"></i>
            <span style="font-weight:bold; color:#000;">{{ number_format($avgRating, 1) }}</span>
            <span>• {{ $totalReviews }} ulasan</span> 
        </div>

        <div class="store-badge">
            <img src="https://ui-avatars.com/api/?name=Catering+Sehat&background=28a745&color=fff" style="width:40px; height:40px; border-radius:50%;">
            <div>
                <div style="font-weight:bold; color:#333;">Catering Sehat Hemat</div>
                <div style="font-size:0.8rem; color:#28a745;">
                    <i class="fa-solid fa-check-circle"></i> Terpercaya
                </div>
            </div>
        </div>
    </div>

    <div class="review-section">
        <div class="review-header">
            <h3 style="font-size:1.2rem; font-weight:bold; margin:0; color:#222;">Ulasan Pelanggan</h3>
            <a href="#" style="color:#28a745; text-decoration:none; font-weight:bold;">Lihat Semua ></a>
        </div>

        <div style="display:flex; align-items:flex-start; gap:20px;">
            <div style="text-align:center;">
                <div class="big-score">{{ number_format($avgRating, 1) }}</div>
                <div style="color:#ffc107; font-size:0.9rem;">
                    @for($i=1; $i<=5; $i++)
                        <i class="fa-solid fa-star {{ $i <= round($avgRating) ? '' : 'text-muted' }}"></i>
                    @endfor
                </div>
                <div style="font-size:0.75rem; color:#888; margin-top:5px;">{{ $totalReviews }} Rating</div>
            </div>

            <div style="flex:1;">
                @for($star=5; $star>=1; $star--)
                    @php
                        $count = $starCounts[$star] ?? 0;
                        $percent = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                    @endphp
                    <div class="bar-row">
                        <span style="width:10px; font-weight:bold;">{{ $star }}</span>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $percent }}%;"></div>
                        </div>
                        <span style="width:25px; text-align:right;">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <div class="fixed-footer">
        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;">
            @csrf
            <input type="hidden" name="id" value="{{ $menu->id }}">
            <input type="hidden" name="name" value="{{ $menu->name }}">
            <input type="hidden" name="price" value="{{ $menu->price }}">
            <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
            <button type="submit" class="btn-cart">+ Keranjang</button>
        </form>

        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;">
            @csrf
            <input type="hidden" name="id" value="{{ $menu->id }}">
            <input type="hidden" name="name" value="{{ $menu->name }}">
            <input type="hidden" name="price" value="{{ $menu->price }}">
            <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
            <input type="hidden" name="direct_checkout" value="1"> 
            <button type="submit" class="btn-buy">Beli Sekarang</button>
        </form>
    </div>

</div> @endsection