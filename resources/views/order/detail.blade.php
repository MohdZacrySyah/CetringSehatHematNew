@extends('layouts.app')
@section('title', 'Detail Pesanan')

@push('styles')
<style>
    body {
        background: #f8f9fa;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .detail-header {
        background: #fff;
        padding: 15px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 100;
    }
    .back-btn {
        font-size: 1.3rem;
        color: #333;
        cursor: pointer;
        margin-right: 15px;
        text-decoration: none;
    }
    .header-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #333;
    }
    .detail-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 15px;
        padding-bottom: 30px;
    }
    .status-card {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .status-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .status-row:last-child {
        margin-bottom: 0;
    }
    .status-label {
        color: #666;
        font-size: 0.9rem;
    }
    .status-value {
        font-weight: 600;
        color: #333;
        text-align: right;
    }
    .status-delivered {
        color: #28a745 !important;
    }
    .status-processing {
        color: #ffc107 !important;
    }
    .status-pending {
        color: #dc3545 !important;
    }
    .section-title {
        font-weight: 700;
        color: #333;
        margin: 20px 0 10px 0;
        font-size: 1.05rem;
    }
    .product-card {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .product-item {
        display: flex;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .product-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .product-item:first-child {
        padding-top: 0;
    }
    .product-img {
        width: 70px;
        height: 70px;
        border-radius: 8px;
        object-fit: cover;
        background: #f0f0f0;
        flex-shrink: 0;
    }
    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .product-price {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 3px;
    }
    .product-qty {
        color: #999;
        font-size: 0.85rem;
    }
    .custom-note {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .note-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }
    .note-content {
        color: #666;
        font-size: 0.95rem;
        font-style: italic;
        line-height: 1.5;
    }
    .payment-summary {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .summary-row:last-child {
        margin-bottom: 0;
    }
    .summary-label {
        color: #666;
    }
    .summary-value {
        font-weight: 600;
        color: #333;
    }
    .summary-total {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 12px;
        border-top: 2px solid #e0e0e0;
        margin-top: 8px;
    }
    .summary-total .summary-value {
        color: #28a745;
        font-size: 1.2rem;
    }
    .action-buttons {
        margin-top: 20px;
    }
    .btn-review {
        width: 100%;
        padding: 15px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.3s;
        margin-bottom: 10px;
    }
    .btn-review:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: #fff;
    }
    .btn-secondary {
        width: 100%;
        padding: 15px;
        background: #fff;
        color: #333;
        border: 2px solid #6B8E23;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: block;
        text-align: center;
        transition: all 0.3s;
    }
    .btn-secondary:hover {
        background: #f8f9fa;
        color: #333;
    }
</style>
@endpush

@section('content')
<div class="detail-header">
    <a href="{{ route('dashboard') }}" class="back-btn">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <span class="header-title">detail pesanan</span>
</div>

<div class="detail-container">
    <!-- Status Card -->
    <div class="status-card">
        <div class="status-row">
            <span class="status-label">status pemesanan</span>
            <span class="status-value 
                @if($order->status === 'delivered') status-delivered
                @elseif($order->status === 'processing') status-processing
                @else status-pending
                @endif">
                @if($order->status === 'delivered')
                    Pesanan Selesai
                @elseif($order->status === 'processing')
                    Pesanan Diproses
                @else
                    Pesanan Pending
                @endif
            </span>
        </div>
        <div class="status-row">
            <span class="status-label">Status pembayaran</span>
            <span class="status-value" style="color: #28a745;">
                @if($order->payment_status === 'paid')
                    Sudah Dibayar
                @else
                    Menunggu Dibayar
                @endif
            </span>
        </div>
        <div class="status-row">
            <span class="status-label">Tanggal pemesanan</span>
            <span class="status-value">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="section-title">Detail produk</div>
    <div class="product-card">
        @foreach($order->items as $item)
        <div class="product-item">
            @if($item->menu_image)
                <img src="{{ asset($item->menu_image) }}" 
                     alt="{{ $item->menu_name }}" 
                     class="product-img"
                     onerror="this.src='https://via.placeholder.com/70x70/8B9D5E/ffffff?text=No+Image'">
            @else
                <img src="https://via.placeholder.com/70x70/8B9D5E/ffffff?text=No+Image" 
                     alt="{{ $item->menu_name }}" 
                     class="product-img">
            @endif
            <div class="product-info">
                <div class="product-name">{{ $item->menu_name }}</div>
                <div class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                <div class="product-qty">jumlah {{ $item->quantity }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Catatan Custom -->
    @if($order->custom_note)
    <div class="custom-note">
        <div class="note-title">catatan custom</div>
        <div class="note-content">{{ $order->custom_note }}</div>
    </div>
    @endif

    <!-- Rincian Pembayaran -->
    <div class="section-title">Rincian pembayaran</div>
    <div class="payment-summary">
        <div class="summary-row">
            <span class="summary-label">metode pembayaran</span>
            <span class="summary-value">
                @if($order->payment_method == 'cod')
                    COD
                @elseif($order->payment_method == 'qris')
                    QRIS
                @elseif($order->payment_method == 'transfer')
                    Transfer Bank
                @else
                    {{ strtoupper($order->payment_method) }}
                @endif
            </span>
        </div>
        <div class="summary-row">
            <span class="summary-label">subtotal harga</span>
            <span class="summary-value">Rp {{ number_format($order->subtotal ?? $order->total_price, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">biaya jasa aplikasi</span>
            <span class="summary-value">Rp {{ number_format($order->biaya_aplikasi ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label">biaya layanan</span>
            <span class="summary-value">Rp {{ number_format($order->biaya_pengiriman ?? 0, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row summary-total">
            <span class="summary-label">Total Bayar</span>
            <span class="summary-value">Rp {{ number_format($order->total_bayar ?? $order->total_price, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <!-- Action Buttons -->
<div class="action-buttons">
    <!-- Button Beri Ulasan - Muncul untuk semua status -->
    <a href="{{ route('review.create', $order->id) }}" class="btn-review">
        <i class="fa-solid fa-star"></i> Beri Ulasan
    </a>

    <!-- Button Pesan Lagi -->
    <a href="{{ route('dashboard') }}" class="btn-secondary">
        <i class="fa-solid fa-cart-shopping"></i> Pesan Lagi
    </a>
</div>

</div>
@endsection
