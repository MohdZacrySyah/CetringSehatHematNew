@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pesanan: {{ $order->order_number }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="font-weight-bold" width="30%">Nama Pemesan</td>
                            <td>: {{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Email</td>
                            <td>: {{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Waktu Pesan</td>
                            <td>: {{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Metode Bayar</td>
                            <td>: {{ strtoupper($order->payment_method ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Status</td>
                            <td>: 
                                @if($order->status == 'paid')
                                    <span class="badge badge-success">Sudah Dibayar</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge badge-warning text-white">Sedang Dimasak</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-primary">Selesai/Diantar</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-danger">Dibatalkan</span>
                                @else
                                    <span class="badge badge-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    {{-- Form Update Status di Halaman Detail --}}
                    <h6 class="font-weight-bold">Update Status:</h6>
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="form-inline">
                        @csrf
                        @method('PUT')
                        <select name="status" class="form-control mb-2 mr-sm-2">
                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Bayar)</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Masak)</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                        </select>
                        <button type="submit" class="btn btn-primary mb-2">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Menu</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Menu</th>
                                    <th class="text-center">Jml</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $item->menu_name }}</div>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light font-weight-bold">
                                <tr>
                                    <td colspan="3" class="text-right">Subtotal</td>
                                    <td class="text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Biaya Aplikasi</td>
                                    <td class="text-right">Rp {{ number_format($order->biaya_aplikasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="text-primary" style="font-size: 1.1em;">
                                    <td colspan="3" class="text-right">TOTAL BAYAR</td>
                                    <td class="text-right">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->customer_notes)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Catatan Pelanggan</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 font-italic">"{{ $order->customer_notes }}"</p>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection