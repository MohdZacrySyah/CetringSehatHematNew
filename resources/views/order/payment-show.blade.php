@extends('layouts.app')
@section('title', 'Pembayaran - Catering Sehat Hemat')

@push('styles')
<style>
    body { background: #8B9D5E; margin: 0; min-height: 100vh; }
    .detail-container { max-width: 600px; margin: 20px auto; padding: 0 15px; }
    .info-card { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 15px; }
    .btn-action { width: 100%; padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; transition: 0.3s; border:none; margin-bottom: 10px; display: block; text-align: center; text-decoration: none; }
    .btn-pay { background: #28a745; color: white; }
    .btn-pay:hover { background: #218838; }
    .btn-cancel { background: #fff; color: #dc3545; border: 2px solid #dc3545; }
    .btn-cod { background: #e67e22; color: white; }
</style>
@endpush

@section('content')
<div class="text-center text-white font-bold text-lg p-4 bg-[#6B7D4A]">
    @if($order->payment_method == 'cod')
        Pesanan Diterima (COD)
    @else
        Selesaikan Pembayaran
    @endif
</div>

<div class="detail-container">

    @if($order->payment_method != 'cod')
        
        @php
            $sekarang = \Carbon\Carbon::now();
            $batasWaktu = \Carbon\Carbon::parse($order->payment_due_at);
            // Hitung selisih detik (bisa minus jika sudah lewat)
            $sisaDetik = $sekarang->diffInSeconds($batasWaktu, false);
        @endphp

        <div class="info-card text-center border-2 border-yellow-400 bg-yellow-50">
            <div class="text-sm text-yellow-800 mb-1">Sisa waktu pembayaran:</div>
            
            <div class="text-3xl font-mono font-bold text-red-600 tracking-wider" id="countdown">
                Memuat...
            </div>
            
            <div class="text-xs text-gray-500 mt-2">
                Batas Akhir: {{ $batasWaktu->format('d M Y, H:i') }}
            </div>
        </div>
    @else
        <div class="info-card text-center bg-orange-50 border border-orange-200">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3 text-orange-600">
                <i class="fa-solid fa-truck-fast text-2xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-800">Siapkan Uang Tunai</h2>
            <p class="text-gray-600 mt-2 text-sm px-4">
                Pesanan Anda telah masuk sistem. Mohon siapkan uang tunai pas saat kurir kami tiba di lokasi Anda.
            </p>
        </div>
    @endif

    <div class="info-card">
        <h3 class="font-bold border-b pb-2 mb-3 text-gray-700">Rincian Tagihan</h3>
        
        <div class="flex justify-between mb-2 text-sm">
            <span class="text-gray-500">Order ID</span>
            <span class="font-semibold">#{{ $order->order_number }}</span>
        </div>
        
        <div class="flex justify-between mb-2 text-sm">
            <span class="text-gray-500">Metode</span>
            <span class="font-bold uppercase text-[#556B2F]">{{ $order->payment_method }}</span>
        </div>

        <div class="flex justify-between mb-4 text-sm">
            <span class="text-gray-500">Alamat</span>
            <span class="text-right font-medium text-gray-700 max-w-[60%] line-clamp-2">
                {{ $order->delivery_address }}
            </span>
        </div>

        <div class="border-t pt-3 flex justify-between items-center">
            <span class="font-bold text-gray-700">Total Tagihan</span>
            <span class="font-bold text-2xl text-green-600">
                Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
            </span>
        </div>
    </div>

    @if($order->payment_method == 'cod')
        <a href="{{ route('dashboard') }}" class="btn-action btn-pay">
            <i class="fa-solid fa-check"></i> Selesai
        </a>
        <a href="{{ route('order.detail', $order->id) }}" class="btn-action bg-gray-100 text-gray-600 hover:bg-gray-200">
            Lihat Detail Pesanan
        </a>
    @else
        <div id="payment-buttons" style="{{ $sisaDetik <= 0 ? 'display:none' : '' }}">
            <button id="pay-button" class="btn-action btn-pay shadow-lg transform hover:-translate-y-1">
                <i class="fa-solid fa-wallet"></i> Bayar Sekarang
            </button>
        </div>

        <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan?');">
            @csrf @method('PUT')
            <button type="submit" class="btn-action btn-cancel mt-3">
                Batalkan Pesanan
            </button>
        </form>
    @endif

</div>
@endsection

@push('scripts')
@if($order->payment_method != 'cod')
    {{-- Pastikan Client Key benar --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        // --- 1. COUNTDOWN TIMER ---
        let remainingSeconds = parseInt("{{ $sisaDetik }}");

        function updateTimer() {
            if (remainingSeconds <= 0) {
                document.getElementById("countdown").innerHTML = "WAKTU HABIS";
                document.getElementById("countdown").classList.add("text-gray-500");
                const btnContainer = document.getElementById("payment-buttons");
                if(btnContainer) btnContainer.style.display = "none";
                return;
            }

            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;

            const h = hours < 10 ? "0" + hours : hours;
            const m = minutes < 10 ? "0" + minutes : minutes;
            const s = seconds < 10 ? "0" + seconds : seconds;

            document.getElementById("countdown").innerHTML = h + " : " + m + " : " + s;
            remainingSeconds--;
        }

        setInterval(updateTimer, 1000);
        updateTimer();

        // --- 2. LOGIC TOMBOL BAYAR (BAGIAN KRUSIAL) ---
        const payButton = document.querySelector('#pay-button');
        if(payButton) {
            payButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log("Membuka Snap..."); // Debugging
                
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result){
                        console.log("Sukses Midtrans:", result);
                        
                        // 🟢 FIX UTAMA: Enkripsi JSON agar tidak rusak di URL 🟢
                        let paymentJson = JSON.stringify(result);
                        let encodedJson = encodeURIComponent(paymentJson);

                        // Redirect dengan data yang aman
                        window.location.href = "{{ route('order.success', $order->id) }}?payment_data=" + encodedJson;
                    },
                    onPending: function(result){
                        alert("Menunggu pembayaran...");
                        location.reload();
                    },
                    onError: function(result){
                        console.error("Midtrans Error:", result);
                        alert("Pembayaran gagal!");
                        location.reload();
                    },
                    onClose: function(){
                        console.log("Popup ditutup user");
                    }
                });
            });
        }
    </script>
@endif
@endpush