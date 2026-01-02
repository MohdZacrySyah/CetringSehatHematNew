@extends('layouts.app')

@section('title', 'Keranjang - Catering Sehat Hemat')

@push('styles')
<style>
    body {
        background: #a8b87c;
    }
    .cart-header {
        background-color: #879b55;
        padding: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: relative;
        color: white;
        font-weight: bold;
        font-size: 1.2rem;
        border-radius: 9px;
        margin: 24px 24px 20px 24px;
    }
    .back-arrow {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.5rem;
        color: white;
        text-decoration: none;
    }
    .cart-list-container {
        flex-grow: 1;
        padding: 0 20px 20px 20px;
        width: 100%;
        max-width: 900px;
        margin: 0 auto 80px auto;
        box-sizing: border-box;
    }
    .cart-item {
        display: flex;
        align-items: center;
        background-color: #f5f7ee;
        border-radius: 10px;
        padding: 10px 15px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .checkbox-container {
        margin-right: 10px;
    }
    .custom-checkbox {
        width: 25px;
        height: 25px;
        background-color: #c2d5a0;
        border: 2px solid #879b55;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
        position: relative;
    }
    .custom-checkbox input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .checkmark {
        position: absolute;
        left: 8px;
        top: 4px;
        width: 6px;
        height: 12px;
        border: solid #4A572A;
        border-width: 0 3px 3px 0;
        transform: rotate(45deg);
        display: none;
    }
    .custom-checkbox input:checked ~ .checkmark {
        display: block;
    }
    .cart-item img {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        object-fit: cover;
        margin-right: 15px;
    }
    .item-details {
        flex-grow: 1;
        text-align: left;
    }
    .item-details h3 {
        margin: 0;
        font-size: 1.05rem;
        color: #4A572A;
    }
    .item-details p {
        margin: 5px 0 0;
        font-size: 0.95rem;
        color: #666;
        font-weight: bold;
    }
    .quantity-area {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }
    .quantity-adjuster {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.86rem;
        color: #555;
    }
    .quantity-btn {
        background-color: #e0e9cf;
        border: 1px solid #c2d5a0;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 1rem;
        font-weight: bold;
        color: #4A572A;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
    }
    .quantity-number {
        font-size: 1.05rem;
        font-weight: bold;
        min-width: 22px;
        text-align: center;
    }
    .remove-btn {
        border: none;
        background: none;
        color: #b33b32;
        font-size: 1.1rem;
        cursor: pointer;
    }

    .total-summary {
        background-color: #f5f7ee;
        border-radius: 10px;
        padding: 15px 20px;
        margin-top: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-size: 1.05rem;
        font-weight: bold;
        color: #4A572A;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .checkout-button {
        background-color: #556B2F;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 14px;
        font-size: 1.02rem;
        font-weight: bold;
        cursor: pointer;
        width: 100%;
        margin-top: 18px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        text-decoration: none;
        display: block;
        text-align: center;
        transition: opacity 0.3s;
    }
    .checkout-button:hover {
        background-color: #4A572A;
    }
    .checkout-button.disabled {
        background: #9faf82;
        cursor: not-allowed;
        pointer-events: none;
        opacity: 0.5;
    }
    .empty-text {
        text-align: center;
        color: #555;
        margin-top: 40px;
    }
</style>
@endpush

@section('content')
<div class="cart-header">
    <a href="{{ route('dashboard') }}" class="back-arrow"><i class="fa-solid fa-arrow-left"></i></a>
    <span>Keranjang</span>
</div>

<div class="cart-list-container">
    {{-- MENAMPILKAN PESAN ERROR JIKA CHECKOUT GAGAL --}}
    @if(session('error'))
        <div style="background-color: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold;">
            {{ session('error') }}
        </div>
    @endif

    @if($carts->isEmpty())
        <div class="empty-text">
            Keranjang Anda masih kosong.
        </div>
    @else
        @foreach($carts as $cart)
        <div class="cart-item" data-price="{{ $cart->price }}">
            <label class="checkbox-container">
                <div class="custom-checkbox">
                    <input type="checkbox" onchange="calculateTotal()">
                    <span class="checkmark"></span>
                </div>
            </label>
            <img src="{{ asset($cart->image) }}" alt="{{ $cart->name }}"> <div class="item-details">
                <h3>{{ $cart->name }}</h3>
                <p>Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
            </div>
            <div class="quantity-area">
                <form action="{{ route('cart.update', $cart->id) }}" method="POST" style="display:inline-flex;align-items:center;">
                    @csrf
                    @method('PUT')
                    <div class="quantity-adjuster">
                        <button type="submit" name="quantity" value="{{ $cart->quantity - 1 }}" class="quantity-btn" {{ $cart->quantity <= 1 ? 'disabled' : '' }}>-</button>
                        <span class="quantity-number">{{ $cart->quantity }}</span>
                        <button type="submit" name="quantity" value="{{ $cart->quantity + 1 }}" class="quantity-btn">+</button>
                    </div>
                </form>
                <form action="{{ route('cart.remove', $cart->id) }}" method="POST" style="margin-top:6px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="remove-btn"><i class="fa-solid fa-trash"></i></button>
                </form>
            </div>
        </div>
        @endforeach
    @endif

    <div class="total-summary">
        <span>Total :</span>
        <span id="total-price">Rp 0</span>
    </div>
    
    <form action="{{ route('order.checkoutPage') }}" method="GET"> 
    <button type="submit" class="checkout-button" id="checkoutBtn">
        Lanjut ke Pembayaran
    </button>
</form>
</div>
@endsection

@push('scripts')
<script>
    function calculateTotal() {
        let total = 0;
        let hasChecked = false;
        let items = document.querySelectorAll('.cart-item');
        
        items.forEach(item => {
            let checkbox = item.querySelector('input[type="checkbox"]');
            if (checkbox && checkbox.checked) {
                hasChecked = true;
                let price = parseFloat(item.dataset.price);
                let qtyText = item.querySelector('.quantity-number');
                let quantity = parseInt(qtyText ? qtyText.textContent : "1");
                total += price * quantity;
            }
        });
        
        let totalPriceEl = document.getElementById('total-price');
        totalPriceEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        
        let checkoutBtn = document.getElementById('checkoutBtn');
        if (hasChecked && total > 0) {
            checkoutBtn.classList.remove('disabled');
            checkoutBtn.style.pointerEvents = 'auto';
            checkoutBtn.style.opacity = '1';
        } else {
            checkoutBtn.classList.add('disabled');
            checkoutBtn.style.pointerEvents = 'none';
            checkoutBtn.style.opacity = '0.5';
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        // OTOMATIS CENTANG SEMUA CHECKBOX SAAT HALAMAN DIBUKA
        document.querySelectorAll('input[type="checkbox"]').forEach(function(cb){
            cb.checked = true;
            cb.addEventListener('change', calculateTotal);
        });
        
        // Hitung total langsung agar tombol "Beli Sekarang" menyala
        calculateTotal(); 
    });
</script>
@endpush