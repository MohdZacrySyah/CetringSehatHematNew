@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Statistik Ringkas</h1>
    </div>

    <div class="row">

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pesanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Estimasi Pendapatan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Menu Tersedia</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMenus }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">5 Pesanan Terbaru</h6>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        {{-- TABLE RESPONSIVE + TEXT NOWRAP AGAR RAPI --}}
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No. Order</th>
                                        <th>Pelanggan</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th class="text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td class="font-weight-bold align-middle">{{ $order->order_number }}</td>
                                        <td class="align-middle">
                                            {{ $order->user->name ?? 'Guest' }}<br>
                                            <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                                        </td>
                                        <td class="align-middle">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                                        <td class="align-middle">
                                            @if($order->status == 'pending')
                                                <span class="badge badge-warning text-white">Pending</span>
                                            @elseif($order->status == 'paid')
                                                <span class="badge badge-success">Sudah Dibayar</span>
                                            @elseif($order->status == 'processing')
                                                <span class="badge badge-info text-white">Sedang Dimasak</span>
                                            @elseif($order->status == 'completed')
                                                <span class="badge badge-primary">Selesai</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-right">
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary shadow-sm">
                                                <i class="fas fa-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            Belum ada pesanan masuk.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection