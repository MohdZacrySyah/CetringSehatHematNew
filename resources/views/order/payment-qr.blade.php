@extends('layouts.app')
@section('title', 'Scan QR Code')

@push('styles')
<style>
    body {
        background: #8B9D5E;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .qr-header {
        background: #6B7D4A;
        padding: 15px;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        color: #fff;
    }
    .qr-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 0 15px;
    }
    .qr-logo {
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }
    .qr-logo img {
        height: 50px;
    }
    .receiver-info {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
    }
    .receiver-label {
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
    }
    .receiver-name {
        font-size: 1.05rem;
        color: #666;
        margin-bottom: 15px;
    }
    .qr-section {
        background: #fff;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        margin-bottom: 20px;
    }
    .qr-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 15px;
    }
    .qr-timer {
        font-size: 1.2rem;
        color: #dc3545;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .qr-code-wrapper {
        display: inline-block;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 12px;
        margin-bottom: 15px;
    }
    .qr-code-wrapper img {
        width: 220px;
        height: 220px;
        display: block;
    }
    .qr-instruction {
        color: #666;
        font-size: 0.95rem;
        margin-top: 15px;
    }
    .total-display {
        background: #fff;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 20px;
        text-align: center;
    }
    .total-label {
        color: #666;
        font-size: 0.95rem;
        margin-bottom: 5px;
    }
    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #333;
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
        text-decoration: none;
        text-align: center;
        display: block;
    }
    .btn-download {
        background: #fff;
        color: #333;
        border: 2px solid #ddd;
    }
    .btn-download:hover {
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
<div class="qr-header">
    Metode pembayaran
</div>

<div class="qr-container">
    <div class="qr-logo">
        @if($order->payment_method == 'qris')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/512px-QRIS_logo.svg.png" alt="QRIS">
        @elseif($order->payment_method == 'dana')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/512px-Logo_dana_blue.svg.png" alt="Dana">
        @elseif($order->payment_method == 'gopay')
            <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="Gopay">
        @elseif($order->payment_method == 'linkaja')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/LinkAja.svg/512px-LinkAja.svg.png" alt="LinkAja">
        @elseif($order->payment_method == 'ovo')
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/512px-Logo_ovo_purple.svg.png" alt="OVO">
        @endif
    </div>

    <div class="receiver-info">
        <div class="receiver-label">Penerima</div>
        <div class="receiver-name">CETRING SEHAT HEMAT</div>
    </div>

    <div class="qr-section">
        <div class="qr-title">QR CODE</div>
        <div class="qr-timer">
            <i class="fa-regular fa-clock"></i>
            <span id="countdown">00:59</span>
        </div>
        <div class="qr-code-wrapper">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data={{ urlencode('Order:'.$order->order_number.'|Amount:'.$order->total_bayar.'|Method:'.strtoupper($order->payment_method)) }}" alt="QR Code">
        </div>
        <div class="total-display" style="background: transparent; padding: 10px 0;">
            <div class="total-label">Total bayar</div>
            <div class="total-amount">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</div>
        </div>
        <p class="qr-instruction">
            Scan QR code menggunakan aplikasi {{ strtoupper($order->payment_method) }} untuk melakukan pembayaran
        </p>
    </div>

    <div class="btn-group">
        <button class="btn-action btn-download" onclick="downloadQR()">
            unduh kode QR
        </button>
        
        <!-- PERBAIKAN: Button manual, user harus klik sendiri -->
        <button type="button" class="btn-action btn-check" onclick="confirmPayment()">
            cek Status pembayaran
        </button>
    </div>
</div>

@push('scripts')
<script>
    // Countdown timer
    let seconds = 59;
    const countdownElement = document.getElementById('countdown');
    
    const timer = setInterval(() => {
        seconds--;
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        countdownElement.textContent = `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        
        if (seconds <= 0) {
            clearInterval(timer);
            alert('Waktu pembayaran habis! Silakan buat pesanan baru.');
            window.location.href = '{{ route("cart") }}';
        }
    }, 1000);

    function downloadQR() {
        const qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ urlencode("Order:".$order->order_number."|Amount:".$order->total_bayar) }}';
        const link = document.createElement('a');
        link.href = qrUrl;
        link.download = 'qr-code-{{ $order->order_number }}.png';
        link.click();
    }

    // PERBAIKAN: Function manual untuk konfirmasi pembayaran
    function confirmPayment() {
        // Tampilkan konfirmasi dulu
        if (confirm('Apakah Anda sudah melakukan pembayaran?')) {
            // Redirect ke halaman loading
            window.location.href = '{{ route("order.loading", $order->id) }}';
        }
    }
</script>
@endpush
@endsection
