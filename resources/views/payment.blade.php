@extends('layouts.app')

@section('content')
<h2>Konfirmasi Pembayaran</h2>

<p>Order: {{ $order->order_number }}</p>
<p>Total: Rp {{ number_format($order->total_bayar,0,',','.') }}</p>

<button id="pay-button">Bayar Sekarang</button>

<script 
  src="https://app.sandbox.midtrans.com/snap/snap.js"
  data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.getElementById('pay-button').addEventListener('click', function () {
    snap.pay('{{ $snapToken }}', {
        onSuccess: function () {
            window.location.href = '/orders/success';
        },
        onPending: function () {
            alert('Menunggu pembayaran');
        },
        onError: function () {
            alert('Pembayaran gagal');
        }
    });
});
</script>
@endsection
