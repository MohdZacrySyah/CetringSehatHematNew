@extends('layouts.admin') {{-- Sesuaikan dengan layout admin Anda --}}
@section('title', 'Kelola Pesanan')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 font-bold text-xl">Daftar Pesanan Masuk</h2>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white p-4">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr>
                    <th class="px-6 py-3">No Order</th>
                    <th class="px-6 py-3">Pemesan</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status Saat Ini</th>
                    <th class="px-6 py-3">Aksi (Ubah Status)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-6 py-4 font-bold">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        {{ $order->user->name }}<br>
                        <span class="text-xs text-gray-400">{{ $order->created_at->format('d M Y H:i') }}</span>
                    </td>
                    <td class="px-6 py-4">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($order->status == 'paid')
                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Sudah Dibayar</span>
                        @elseif($order->status == 'processing')
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">Sedang Dimasak</span>
                        @elseif($order->status == 'completed')
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Selesai</span>
                        @else
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ $order->status }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        {{-- FORM UBAH STATUS --}}
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PUT')
                            <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2">
                                <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Proses (Masak)</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Antar)</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                            </select>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection