@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid">

    <div class="mb-4">
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
    </div>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pesanan: {{ $order->order_number }}</h1>
    </div>

    <div class="row">
        
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pelanggan</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td class="fw-bold text-gray-600" width="35%">Nama Pemesan</td>
                            <td>: {{ $order->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-gray-600">Email</td>
                            <td>: {{ $order->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-gray-600">Waktu Pesan</td>
                            <td>: {{ $order->created_at->format('d M Y, H:i') }} WIB</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-gray-600">Metode Bayar</td>
                            <td>: <span class="badge bg-secondary">{{ strtoupper(str_replace('_', ' ', $order->payment_method ?? '-')) }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-gray-600">Status Saat Ini</td>
                            <td>: 
                                @if($order->status == 'paid')
                                    <span class="badge bg-success">Sudah Dibayar</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-warning text-dark">Sedang Dimasak</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-primary">Selesai/Diantar</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <hr>

                    <div class="p-3 bg-light rounded border">
                        <label class="fw-bold text-dark mb-2">Update Status Pesanan:</label>
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <select name="status" class="form-select">
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Sudah Bayar)</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing (Masak)</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Batal)</option>
                                </select>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            
            @if($order->customer_notes)
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning">Catatan Pelanggan</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0 font-italic text-gray-700">"{{ $order->customer_notes }}"</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rincian Menu Dipesan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr class="text-center">
                                    <th>Menu</th>
                                    <th>Jml</th>
                                    <th>Harga</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="align-middle">
                                        <div class="fw-bold">{{ $item->menu_name }}</div>
                                    </td>
                                    <td class="text-center align-middle">{{ $item->quantity }}</td>
                                    <td class="text-end align-middle">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end align-middle fw-bold">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Subtotal</td>
                                    <td class="text-end">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">Biaya Aplikasi</td>
                                    <td class="text-end">Rp {{ number_format($order->biaya_aplikasi, 0, ',', '.') }}</td>
                                </tr>
                                <tr class="table-primary" style="font-size: 1.1em;">
                                    <td colspan="3" class="text-end fw-bold text-primary">TOTAL BAYAR</td>
                                    <td class="text-end fw-bold text-primary">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection