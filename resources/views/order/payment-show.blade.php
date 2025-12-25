@extends('layouts.app')
@section('title', 'Pembayaran')

@push('styles')
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}">
</script>
@endpush

@section('content')
<div class="py-12">
    <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center" style="margin-top: 50px; border: 1px solid #ddd;">
            
            <h2 class="text-2xl font-bold mb-4" style="color: #4A572A;">Konfirmasi Pembayaran</h2>
            <p class="mb-2">No. Order: <strong>{{ $order->order_number }}</strong></p>
            
            <div style="margin: 20px 0; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                <p>Total yang harus dibayar:</p>
                <h1 style="font-size: 2rem; color: #6B8E23; font-weight: bold;">
                    Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                </h1>
            </div>
            
            <button id="pay-button" style="background-color: #4A572A; color: white; padding: 15px 40px; border: none; border-radius: 8px; font-size: 1.1rem; font-weight: bold; cursor: pointer; width: 100%;">
                BAYAR SEKARANG
            </button>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    
    payButton.addEventListener('click', function () {
        // Trigger Popup Midtrans
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                // KITA TANGKAP HASIL JSON DARI MIDTRANS
                // Dan kirimkan datanya ke URL success via Query String
                var resultString = JSON.stringify(result);
                window.location.href = "{{ route('order.success', $order->id) }}?payment_data=" + encodeURIComponent(resultString);
            },
            onPending: function(result){
                alert("Menunggu pembayaran!");
                location.reload();
            },
            onError: function(result){
                alert("Pembayaran gagal!");
                location.reload();
            },
            onClose: function(){
                alert('Anda menutup popup tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endpush