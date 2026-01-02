@extends('layouts.app')
@section('title', 'Pembayaran - Catering Sehat Hemat')

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
    
    /* Timer Style */
    .timer-box {
        background: #FEF3C7;
        border: 2px solid #F59E0B;
        color: #92400E;
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 20px;
    }
    .timer-text {
        font-size: 1.5rem;
        font-weight: bold;
        font-family: monospace;
    }
    .timer-label {
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .info-section {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .info-title {
        font-weight: 700;
        color: #333;
        margin-bottom: 15px;
        font-size: 1.05rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }
    .info-label { color: #666; }
    .info-value { font-weight: 600; color: #333; text-align: right; }

    .btn-action {
        width: 100%;
        padding: 15px;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-bottom: 10px;
    }
    .btn-pay {
        background: #28a745;
        color: #fff;
        box-shadow: 0 4px 6px rgba(40, 167, 69, 0.2);
    }
    .btn-pay:hover { background: #218838; transform: translateY(-1px); }
    
    .btn-cancel {
        background: #fff;
        color: #dc3545;
        border: 2px solid #dc3545;
    }
    .btn-cancel:hover { background: #fff5f5; }
    
    .btn-back {
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255,255,255,0.5);
    }
    .btn-back:hover { background: rgba(255,255,255,0.1); }
</style>
@endpush

@section('content')
<div class="detail-header">
    Menunggu Pembayaran
</div>

<div class="detail-container">
    
    <div class="timer-box">
        <div class="timer-label">Selesaikan pembayaran dalam:</div>
        <div class="timer-text" id="countdown">--:--:--</div>
        <div style="font-size: 0.8rem; margin-top: 5px;">
            Batas: {{ \Carbon\Carbon::parse($order->payment_due_at)->format('d M Y, H:i') }}
        </div>
    </div>

    <div class="info-section">
        <div class="info-title">Rincian Pesanan</div>
        
        <div class="info-row">
            <span class="info-label">Order ID</span>
            <span class="info-value">#{{ $order->order_number }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Penerima</span>
            <span class="info-value">{{ $order->user->name }}</span>
        </div>
        
        <div class="info-row">
            <span class="info-label">Alamat</span>
            <span class="info-value" style="max-width: 60%; font-size: 0.85rem;">{{ $order->delivery_address }}</span>
        </div>

        <div style="margin: 15px 0; border-top: 1px dashed #ccc;"></div>

        <div class="info-row">
            <span class="info-label">Total Tagihan</span>
            <span class="info-value" style="color: #28a745; font-size: 1.3rem;">
                Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
            </span>
        </div>
    </div>

    <button id="pay-button" class="btn-action btn-pay">
        <i class="fa-solid fa-wallet"></i> Bayar Sekarang
    </button>

    <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
        @csrf
        @method('PUT')
        <button type="submit" class="btn-action btn-cancel">
            Batalkan Pesanan
        </button>
    </form>
    
    <a href="{{ route('dashboard') }}" class="btn-action btn-back" style="display:block; text-align:center; text-decoration:none;">
        Kembali ke Menu
    </a>

</div>
@endsection

@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    // 1. LOGIKA COUNTDOWN
    // Ambil waktu expired dari controller (format YYYY-MM-DD HH:mm:ss)
    const dueTime = new Date("{{ $order->payment_due_at }}").getTime();

    const x = setInterval(function() {
        const now = new Date().getTime();
        const distance = dueTime - now;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "EXPIRED";
            document.getElementById("pay-button").style.display = "none"; // Sembunyikan tombol bayar
            window.location.reload(); // Reload agar status terupdate
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Format 00:00:00
        document.getElementById("countdown").innerHTML = 
            (hours < 10 ? "0" + hours : hours) + ":" + 
            (minutes < 10 ? "0" + minutes : minutes) + ":" + 
            (seconds < 10 ? "0" + seconds : seconds);
    }, 1000);

    // 2. LOGIKA TOMBOL BAYAR (MIDTRANS)
    const payButton = document.querySelector('#pay-button');
    payButton.addEventListener('click', function(e) {
        e.preventDefault();

        window.snap.pay('{{ $snapToken }}', {
            // Jika Sukses
            onSuccess: function(result){
                // Redirect ke halaman sukses dengan membawa data json result
                window.location.href = "{{ route('order.success', $order->id) }}?payment_data=" + JSON.stringify(result);
            },
            // Jika Pending
            onPending: function(result){
                alert("Menunggu pembayaran!");
                console.log(result);
            },
            // Jika Error
            onError: function(result){
                alert("Pembayaran gagal!");
                console.log(result);
            },
            // Jika Ditutup
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endpush