@extends('layouts.app')

@section('title', $menu->name)

@push('styles')
<style>
    /* === HACK: PAKSA SEMBUNYIKAN ELEMENT LAYOUT UTAMA === */
    /* Ini memastikan navbar/header bawaan layout tidak bocor ke tampilan detail */
    nav, header, aside, .main-header, .bottom-nav {
        display: none !important;
        z-index: -1 !important;
    }
    
    /* === WRAPPER UTAMA === */
    .detail-wrapper {
        background-color: #ffffff; /* Background Putih Solid untuk menutupi teks bocor */
        position: fixed;
        inset: 0; /* Menutupi seluruh layar */
        z-index: 99999; /* Layer Tertinggi */
        overflow-y: auto; /* Aktifkan scroll */
        padding-bottom: 120px; /* Ruang untuk footer */
        display: flex;
        flex-direction: column;
        -webkit-overflow-scrolling: touch;
    }

    /* === 1. HERO SECTION (GAMBAR) === */
    .hero-section {
        position: relative;
        width: 100%;
        height: 380px; 
        background-color: #e5e7eb;
        flex-shrink: 0;
    }
    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .hero-gradient {
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 150px;
        background: linear-gradient(to bottom, rgba(0,0,0,0.6), transparent);
        z-index: 1;
        pointer-events: none;
    }

    /* === NAVIGASI ATAS (BACK BUTTON) === */
    .top-nav {
        position: absolute;
        top: 20px; 
        left: 20px;
        z-index: 100;
        padding-top: env(safe-area-inset-top, 20px); 
    }
    .back-btn {
        width: 45px; height: 45px;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; 
        font-size: 1.2rem;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        transition: transform 0.2s;
    }
    .back-btn:active { transform: scale(0.9); background: rgba(255,255,255,0.4); }

    /* === 2. CONTENT CARD (KARTU PUTIH) === */
    .content-card {
        background: white;
        border-radius: 35px 35px 0 0;
        margin-top: -50px; 
        position: relative;
        z-index: 10;
        padding: 30px 25px;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
        min-height: 500px;
        flex: 1;
    }

    /* Judul & Info */
    .badge-category {
        display: inline-block;
        background: #eef5e0;
        color: #556B2F;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    .menu-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #1f2937;
        line-height: 1.2;
        margin-bottom: 10px;
    }
    
    .rating-row {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 25px;
        font-size: 0.95rem;
        color: #6b7280;
    }
    .stars { color: #f59e0b; display: flex; gap: 2px; }
    .dot { width: 4px; height: 4px; background: #d1d5db; border-radius: 50%; }

    /* Harga */
    .price-block {
        display: flex; justify-content: space-between; align-items: flex-end;
        padding-bottom: 25px;
        border-bottom: 2px dashed #f3f4f6;
        margin-bottom: 25px;
    }
    .price-label { font-size: 0.85rem; color: #9ca3af; margin-bottom: 4px; }
    .price-value { font-size: 2rem; font-weight: 800; color: #556B2F; line-height: 1; }
    .status-available { 
        display: flex; align-items: center; gap: 6px; 
        font-size: 0.85rem; font-weight: 600; color: #16a34a; 
        background: #dcfce7; padding: 6px 12px; border-radius: 20px;
    }

    /* Deskripsi */
    .section-title { font-size: 1.1rem; font-weight: 700; color: #111; margin-bottom: 12px; }
    .desc-text {
        font-size: 0.95rem;
        color: #4b5563;
        line-height: 1.7;
        margin-bottom: 40px;
    }

    /* === 3. REVIEW SECTION === */
    .review-container {
        background: #f9fafb;
        margin: 0 -25px; 
        padding: 30px 25px;
        border-top: 1px solid #f3f4f6;
    }
    
    .review-item {
        background: white;
        padding: 18px;
        border-radius: 16px;
        border: 1px solid #eee;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }
    .user-header {
        display: flex; justify-content: space-between; align-items: center;
        margin-bottom: 10px;
    }
    .user-info { display: flex; align-items: center; gap: 10px; }
    .user-avatar { 
        width: 38px; height: 38px; border-radius: 50%; 
        object-fit: cover; background: #e5e7eb; border: 2px solid white; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .user-name { font-size: 0.9rem; font-weight: 700; color: #111; display: block;}
    .review-time { font-size: 0.7rem; color: #9ca3af; }
    
    .comment-text { font-size: 0.9rem; color: #4b5563; line-height: 1.5; margin-top: 8px;}
    .comment-highlight { font-weight: 600; color: #1f2937; margin-bottom: 4px; display: block;}

    /* === 4. FIXED FOOTER === */
    .bottom-bar {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: white;
        padding: 16px 25px 25px 25px; 
        box-shadow: 0 -5px 20px rgba(0,0,0,0.05);
        display: flex;
        gap: 12px;
        z-index: 10000;
        border-top: 1px solid #f3f4f6;
    }
    .btn {
        flex: 1;
        padding: 16px;
        border-radius: 16px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        border: none;
        transition: transform 0.1s;
        display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .btn:active { transform: scale(0.97); }
    .btn-outline { background: #fff; color: #556B2F; border: 2px solid #556B2F; }
    .btn-fill { background: #556B2F; color: white; box-shadow: 0 8px 20px rgba(85, 107, 47, 0.25); }
</style>
@endpush

@section('content')

<div class="detail-wrapper">

    <div class="hero-section">
        <div class="hero-gradient"></div>
        
        <div class="top-nav">
            <a href="{{ route('dashboard') }}" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>

        @php
            $imagePath = 'https://via.placeholder.com/500x400?text=No+Image';
            if ($menu->image) {
                if (Str::startsWith($menu->image, 'http')) {
                    $imagePath = $menu->image;
                } elseif (file_exists(public_path('storage/' . $menu->image))) {
                    $imagePath = asset('storage/' . $menu->image);
                } elseif (file_exists(public_path($menu->image))) {
                    $imagePath = asset($menu->image);
                } else {
                    $imagePath = asset('storage/' . $menu->image);
                }
            }
        @endphp

        <img src="{{ $imagePath }}" alt="{{ $menu->name }}" class="hero-img">
    </div>

    <div class="content-card">
        
        <span class="badge-category">{{ str_replace('_', ' ', $menu->category ?? 'Umum') }}</span>
        <h1 class="menu-title">{{ $menu->name }}</h1>
        
        <div class="rating-row">
            <div class="stars">
                @for($i=1; $i<=5; $i++)
                    <i class="fa-solid fa-star {{ $i <= round($avgRating) ? '' : 'text-gray-300' }}"></i>
                @endfor
            </div>
            <span style="font-weight:700; color:#111;">{{ number_format($avgRating, 1) }}</span>
            <div class="dot"></div>
            <span>{{ $totalReviews }} Ulasan</span>
        </div>

        <div class="price-block">
            <div>
                <div class="price-label">Harga Spesial</div>
                <div class="price-value">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
            </div>
            <div class="status-available">
                <i class="fa-solid fa-circle-check"></i> Tersedia
            </div>
        </div>

        <div class="mb-8">
            <h3 class="section-title">Deskripsi Menu</h3>
            <p class="desc-text">
                {{ $menu->description ?? 'Menu spesial dari Catering Sehat Hemat yang diolah dengan bahan berkualitas tinggi.' }}
            </p>
        </div>

        <div class="review-container">
            <div class="flex justify-between items-center mb-6">
                <h3 class="section-title" style="margin:0;">Ulasan Pelanggan</h3>
                <span class="text-sm text-gray-500">{{ $totalReviews }} Komentar</span>
            </div>

            @forelse($menu->reviews as $review)
                <div class="review-item">
                    <div class="user-header">
                        <div class="user-info">
                            <img src="{{ $review->user->avatar ? asset('storage/'.$review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=random' }}" 
                                 class="user-avatar" alt="Avatar">
                            <div>
                                <span class="user-name">{{ $review->user->name }}</span>
                                <span class="review-time">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="stars" style="font-size: 0.8rem;">
                            @for($i=1; $i<=5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-200' }}"></i>
                            @endfor
                        </div>
                    </div>

                    @if($review->question)
                        <span class="comment-highlight">"{{ $review->question }}"</span>
                    @endif
                    <p class="comment-text">{{ $review->review_text }}</p>
                    
                    @if($review->media)
                        <img src="{{ asset('storage/' . $review->media) }}" 
                             style="width:80px; height:80px; border-radius:10px; margin-top:10px; object-fit:cover;"
                             onclick="window.open(this.src)">
                    @endif
                </div>
            @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fa-regular fa-face-smile text-3xl mb-2"></i>
                    <p class="text-sm">Belum ada ulasan.</p>
                </div>
            @endforelse
        </div>
    </div>

    <div class="bottom-bar">
        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;">
            @csrf
            <input type="hidden" name="id" value="{{ $menu->id }}">
            <input type="hidden" name="name" value="{{ $menu->name }}">
            <input type="hidden" name="price" value="{{ $menu->price }}">
            <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
            
            <button type="submit" class="btn btn-outline">
                <i class="fa-solid fa-cart-plus"></i> + Keranjang
            </button>
        </form>

        <form action="{{ route('cart.add') }}" method="POST" style="flex:1;">
            @csrf
            <input type="hidden" name="id" value="{{ $menu->id }}">
            <input type="hidden" name="name" value="{{ $menu->name }}">
            <input type="hidden" name="price" value="{{ $menu->price }}">
            <input type="hidden" name="image" value="{{ asset('storage/' . $menu->image) }}">
            <input type="hidden" name="direct_checkout" value="1"> 
            
            <button type="submit" class="btn btn-fill">
                Beli Sekarang
            </button>
        </form>
    </div>

</div>

@endsection