@extends('layouts.app')
@section('title', 'Pembayaran Berhasil')

@push('styles')
<style>
    body {
        background: #8B9D5E;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .success-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 0 20px;
        text-align: center;
    }
    .success-icon {
        margin-bottom: 20px;
        animation: scaleIn 0.5s ease;
    }
    .success-icon i {
        font-size: 4rem;
        color: #20c997;
        animation: pulse 2s ease infinite;
    }
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
    .success-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3a1a;
        margin-bottom: 8px;
        text-transform: uppercase;
    }
    .success-subtitle {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 30px;
    }
    .amount-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .amount-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
    }
    .amount-label {
        color: #666;
        font-size: 0.95rem;
    }
    .amount-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
    }
    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid #f0f0f0;
    }
    .status-badge {
        padding: 6px 16px;
        background: #d4edda;
        color: #155724;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    .info-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        text-align: left;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child {
        border-bottom: none;
    }
    .info-label {
        color: #666;
        font-size: 0.9rem;
    }
    .info-value {
        color: #333;
        font-weight: 600;
        font-size: 0.9rem;
        text-align: right;
        max-width: 60%;
        word-break: break-word;
    }
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }
    .btn-action {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        text-align: center;
        display: block;
    }
    .btn-home {
        background: #fff;
        color: #333;
        border: 2px solid #ddd;
    }
    .btn-home:hover {
        background: #f5f5f5;
    }
    .btn-detail {
        background: #28a745;
        color: #fff;
    }
    .btn-detail:hover {
        background: #218838;
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    
    <h1 class="success-title">Pembayaran Berhasil</h1>
    <p class="success-subtitle">Your payment has been successfully done.</p>

    <div class="amount-card">
        <div class="amount-row">
            <span class="amount-label">Amount</span>
            <span class="amount-value">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
        </div>
        <div class="status-row">
            <span class="info-label">status pembayaran</span>
            <span class="status-badge">Success</span>
        </div>
    </div>

    <div class="info-card">
        <div class="info-row">
            <span class="info-label">Ref Number</span>
            <span class="info-value">{{ $order->order_number }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">nama penerima</span>
            <span class="info-value">Cetring Sehat Hemat</span>
        </div>
        <div class="info-row">
            <span class="info-label">metode pembayran</span>
            <span class="info-value">{{ strtoupper($order->payment_method) }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">tanggal pembayaran</span>
            <span class="info-value">{{ $order->paid_at->format('M d, Y, H:i:s') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">pengirim</span>
            <span class="info-value">{{ $order->user->name }}</span>
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('dashboard') }}" class="btn-action btn-home">
            Kembali ke beranda
        </a>
        <a href="{{ route('order.detail', $order->id) }}" class="btn-action btn-detail">
            Detail pesanan
        </a>
    </div>
</div>
@endsection
