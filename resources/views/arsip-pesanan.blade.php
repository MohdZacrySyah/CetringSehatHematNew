@extends('layouts.app')
@section('title', 'Arsip Pesanan')

@push('styles')
<style>
    /* Styling tambahan untuk status badge */
    .badge { padding: 4px 10px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; display: inline-flex; align-items: center; gap: 5px; }
    .badge-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
    .badge-paid { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .badge-process { background: #cce5ff; color: #004085; border: 1px solid #b8daff; }
    .badge-done { background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
    .badge-cancel { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-[#4A572A]">Pesanan Saya</h1>
        <p class="text-gray-500 text-sm">Riwayat dan status pesanan Anda.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                
                <div class="bg-gray-50 px-5 py-3 border-b border-gray-100 flex justify-between items-center">
                    <div>
                        <span class="font-bold text-gray-700">#{{ $order->order_number }}</span>
                        <span class="text-xs text-gray-400 ml-2">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    
                    @php
                        $status = $order->status;
                        if($status == 'pending') {
                            $badgeClass = 'badge-pending';
                            $statusText = 'Menunggu Pembayaran';
                            $icon = 'fa-clock';
                        } elseif($status == 'paid') {
                            $badgeClass = 'badge-paid';
                            $statusText = 'Dibayar / Diproses';
                            $icon = 'fa-check-circle';
                        } elseif($status == 'processing') {
                            $badgeClass = 'badge-process';
                            $statusText = 'Sedang Dimasak';
                            $icon = 'fa-fire-burner';
                        } elseif($status == 'shipped') {
                            $badgeClass = 'badge-process';
                            $statusText = 'Dalam Pengantaran';
                            $icon = 'fa-motorcycle';
                        } elseif($status == 'completed') {
                            $badgeClass = 'badge-done';
                            $statusText = 'Selesai';
                            $icon = 'fa-flag-checkered';
                        } else {
                            $badgeClass = 'badge-cancel';
                            $statusText = 'Dibatalkan';
                            $icon = 'fa-ban';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }}">
                        <i class="fa-solid {{ $icon }}"></i> {{ $statusText }}
                    </span>
                </div>

                <div class="p-5 flex flex-col sm:flex-row gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            @if($order->items->first() && $order->items->first()->menu_image)
                                <img src="{{ asset('storage/' . $order->items->first()->menu_image) }}" class="w-full h-full object-cover rounded-lg">
                            @else
                                <i class="fa-solid fa-utensils text-2xl"></i>
                            @endif
                        </div>
                    </div>

                    <div class="flex-1">
                        <h3 class="font-bold text-gray-800 text-sm sm:text-base">
                            {{ $order->items->first()->menu_name ?? 'Menu Item' }}
                            @if($order->items->count() > 1)
                                <span class="text-gray-500 font-normal text-xs">(+{{ $order->items->count() - 1 }} menu lainnya)</span>
                            @endif
                        </h3>
                        
                        <p class="text-xs text-gray-500 mt-1">
                            Metode: <span class="uppercase font-semibold">{{ $order->payment_method }}</span>
                        </p>
                        
                        <p class="text-[#556B2F] font-bold mt-2">
                            Total: Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                        </p>
                    </div>

                    <div class="flex flex-col gap-2 justify-center min-w-[140px]">
                        
                        @if($order->status == 'pending')
                            
                            <a href="{{ route('order.payment.show', $order->id) }}" 
                               class="bg-[#556B2F] hover:bg-[#4A572A] text-white text-center py-2 rounded-lg text-sm font-semibold transition-colors shadow-sm">
                                <i class="fa-solid fa-wallet mr-1"></i> Bayar
                            </a>

                            <form action="{{ route('order.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full border border-red-500 text-red-500 hover:bg-red-50 text-center py-2 rounded-lg text-sm font-semibold transition-colors">
                                    Batalkan
                                </button>
                            </form>

                        @else
                            <a href="{{ route('order.detail', $order->id) }}" 
                               class="border border-gray-300 text-gray-600 hover:bg-gray-50 text-center py-2 rounded-lg text-sm font-semibold transition-colors">
                                Lihat Detail
                            </a>
                        @endif

                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <i class="fa-regular fa-clipboard text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-600">Belum ada pesanan</h3>
                <p class="text-gray-400 text-sm mt-1">Yuk, mulai pesan makanan favoritmu sekarang!</p>
                <a href="{{ url('/menu') }}" class="inline-block mt-4 text-[#556B2F] font-semibold hover:underline">
                    Lihat Menu
                </a>
            </div>
        @endforelse

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection