@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Daftar Pesanan Masuk</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
        </div>
        <div class="card-body">
            
            {{-- Table Responsive: Agar bisa discroll di HP --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                    <thead class="table-dark">
                        <tr class="text-center align-middle">
                            <th>No Order</th>
                            <th>Pemesan</th>
                            <th>Total</th>
                            <th>Status Saat Ini</th>
                            <th style="min-width: 200px;">Aksi (Ubah Status)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="font-weight-bold align-middle">{{ $order->order_number }}</td>
                            <td class="align-middle">
                                <div class="fw-bold">{{ $order->user->name }}</div>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> {{ $order->created_at->format('d M Y H:i') }}
                                </small>
                            </td>
                            <td class="align-middle">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                            <td class="align-middle text-center">
                                @if($order->status == 'paid')
                                    <span class="badge bg-success p-2">Sudah Dibayar</span>
                                @elseif($order->status == 'processing')
                                    <span class="badge bg-warning text-dark p-2">Sedang Dimasak</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge bg-primary p-2">Selesai/Diantar</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge bg-danger p-2">Dibatalkan</span>
                                @else
                                    <span class="badge bg-secondary p-2">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{-- FORM UPDATE STATUS --}}
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Proses (Masak)</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai (Antar)</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                    <div class="mt-1 text-center">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="text-decoration-none small">
                                            <i class="fas fa-eye"></i> Lihat Detail
                                        </a>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-end">
                {{ $orders->links() }}
            </div>

        </div>
    </div>

</div>
@endsection