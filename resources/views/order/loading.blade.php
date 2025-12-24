@extends('layouts.app')
@section('title', 'Memproses Pembayaran')

@push('styles')
<style>
    body {
        background: #8B9D5E;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .loading-container {
        text-align: center;
        padding: 40px 20px;
    }
    .loading-icon {
        margin-bottom: 30px;
        animation: fly 2s ease-in-out infinite;
    }
    .loading-icon i {
        font-size: 6rem;
        color: #5b7cc7;
    }
    @keyframes fly {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }
        25% {
            transform: translateY(-30px) rotate(-5deg);
        }
        50% {
            transform: translateY(-50px) rotate(5deg);
        }
        75% {
            transform: translateY(-30px) rotate(-5deg);
        }
    }
    .loading-text {
        font-size: 1.3rem;
        font-weight: 700;
        color: #2d3a1a;
        margin-bottom: 10px;
    }
    .loading-subtext {
        font-size: 1rem;
        color: #555;
    }
    .spinner {
        width: 40px;
        height: 40px;
        margin: 30px auto;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #6B8E23;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="loading-container">
    <div class="loading-icon">
        <i class="fa-solid fa-paper-plane"></i>
    </div>
    <div class="loading-text">tunggu sebentar ya</div>
    <div class="loading-subtext">pembayaran anda sedang di konfirmasi</div>
    <div class="spinner"></div>
</div>

@push('scripts')
<script>
    // Auto redirect ke success page setelah 3 detik
    setTimeout(() => {
        window.location.href = '{{ route("order.success", $order->id) }}';
    }, 3000);
</script>
@endpush
@endsection
