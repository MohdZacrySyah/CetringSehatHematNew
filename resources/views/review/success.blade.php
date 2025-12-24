@extends('layouts.app')
@section('title', 'Ulasan Berhasil')

@push('styles')
<style>
    .main-wrapper {
        background: #f8f9fa !important;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding-bottom: 0 !important;
    }
    
    body {
        background: #f8f9fa;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .success-container {
        text-align: center;
        padding: 40px 20px;
    }
    
    .success-icon {
        margin-bottom: 25px;
        animation: scaleIn 0.5s ease;
    }
    
    .success-icon i {
        font-size: 5rem;
        color: #22c55e;
    }
    
    @keyframes scaleIn {
        from {
            transform: scale(0);
        }
        to {
            transform: scale(1);
        }
    }
    
    .success-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 30px;
        text-transform: uppercase;
    }
    
    .btn-home {
        padding: 15px 40px;
        background: #22c55e;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.2s;
    }
    
    .btn-home:hover {
        background: #16a34a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }
</style>
@endpush

@section('content')
<div class="success-container">
    <div class="success-icon">
        <i class="fa-solid fa-circle-check"></i>
    </div>
    
    <h1 class="success-title">Ulasan Berhasil Dikirim</h1>
    
    <a href="{{ route('dashboard') }}" class="btn-home">
        Kembali ke Beranda
    </a>
</div>
@endsection
