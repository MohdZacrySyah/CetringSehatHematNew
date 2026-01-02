@extends('layouts.admin')

@section('title', 'Kelola Pesanan Masuk')

@section('content')
<div class="container px-6 mx-auto grid py-8">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">
                Daftar Pesanan
            </h2>
            <p class="text-gray-500 text-sm mt-1">Kelola semua pesanan masuk dari pelanggan.</p>
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" placeholder="Cari Order ID / Nama..." 
                    class="w-full py-2.5 pl-10 pr-4 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-[#556B2F] focus:ring-1 focus:ring-[#556B2F] transition-colors bg-white shadow-sm">
            </div>
            <button class="px-4 py-2.5 bg-white border border-gray-200 text-gray-600 rounded-xl text-sm font-semibold hover:bg-gray-50 hover:text-[#556B2F] transition-all shadow-sm flex items-center gap-2">
                <i class="fa-solid fa-filter"></i> 
                <span class="hidden sm:inline">Filter</span>
            </button>
        </div>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
        <div class="flex items-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-3 mr-4 text-[#556B2F] bg-[#f5f7ee] rounded-full">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="text-lg font-bold text-gray-700">{{ $orders->total() ?? 0 }}</p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-3 mr-4 text-orange-500 bg-orange-50 rounded-full">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Menunggu Bayar</p>
                <p class="text-lg font-bold text-gray-700">
                    {{ $orders->where('status', 'pending')->count() }}
                </p>
            </div>
        </div>
    </div>

    <div class="w-full overflow-hidden bg-white rounded-2xl shadow-lg border border-gray-100 ring-1 ring-black/5">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-bold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50/50">
                        <th class="px-6 py-4">Order Info</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Metode Bayar</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Total Bayar</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                    <tr class="text-gray-700 hover:bg-gray-50/80 transition-colors group">
                        
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800 text-sm">#{{ $order->order_number }}</span>
                                <span class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                    <i class="fa-regular fa-calendar"></i>
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm">
                                <div class="relative w-8 h-8 mr-3 rounded-full bg-[#556B2F] text-white flex items-center justify-center text-xs font-bold uppercase shadow-sm">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">{{ $order->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-2">
                                @if(in_array($order->payment_method, ['qris', 'gopay', 'dana', 'ovo', 'shopeepay']))
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                @elseif($order->payment_method == 'va')
                                    <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                @elseif($order->payment_method == 'cod')
                                    <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                                @else
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                @endif
                                <span class="capitalize text-gray-600 font-medium">
                                    {{ $order->payment_method ?? 'Manual' }}
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 text-xs">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
                                    'paid' => 'bg-green-100 text-green-700 border-green-200',
                                    'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'completed' => 'bg-teal-100 text-teal-700 border-teal-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $class = $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                
                                $statusLabel = [
                                    'pending' => 'Menunggu Bayar',
                                    'paid' => 'Lunas / Antre',
                                    'processing' => 'Sedang Dimasak',
                                    'shipped' => 'Sedang Diantar',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                                $label = $statusLabel[$order->status] ?? ucfirst($order->status);
                            @endphp
                            
                            <span class="px-3 py-1.5 font-semibold leading-tight rounded-full border {{ $class }} inline-flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ $label }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-sm font-bold text-gray-700 text-right">
                            Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="group/btn relative inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white transition-all duration-200 bg-[#556B2F] border border-transparent rounded-lg hover:bg-[#4A572A] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#556B2F]">
                                <span>Detail</span>
                                <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform duration-200 group-hover/btn:translate-x-1"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-clipboard-list text-3xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-500">Belum ada pesanan masuk</h3>
                                <p class="text-sm text-gray-400 mt-1">Pesanan baru dari pelanggan akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection