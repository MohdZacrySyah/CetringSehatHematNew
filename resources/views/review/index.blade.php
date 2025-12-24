@extends('layouts.app')
@section('title', 'Penilaian dan Ulasan')

@push('styles')
<style>
    .main-wrapper {
        background: #8FA864 !important;
        padding-bottom: 80px !important;
    }
    
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    body {
        background: #8FA864;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .rating-header {
        background: #8FA864;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .back-btn {
        font-size: 1.5rem;
        color: #333;
        cursor: pointer;
        text-decoration: none;
        margin-right: 15px;
    }
    
    .header-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
    }
    
    .rating-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 15px 20px 15px;
    }
    
    .review-card {
        background: #E8E8E8;
        border: 2px solid #6B8E23;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        position: relative;
    }
    
    .review-header-section {
        display: flex;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        background: #333;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
    }
    
    .user-avatar i {
        color: #fff;
        font-size: 1.2rem;
    }
    
    .user-name {
        font-weight: 600;
        color: #333;
        font-size: 1rem;
    }
    
    .order-info {
        font-size: 0.85rem;
        color: #555;
        margin-bottom: 8px;
    }
    
    .order-info strong {
        color: #333;
    }
    
    .star-display {
        display: flex;
        gap: 3px;
        margin-bottom: 12px;
    }
    
    .star-display i {
        color: #FFD700;
        font-size: 0.9rem;
    }
    
    .star-display i.empty {
        color: #ddd;
    }
    
    .review-text {
        font-size: 0.95rem;
        color: #333;
        line-height: 1.6;
        font-style: italic;
    }
    
    .review-media {
        margin-top: 15px;
        border-radius: 10px;
        overflow: hidden;
    }
    
    .review-media img,
    .review-media video {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .no-reviews {
        text-align: center;
        padding: 60px 20px;
        color: #333;
    }
    
    .no-reviews i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .no-reviews p {
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .review-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: #6B8E23;
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="rating-header">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <span class="header-title">Penilaian dan Ulasan</span>
</div>

<div class="rating-container">
    @forelse($reviews as $review)
    <div class="review-card">
        <div class="review-badge">
            Verified
        </div>
        
        <div class="review-header-section">
            <div class="user-avatar">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="user-name">{{ $review->user->name }}</div>
        </div>

        <div class="order-info">
            <strong>Pesanan :</strong> 
            @foreach($review->order->orderItems as $item)
                {{ $item->menu->name }}@if(!$loop->last), @endif
            @endforeach
        </div>

        <div class="star-display">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= $review->rating)
                    <i class="fa-solid fa-star"></i>
                @else
                    <i class="fa-solid fa-star empty"></i>
                @endif
            @endfor
        </div>

        <div class="review-text">
            {{ $review->review_text }}
        </div>

        @if($review->media_path)
        <div class="review-media">
            @if(Str::endsWith($review->media_path, ['.jpg', '.jpeg', '.png']))
                <img src="{{ asset('storage/' . $review->media_path) }}" alt="Review media">
            @else
                <video controls>
                    <source src="{{ asset('storage/' . $review->media_path) }}" type="video/mp4">
                </video>
            @endif
        </div>
        @endif
    </div>
    @empty
    <div class="no-reviews">
        <i class="fa-solid fa-star"></i>
        <p>Belum ada ulasan</p>
    </div>
    @endforelse
</div>
@endsection
