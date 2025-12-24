@extends('layouts.admin')

@section('header')
    Statistik Ringkas
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Pesanan</h4>
            <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalOrders }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Estimasi Pendapatan</h4>
            <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($revenue, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
            <h4 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Menu Tersedia</h4>
            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $totalMenus }}</p>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-bold mb-4">5 Pesanan Terbaru</h3>
            
            @if($recentOrders->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-medium">
                            <tr>
                                <th class="p-3">No. Order</th>
                                <th class="p-3">Pelanggan</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($recentOrders as $order)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 font-medium">{{ $order->order_number }}</td>
                                <td class="p-3">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="p-3">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-3">
                                    @if($order->status == 'pending')
                                        <span class="text-yellow-600 font-bold text-xs bg-yellow-100 px-2 py-1 rounded">Pending</span>
                                    @elseif($order->status == 'paid' || $order->status == 'processing')
                                        <span class="text-blue-600 font-bold text-xs bg-blue-100 px-2 py-1 rounded">Proses</span>
                                    @elseif($order->status == 'completed')
                                        <span class="text-green-600 font-bold text-xs bg-green-100 px-2 py-1 rounded">Selesai</span>
                                    @else
                                        <span class="text-gray-600 font-bold text-xs bg-gray-100 px-2 py-1 rounded">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada pesanan masuk.</p>
            @endif
        </div>
    </div>
@endsection