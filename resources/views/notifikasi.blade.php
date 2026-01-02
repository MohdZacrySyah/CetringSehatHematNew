@extends('layouts.app')
@section('title', 'Notifikasi Pesanan')

@push('styles')
<style>
    body {
        background: #8c9e5e; 
    }
    .notif-section {
        max-width: 1070px;
        margin: 0 auto;
        padding: 15px 0 80px 0;
    }
    .notif-header {
        background-color: #7b8e50;
        color: #fff;
        padding: 15px 0;
        border-radius: 9px;
        font-weight: bold;
        font-size: 1.18rem;
        margin-bottom: 19px;
        margin-top: 22px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.07);
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }
    .notif-back-btn {
        position: absolute;
        left: 19px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.43rem;
        color: #fff;
        border: none;
        background: none;
        cursor: pointer;
        padding: 0;
        z-index: 2;
    }
    .notif-actions {
        text-align: right;
        margin-bottom: 15px;
    }
    .mark-all-btn {
        background: #7b8e50;
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.8rem;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .mark-all-btn:hover {
        background: #556b2f;
    }
    
    .notif-list-block {
        background: #ffffff; 
        border-radius: 15px;
        padding: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        position: relative;
        transition: transform 0.1s;
    }
    .notif-list-block:active {
        transform: scale(0.99);
    }
    .notif-list-block.unread {
        background: #fdfdfd; 
        border-left: 5px solid #d32f2f; 
    }
    
    .notif-img {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        background: #eee;
        border: 1px solid #ddd;
        flex-shrink: 0;
    }
    
    .notif-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        /* Tambahkan min-width agar layout stabil */
        min-width: 0; 
    }
    .notif-row-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 5px;
    }
    .notif-title {
        font-weight: bold;
        font-size: 1rem;
        color: #2c3e50;
    }
    
    .status-dot {
        height: 10px;
        width: 10px;
        background-color: #28a745;
        border-radius: 50%;
        display: inline-block;
        margin-left: 5px;
    }

    /* Style Konten Pesan Agar Tidak Terpotong */
    .notif-content {
        color: #555;
        font-size: 0.9rem;
        margin: 0;
        line-height: 1.4;
        /* Hapus overflow hidden agar teks tampil semua */
        word-wrap: break-word; /* Agar teks panjang turun ke bawah */
    }

    .notif-time {
        color: #999;
        font-size: 0.75rem;
        margin-top: 8px;
    }
    
    .notif-delete {
        color: #ab3d36;
        background: none;
        border: none;
        font-size: 1rem;
        cursor: pointer;
        padding: 5px;
        margin-left: 5px;
    }
    .notif-delete:hover {
        color: #d32f2f;
    }

    .notif-empty {
        text-align: center;
        color: #fff;
        padding: 60px 20px;
    }
</style>
@endpush

@section('content')
<div class="notif-header">
    <button class="notif-back-btn" onclick="window.history.back()" type="button">
        <i class="fa-solid fa-arrow-left"></i>
    </button>
    Notifikasi Pesanan
</div>

<div class="notif-section">
    @if($notifications->isEmpty())
        <div class="notif-empty">
            <i class="fa-solid fa-bell-slash" style="font-size:3rem;color:#eee;margin-bottom:15px;"></i>
            <p>Belum ada notifikasi masuk.</p>
        </div>
    @else
        <div class="notif-actions">
            <form action="{{ route('notifikasi.mark-all-read') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="mark-all-btn">
                    <i class="fa-solid fa-check-double"></i> Tandai Semua Dibaca
                </button>
            </form>
        </div>

        @foreach($notifications as $notif)
        <a href="{{ route('notifikasi.detail', $notif->id) }}" class="notif-list-block {{ !$notif->is_read ? 'unread' : '' }}">
            
            @php
                $imgSrc = 'https://via.placeholder.com/60?text=IMG';
                
                if($notif->order && $notif->order->items->isNotEmpty()){
                    $firstItem = $notif->order->items->first();
                    if($firstItem->menu && $firstItem->menu->image){
                        $imgSrc = asset('storage/' . $firstItem->menu->image);
                    }
                    elseif($firstItem->menu_image){
                         $imgSrc = asset('storage/' . $firstItem->menu_image);
                    }
                }
            @endphp

            <img src="{{ $imgSrc }}" 
                 class="notif-img" 
                 alt="Order Img"
                 onerror="this.onerror=null; this.src='https://via.placeholder.com/60?text=Err';">
            
            <div class="notif-main">
                <div class="notif-row-top">
                    <div style="display:flex; align-items:center;">
                        <span class="notif-title">{{ $notif->title }}</span>
                        @if(!$notif->is_read)
                            <span class="status-dot" title="Belum dibaca"></span>
                        @endif
                    </div>
                    
                    <form action="{{ route('notifikasi.destroy', $notif->id) }}" method="POST" onclick="event.stopPropagation(); if(!confirm('Hapus notifikasi ini?')) event.preventDefault();" style="margin:0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="notif-delete" title="Hapus Notifikasi">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
                
                {{-- PERBAIKAN DI SINI: Tampilkan pesan asli tanpa Str::limit --}}
                <p class="notif-content">
                    {{ $notif->message }}
                </p>

                <div class="notif-time">
                    {{ $notif->created_at->diffForHumans() }}
                </div>
            </div>
        </a>
        @endforeach
    @endif
</div>
@endsection