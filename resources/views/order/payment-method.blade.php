@extends('layouts.app')
@section('title', 'Pilih Metode Pembayaran')

@push('styles')
<style>
    body {
        background: #f8f9fa;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }
    .payment-header {
        background: #fff;
        padding: 15px;
        text-align: center;
        font-weight: 700;
        font-size: 1.1rem;
        border-bottom: 1px solid #e0e0e0;
        color: #333;
    }
    .payment-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 15px;
    }
    .order-summary {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .order-item {
        display: flex;
        gap: 12px;
        margin-bottom: 10px;
    }
    .order-item img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        background: #f0f0f0;
    }
    .item-info {
        flex: 1;
    }
    .item-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .item-price {
        color: #666;
        font-size: 0.9rem;
    }
    .item-qty {
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
    .custom-note label {
        display: block;
        font-weight: 600;
        color: #333;
        margin-bottom: 8px;
    }
    .custom-note input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 0.95rem;
        box-sizing: border-box;
    }
    .payment-methods {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .methods-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
    }
    .method-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .method-option:hover {
        border-color: #6B8E23;
        background: #f9fdf4;
    }
    .method-option.selected {
        border-color: #6B8E23;
        background: #f0f8e6;
    }
    .method-logo {
        height: 35px;
        object-fit: contain;
    }
    .method-radio {
        width: 24px;
        height: 24px;
        accent-color: #6B8E23;
    }
    .price-detail {
        background: #fff;
        border: 2px solid #6B8E23;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .price-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }
    .price-label {
        color: #666;
    }
    .price-value {
        font-weight: 600;
        color: #333;
    }
    .price-total {
        font-size: 1.1rem;
        font-weight: 700;
        padding-top: 10px;
        border-top: 2px solid #e0e0e0;
        margin-top: 5px;
    }
    .btn-pay {
        width: 100%;
        padding: 15px;
        background: #28a745;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1.05rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-pay:hover {
        background: #218838;
    }
    .btn-pay:disabled {
        background: #ccc;
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="payment-header">
    Beli sekarang
</div>

<div class="payment-container">
    <div class="order-summary">
        @foreach($carts as $cart)
        <div class="order-item">
            <img src="{{ asset($cart->menu->image) }}" 
                 alt="{{ $cart->menu->name }}"
                 onerror="this.src='https://via.placeholder.com/60x60/8B9D5E/ffffff?text=No+Image'">
            <div class="item-info">
                <div class="item-name">{{ $cart->menu->name }}</div>
                <div class="item-price">Rp {{ number_format($cart->menu->price, 0, ',', '.') }}</div>
                <div class="item-qty">jumlah {{ $cart->quantity }}</div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="custom-note">
        <label>tulis catatan jika ingin custom</label>
        <input type="text" placeholder="custom custom" id="customNote">
    </div>

    <form action="{{ route('order.payment.select') }}" method="POST" id="paymentForm">
        @csrf
        <input type="hidden" name="custom_note" id="customNoteInput">
        
        <div class="payment-methods">
            <div class="methods-title">metode</div>
            
            <label class="method-option" onclick="selectMethod(this, 'dana')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Logo_dana_blue.svg/512px-Logo_dana_blue.svg.png" alt="Dana" class="method-logo">
                <input type="radio" name="payment_method" value="dana" class="method-radio" required>
            </label>

            <label class="method-option" onclick="selectMethod(this, 'gopay')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg" alt="Gopay" class="method-logo">
                <input type="radio" name="payment_method" value="gopay" class="method-radio" required>
            </label>

            <label class="method-option" onclick="selectMethod(this, 'linkaja')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/LinkAja.svg/512px-LinkAja.svg.png" alt="LinkAja" class="method-logo">
                <input type="radio" name="payment_method" value="linkaja" class="method-radio" required>
            </label>

            <label class="method-option" onclick="selectMethod(this, 'ovo')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/eb/Logo_ovo_purple.svg/512px-Logo_ovo_purple.svg.png" alt="OVO" class="method-logo">
                <input type="radio" name="payment_method" value="ovo" class="method-radio" required>
            </label>

            <label class="method-option" onclick="selectMethod(this, 'qris')">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/QRIS_logo.svg/512px-QRIS_logo.svg.png" alt="QRIS" class="method-logo">
                <input type="radio" name="payment_method" value="qris" class="method-radio" required>
            </label>

            <label class="method-option" onclick="selectMethod(this, 'cod')">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/4947/4947506.png" alt="COD" style="width: 40px; height: 40px;">
                    <span style="font-weight: 600;">COD(cash on delivery)</span>
                </div>
                <input type="radio" name="payment_method" value="cod" class="method-radio" required>
            </label>
        </div>

        <div class="price-detail">
            <div style="font-weight: 700; margin-bottom: 10px;">detail harga produk</div>
            <div class="price-row">
                <span class="price-label">sub total harga</span>
                <span class="price-value">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">biaya jasa aplikasi</span>
                <span class="price-value">Rp {{ number_format($biayaAplikasi, 0, ',', '.') }}</span>
            </div>
            <div class="price-row">
                <span class="price-label">biaya layanan</span>
                <span class="price-value">Rp {{ number_format($biayaPengiriman, 0, ',', '.') }}</span>
            </div>
            <div class="price-row price-total">
                <span class="price-label">total bayar</span>
                <span class="price-value" style="color: #28a745;">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <button type="submit" class="btn-pay" id="btnPay" disabled>
            Bayar
        </button>
    </form>
</div>

@push('scripts')
<script>
    function selectMethod(element, method) {
        document.querySelectorAll('.method-option').forEach(opt => {
            opt.classList.remove('selected');
        });
        element.classList.add('selected');
        document.getElementById('btnPay').disabled = false;
    }

    document.getElementById('paymentForm').addEventListener('submit', function() {
        const note = document.getElementById('customNote').value;
        document.getElementById('customNoteInput').value = note;
    });
</script>
@endpush
@endsection
