@extends('layouts.admin')

@section('title', 'Daftar Ulasan Pelanggan')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Ulasan Masuk</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Ulasan & Rating</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Order ID</th>
                            <th>Rating</th>
                            <th>Ulasan</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="font-weight-bold">{{ $review->user->name }}</div>
                                <small class="text-muted">{{ $review->user->email }}</small>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $review->order_id) }}" target="_blank">
                                    {{ $review->order->order_number ?? '-' }}
                                </a>
                            </td>
                            <td>
                                <span class="text-warning font-weight-bold" style="font-size: 1.1rem;">
                                    {{ $review->rating }} <i class="fas fa-star"></i>
                                </span>
                            </td>
                            <td>
                                <div class="font-italic text-gray-600 mb-1">"{{ $review->question }}"</div>
                                <div>{{ $review->review_text }}</div>
                            </td>
                            <td>
                                @if($review->media_path)
                                    <a href="{{ asset('storage/' . $review->media_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $review->media_path) }}" alt="Foto" width="50" class="rounded border">
                                    </a>
                                @else
                                    <span class="badge badge-secondary">Tidak ada</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada ulasan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>

</div>
@endsection