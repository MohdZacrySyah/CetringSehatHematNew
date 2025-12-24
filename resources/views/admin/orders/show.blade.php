@extends('layouts.admin')

@section('header')
    Detail Pesanan #{{ $order->order_number }}
@endsection

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Item Pesanan</h3>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-sm border-b">
                            <th class="pb-3">Menu</th>
                            <th class="pb-3">Harga</th>
                            <th class="pb-3">Jumlah</th>
                            <th class="pb-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($order->items as $item)
                        <tr class="border-b last:border-0">
                            <td class="py-4 flex items-center">
                                @if($item->menu && $item->menu->image)
                                    <img src="{{ asset('storage/' . $item->menu->image) }}" class="w-12 h-12 object-cover rounded mr-3">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded mr-3"></div>
                                @endif
                                <div>
                                    <p class="font-medium">{{ $item->menu_name }}</p>
                                    @if($item->menu)
                                        <p class="text-xs text-gray-500">{{ $item->menu->category }}</p>
                                    @else
                                        <span class="text-xs text-red-500">(Menu Terhapus)</span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="py-4">x {{ $item->quantity }}</td>
                            <td class="py-4 text-right font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="3" class="pt-4 text-right font-bold text-gray-600">Subtotal</td>
                            <td class="pt-4 text-right font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="pt-2 text-right text-gray-600">Biaya Pengiriman</td>
                            <td class="pt-2 text-right">Rp {{ number_format($order->biaya_pengiriman, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="pt-2 text-right text-lg font-bold text-gray-800">Total Bayar</td>
                            <td class="pt-2 text-right text-lg font-bold text-green-600">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="md:col-span-1 space-y-6">
            
            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Status Pesanan</h3>
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-2">Update Status:</label>
                        <select name="status" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Bayar</option>
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Sedang Dimasak/Diproses</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Diantar)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 font-medium">
                        Simpan Perubahan
                    </button>
                </form>

                <div class="mt-4 pt-4 border-t text-sm text-gray-600">
                    <p class="flex justify-between"><span>Tanggal Order:</span> <span class="font-medium">{{ $order->created_at->format('d M Y') }}</span></p>
                    <p class="flex justify-between mt-2"><span>Jam:</span> <span class="font-medium">{{ $order->created_at->format('H:i') }}</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow border border-gray-100">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Data Pelanggan</h3>
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-gray-500 font-bold text-lg mr-3">
                        {{ substr($order->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold">{{ $order->user->name ?? 'User Terhapus' }}</p>
                        <p class="text-sm text-gray-500">{{ $order->user->email ?? '-' }}</p>
                    </div>
                </div>
                
                @if($order->customer_notes)
                <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-sm text-yellow-800">
                    <span class="font-bold block mb-1">Catatan Pesanan:</span>
                    "{{ $order->customer_notes }}"
                </div>
                @endif
            </div>

        </div>
    </div>
@endsection