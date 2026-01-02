@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="container px-6 mx-auto grid mb-10">
    <div class="flex justify-between items-center my-6">
        <h2 class="text-2xl font-semibold text-gray-700">
            Detail Pesanan <span class="text-[#556B2F]">#{{ $order->order_number }}</span>
        </h2>
        <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2">
        
        <div class="min-w-0 p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h4 class="mb-4 font-semibold text-gray-600 border-b pb-2">
                <i class="fa-solid fa-truck mr-2"></i> Informasi Pengiriman
            </h4>
            
            <div class="mb-4">
                <span class="block text-sm text-gray-400">Nama Penerima</span>
                <span class="font-bold text-gray-800 text-lg">{{ $order->user->name }}</span>
            </div>

            <div class="mb-4">
                <span class="block text-sm text-gray-400">Alamat Lengkap</span>
                <p class="text-gray-800 bg-gray-50 p-3 rounded border border-gray-100 mt-1">
                    {{ $order->delivery_address }}
                </p>
            </div>

            <div class="mb-4">
                <span class="block text-sm text-gray-400">Catatan Customer</span>
                @if($order->customer_notes)
                    <p class="text-orange-700 bg-orange-50 p-3 rounded border border-orange-100 mt-1 font-medium">
                        "{{ $order->customer_notes }}"
                    </p>
                @else
                    <span class="text-gray-400 italic">- Tidak ada catatan -</span>
                @endif
            </div>
            
             <div class="mb-2">
                <span class="block text-sm text-gray-400">Kontak</span>
                <span class="text-gray-800">{{ $order->user->phone ?? '-' }} ({{ $order->user->email }})</span>
            </div>
        </div>

        <div class="min-w-0 p-6 bg-white rounded-lg shadow-sm border border-gray-200">
            <h4 class="mb-4 font-semibold text-gray-600 border-b pb-2">
                <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Status & Pembayaran
            </h4>

            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500">Status Saat Ini:</span>
                @if($order->status == 'pending')
                    <span class="px-3 py-1 font-bold text-orange-700 bg-orange-100 rounded-full">Menunggu Pembayaran</span>
                @elseif($order->status == 'paid')
                    <span class="px-3 py-1 font-bold text-green-700 bg-green-100 rounded-full">Lunas / Diproses</span>
                @elseif($order->status == 'cancelled')
                    <span class="px-3 py-1 font-bold text-red-700 bg-red-100 rounded-full">Dibatalkan</span>
                @else
                    <span class="px-3 py-1 font-bold text-gray-700 bg-gray-100 rounded-full">{{ ucfirst($order->status) }}</span>
                @endif
            </div>

            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500">Metode Bayar:</span>
                <span class="font-bold uppercase">{{ $order->payment_method }}</span>
            </div>
            
            <div class="border-t border-dashed my-4 pt-4">
                <div class="flex justify-between text-lg font-bold text-[#556B2F]">
                    <span>Total Order:</span>
                    <span>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($order->status != 'cancelled')
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="mt-6">
                @csrf
                @method('PUT')
                <label class="block text-sm text-gray-700 mb-2">Update Status:</label>
                <div class="flex gap-2">
                    <select name="status" class="block w-full text-sm form-select border-gray-300 rounded-md focus:border-[#556B2F] focus:ring-[#556B2F]">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid / Proses</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batalkan</option>
                    </select>
                    <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white bg-[#556B2F] rounded-lg hover:bg-[#4A572A]">
                        Update
                    </button>
                </div>
            </form>
            @else
                <div class="mt-6 p-4 bg-red-50 text-red-700 rounded text-center text-sm font-bold border border-red-100">
                    Order ini telah dibatalkan oleh Pengguna/Sistem.
                </div>
            @endif
        </div>
    </div>

    <div class="w-full overflow-hidden rounded-lg shadow-sm border border-gray-200 bg-white">
        <div class="p-4 bg-gray-50 border-b font-semibold text-gray-600">
            Daftar Menu yang Dipesan
        </div>
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50">
                        <th class="px-4 py-3">Menu</th>
                        <th class="px-4 py-3 text-center">Jumlah</th>
                        <th class="px-4 py-3 text-right">Harga Satuan</th>
                        <th class="px-4 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y">
                    @foreach($order->items as $item)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-12 h-12 mr-3 rounded md:block">
                                    <img class="object-cover w-full h-full rounded" src="{{ asset($item->menu_image) }}" alt="" loading="lazy" />
                                </div>
                                <div>
                                    <p class="font-semibold">{{ $item->menu_name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-4 py-3 text-sm text-right">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-right font-bold">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection