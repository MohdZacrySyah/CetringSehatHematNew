@extends('layouts.app')
@section('title', 'Detail Pembayaran')

@push('styles')
<style>
    body {
        background: #8B9D5E;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .detail-header {
        background: #6B7D4A;
        padding: 15px;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
    }
    .detail-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .payment-logo {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }
    .payment-logo img {
        height: 60px;
    }
    .info-section {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
    }
    .info-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        font-size: 1.05rem;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }
    .info-label {
        color: #666;
    }
    .info-value {
        font-weight: 600;
        color: #333;
        text-align: right;
    }
    .btn-copy {
        background: #f0f0f0;
        color: #333;
        border: none;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 0.85rem;
        cursor: pointer;
        margin-left: 8px;
    }
    .total-section {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 12px;
        border-top: 2px solid #e0e0e0;
        margin-top: 10px;
    }
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 10px;
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
    }
    .btn-back {
        background: #fff;
        color: #333;
        border: 2px solid #ddd;
    }
    .btn-back:hover {
        background: #f5f5f5;
    }
    .btn-check {
        background: #28a745;
        color: #fff;
    }
    .btn-check:hover {
        background: #218838;
    }
</style>
@endpush

@section('content')
<div class="detail-header">
    Metode pembayaran
</div>

<div class="detail-container">
    <div class="payment-logo">
        @if($order->payment_method == 'dana')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/512px-Logo_dana_blue.svg.png" alt="Dana">
        @elseif($order->payment_method == 'gopay')
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="Gopay">
        @elseif($order->payment_method == 'linkaja')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/LinkAja.svg/512px-LinkAja.svg.png" alt="LinkAja">
        @elseif($order->payment_method == 'ovo')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/512px-Logo_ovo_purple.svg.png" alt="OVO">
        @elseif($order->payment_method == 'qris')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/512px-QRIS_logo.svg.png" alt="QRIS">
        @endif
    </div>

    <div class="info-section">
        <div class="info-title">Penerima</div>
        <div class="info-value" style="font-size: 1.1rem; margin-bottom: 15px;">CETRING SEHAT HEMAT</div>
        
        <div class="info-title" style="margin-top: 20px;">Nomor Penerima</div>
        <div style="display: flex; align-items: center; justify-content: space-between;">
            <span class="info-value" style="font-size: 1.1rem;" id="phoneNumber">08xxxxxxxx</span>
            <button class="btn-copy" onclick="copyNumber()">Salin</button>
        </div>
    </div>

    <div class="info-section">
        <div class="info-row total-section">
            <span class="info-label">Total bayar</span>
            <span class="info-value" style="color: #28a745; font-size: 1.2rem;">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="btn-group">
        <button class="btn-action btn-back" onclick="window.history.back()">
            Kembali
        </button>
        <a href="{{ route('order.payment.qr', $order->id) }}" class="btn-action btn-check" style="text-decoration: none; text-align: center;">
            cek status pembayaran
        </a>
    </div>
</div>

@push('scripts')
<script>
    function copyNumber() {
        const number = document.getElementById('phoneNumber').textContent;
        navigator.clipboard.writeText(number);
        alert('Nomor berhasil disalin!');
    }
</script>
@endpush
@endsection
