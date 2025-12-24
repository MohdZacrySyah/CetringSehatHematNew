@extends('layouts.admin')

@section('header')
    Daftar Pesanan Masuk
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        
        <h3 class="text-lg font-bold mb-4">Riwayat Pesanan</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm uppercase tracking-wider">
                        <th class="border p-3">No. Order</th>
                        <th class="border p-3">Pelanggan</th>
                        <th class="border p-3">Total Bayar</th>
                        <th class="border p-3">Status</th>
                        <th class="border p-3">Tanggal</th>
                        <th class="border p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border p-3 font-medium">{{ $order->order_number }}</td>
                        <td class="border p-3">{{ $order->user->name ?? 'User Terhapus' }}</td>
                        <td class="border p-3">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        <td class="border p-3">
                            @if($order->status == 'pending')
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs">Menunggu Bayar</span>
                            @elseif($order->status == 'paid' || $order->status == 'processing')
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">Diproses</span>
                            @elseif($order->status == 'completed')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">Selesai</span>
                            @elseif($order->status == 'cancelled')
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Dibatalkan</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td class="border p-3">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="border p-3 text-center">
                           <a href="{{ route('admin.orders.show', $order->id) }}" class="text-blue-600 hover:text-blue-900 font-bold bg-blue-50 px-3 py-1 rounded">
    Lihat Detail
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="border p-6 text-center text-gray-500">
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection