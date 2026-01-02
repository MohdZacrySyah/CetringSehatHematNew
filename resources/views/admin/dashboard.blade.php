@extends('layouts.admin')

@section('title', 'Dashboard Ringkasan')

@section('content')
<div class="container px-6 mx-auto grid py-8">
    
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">
            Dashboard Overview
        </h2>
        <p class="text-gray-500 text-sm mt-1">
            Halo Admin, inilah ringkasan performa catering hari ini.
        </p>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-3">
        
        <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-4 mr-4 text-white bg-[#556B2F] rounded-full shadow-lg shadow-[#556B2F]/30">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $totalOrders }}
                </p>
                <span class="text-xs text-green-600 bg-green-100 px-2 py-0.5 rounded-full font-semibold">
                    <i class="fa-solid fa-arrow-up mr-1"></i> Data Masuk
                </span>
            </div>
        </div>

        <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-4 mr-4 text-white bg-emerald-500 rounded-full shadow-lg shadow-emerald-500/30">
                <i class="fas fa-coins text-2xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Estimasi Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800">
                    Rp {{ number_format($revenue, 0, ',', '.') }}
                </p>
                <span class="text-xs text-gray-400">Total akumulasi</span>
            </div>
        </div>

        <div class="flex items-center p-6 bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
            <div class="p-4 mr-4 text-white bg-orange-500 rounded-full shadow-lg shadow-orange-500/30">
                <i class="fas fa-utensils text-2xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Menu Aktif</p>
                <p class="text-2xl font-bold text-gray-800">
                    {{ $totalMenus }}
                </p>
                <span class="text-xs text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full font-semibold">
                    Siap Dipesan
                </span>
            </div>
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-2xl shadow-lg bg-white border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                <i class="fa-regular fa-clock text-[#556B2F]"></i> 
                5 Pesanan Terbaru
            </h3>
            <a href="{{ route('admin.orders') }}" class="text-sm font-semibold text-[#556B2F] hover:underline">
                Lihat Semua &rarr;
            </a>
        </div>

        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-white">
                        <th class="px-6 py-4">No. Order</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4 text-right">Total</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($recentOrders as $order)
                    <tr class="text-gray-700 hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-gray-800">#{{ $order->order_number }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center text-sm">
                                <div class="relative w-8 h-8 mr-3 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold uppercase text-xs">
                                    {{ substr($order->user->name ?? 'G', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-700">{{ $order->user->name ?? 'Guest' }}</p>
                                    <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm font-bold text-gray-700 text-right">
                            Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-xs">
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'bg-orange-100 text-orange-700 border-orange-200',
                                    'paid' => 'bg-green-100 text-green-700 border-green-200',
                                    'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'shipped' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'completed' => 'bg-teal-100 text-teal-700 border-teal-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                                
                                $statusLabel = match($order->status) {
                                    'pending' => 'Menunggu Bayar',
                                    'paid' => 'Dibayar',
                                    'processing' => 'Dimasak',
                                    'shipped' => 'Diantar',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Batal',
                                    default => ucfirst($order->status)
                                };
                            @endphp
                            <span class="px-3 py-1 font-semibold leading-tight rounded-full border {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="text-gray-400 hover:text-[#556B2F] transition-colors p-2 rounded-full hover:bg-gray-100" 
                               title="Lihat Detail">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data pesanan terbaru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection