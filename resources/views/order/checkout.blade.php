@extends('layouts.app')
@section('title', 'Checkout - Catering Sehat Hemat')

@push('styles')
<style>
    /* Styling khusus untuk Radio Button Pembayaran */
    .payment-radio:checked + div {
        border-color: #556B2F;
        background-color: #f5f7ee;
        color: #4A572A;
        box-shadow: 0 4px 6px -1px rgba(85, 107, 47, 0.1), 0 2px 4px -1px rgba(85, 107, 47, 0.06);
    }
    .payment-radio:checked + div .check-icon {
        opacity: 1;
        transform: scale(1);
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #c2d5a0;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #879b55;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-10 max-w-6xl">
    
    <div class="mb-8 pl-1">
        <h1 class="text-3xl font-bold text-[#4A572A]">Checkout Pengiriman</h1>
        <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
            <span>Keranjang</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span class="text-[#556B2F] font-semibold">Konfirmasi & Bayar</span>
            <i class="fa-solid fa-chevron-right text-xs"></i>
            <span>Selesai</span>
        </div>
    </div>

    <form action="{{ route('order.process') }}" method="POST" id="checkout-form" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        
        <div class="lg:col-span-7 space-y-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#879b55]"></div>
                
                <div class="flex items-center gap-3 mb-5 border-b pb-3 border-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#f5f7ee] flex items-center justify-center text-[#556B2F] shadow-sm">
                        <i class="fa-solid fa-location-dot text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Alamat Pengiriman</h3>
                        <p class="text-xs text-gray-400">Pastikan alamat Anda benar</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                     <label class="block text-sm font-medium text-gray-700 ml-1">Detail Alamat Lengkap</label>
                     <textarea name="delivery_address" rows="3" required
                        class="w-full border-gray-300 rounded-xl shadow-sm focus:border-[#556B2F] focus:ring focus:ring-[#556B2F]/20 transition-all p-4 text-gray-700 placeholder-gray-400"
                        placeholder="Nama Jalan, Nomor Rumah, RT/RW, Patokan...">{{ $user->address ?? '' }}</textarea>
                     <div class="flex items-start gap-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        <i class="fa-solid fa-circle-info mt-0.5 text-[#556B2F]"></i> 
                        <span>Alamat yang jelas membantu kurir kami mengantar makanan lebih cepat.</span>
                     </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#c2d5a0]"></div>

                 <div class="flex items-center gap-3 mb-5 border-b pb-3 border-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#f5f7ee] flex items-center justify-center text-[#556B2F] shadow-sm">
                        <i class="fa-solid fa-note-sticky text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Catatan Pesanan</h3>
                        <p class="text-xs text-gray-400">Opsional</p>
                    </div>
                </div>
                
                <div class="relative">
                    <i class="fa-solid fa-pen absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="text" name="customer_notes"
                        class="w-full pl-10 border-gray-300 rounded-xl shadow-sm focus:border-[#556B2F] focus:ring focus:ring-[#556B2F]/20 py-3"
                        placeholder="Contoh: Jangan terlalu pedas, saus dipisah...">
                </div>
            </div>

             <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#4A572A]"></div>

                <div class="flex items-center gap-3 mb-5 border-b pb-3 border-gray-50">
                    <div class="w-10 h-10 rounded-full bg-[#f5f7ee] flex items-center justify-center text-[#556B2F] shadow-sm">
                        <i class="fa-solid fa-wallet text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg text-gray-800">Metode Pembayaran</h3>
                        <p class="text-xs text-gray-400">Pilih salah satu metode di bawah</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="qris" class="peer sr-only payment-radio" checked>
                        <div class="p-4 rounded-xl border border-gray-200 hover:border-[#556B2F] transition-all flex items-center gap-4 group-hover:bg-[#f5f7ee]/50 bg-white h-full">
                            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-qrcode text-lg"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800 text-sm">QRIS</div>
                                <div class="text-[11px] text-gray-500 leading-tight mt-0.5">Scan Barcode (Semua E-Wallet & Bank)</div>
                            </div>
                            <i class="fa-solid fa-circle-check absolute top-3 right-3 text-[#556B2F] opacity-0 transition-all check-icon text-lg"></i>
                        </div>
                    </label>

                     <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="gopay" class="peer sr-only payment-radio">
                        <div class="p-4 rounded-xl border border-gray-200 hover:border-[#556B2F] transition-all flex items-center gap-4 group-hover:bg-[#f5f7ee]/50 bg-white h-full">
                            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-wallet text-lg"></i>
                            </div>
                             <div>
                                <div class="font-bold text-gray-800 text-sm">E-Wallet</div>
                                <div class="text-[11px] text-gray-500 leading-tight mt-0.5">GoPay, Dana, OVO, ShopeePay</div>
                            </div>
                             <i class="fa-solid fa-circle-check absolute top-3 right-3 text-[#556B2F] opacity-0 transition-all check-icon text-lg"></i>
                        </div>
                    </label>

                     <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="va" class="peer sr-only payment-radio">
                        <div class="p-4 rounded-xl border border-gray-200 hover:border-[#556B2F] transition-all flex items-center gap-4 group-hover:bg-[#f5f7ee]/50 bg-white h-full">
                            <div class="w-10 h-10 bg-purple-50 text-purple-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-building-columns text-lg"></i>
                            </div>
                             <div>
                                <div class="font-bold text-gray-800 text-sm">Transfer Bank</div>
                                <div class="text-[11px] text-gray-500 leading-tight mt-0.5">Virtual Account (BCA, BRI, Mandiri)</div>
                            </div>
                             <i class="fa-solid fa-circle-check absolute top-3 right-3 text-[#556B2F] opacity-0 transition-all check-icon text-lg"></i>
                        </div>
                    </label>

                     <label class="relative cursor-pointer group">
                        <input type="radio" name="payment_method" value="cod" class="peer sr-only payment-radio">
                        <div class="p-4 rounded-xl border border-gray-200 hover:border-[#556B2F] transition-all flex items-center gap-4 group-hover:bg-[#f5f7ee]/50 bg-white h-full">
                            <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-hand-holding-dollar text-lg"></i>
                            </div>
                             <div>
                                <div class="font-bold text-gray-800 text-sm">COD</div>
                                <div class="text-[11px] text-gray-500 leading-tight mt-0.5">Bayar Tunai saat pesanan sampai</div>
                            </div>
                             <i class="fa-solid fa-circle-check absolute top-3 right-3 text-[#556B2F] opacity-0 transition-all check-icon text-lg"></i>
                        </div>
                    </label>
                </div>
            </div>

        </div>

        <div class="lg:col-span-5">
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-[#c2d5a0]/40 sticky top-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-bold text-xl text-[#4A572A]">Ringkasan</h3>
                    <span class="text-xs font-semibold text-white bg-[#879b55] px-2.5 py-1 rounded-full">{{ $carts->count() }} Item</span>
                </div>

                <div class="space-y-4 mb-6 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                    @foreach($carts as $cart)
                    <div class="flex gap-4 items-start pb-4 border-b border-dashed border-gray-100 last:border-0 last:pb-0">
                        <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex-shrink-0 shadow-sm">
                             <img src="{{ asset($cart->menu->image) }}" alt="{{ $cart->menu->name }}" class="w-full h-full object-cover">
                        </div>
                        
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-bold text-gray-800 line-clamp-2">{{ $cart->menu->name }}</div>
                            <div class="flex justify-between items-center mt-1">
                                <div class="text-xs text-gray-500 bg-gray-50 px-2 py-0.5 rounded border border-gray-100">
                                    {{ $cart->quantity }} x Rp {{ number_format($cart->menu->price, 0, ',', '.') }}
                                </div>
                                <div class="text-sm font-bold text-[#556B2F]">
                                    Rp {{ number_format($cart->menu->price * $cart->quantity, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="bg-[#fcfdf9] rounded-xl p-4 border border-[#eef2e6] space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Pengiriman</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($biayaPengiriman, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Aplikasi</span>
                        <span class="font-semibold text-gray-800">Rp {{ number_format($biayaAplikasi, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="border-t border-dashed border-gray-300 my-2 pt-2">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-[#4A572A] text-lg">Total Bayar</span>
                            <span class="font-extrabold text-2xl text-[#556B2F]">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <button type="submit" form="checkout-form" 
                    class="w-full mt-6 bg-gradient-to-r from-[#556B2F] to-[#4A572A] hover:from-[#4A572A] hover:to-[#3e4a23] text-white font-bold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 flex justify-center items-center gap-2 group">
                    <span>Buat Pesanan Sekarang</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <div class="flex items-center justify-center gap-2 mt-4 text-[10px] text-gray-400">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Pembayaran Aman & Terenkripsi</span>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection