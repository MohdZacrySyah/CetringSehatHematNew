@extends('layouts.admin')

@section('title', 'Ulasan Pelanggan')

@section('content')
<div class="container px-6 mx-auto grid py-8">

    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800">
            Ulasan Pelanggan
        </h2>
        <p class="text-gray-500 text-sm mt-1">Lihat feedback dan penilaian dari pelanggan tentang pesanan mereka.</p>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-3">
        <div class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-3 mr-4 text-yellow-500 bg-yellow-50 rounded-full">
                <i class="fa-solid fa-star text-xl"></i>
            </div>
            <div>
                <p class="mb-1 text-sm font-medium text-gray-500">Total Ulasan</p>
                <p class="text-xl font-bold text-gray-800">{{ $reviews->total() }}</p>
            </div>
        </div>
    </div>

    <div class="w-full overflow-hidden bg-white rounded-2xl shadow-lg border border-gray-100 ring-1 ring-black/5">
        <div class="w-full overflow-x-auto">
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr class="text-xs font-bold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-50/50">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Ulasan</th>
                        <th class="px-6 py-4">Foto</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reviews as $review)
                    <tr class="text-gray-700 hover:bg-gray-50/80 transition-colors">
                        
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            <div class="flex items-center gap-2 text-gray-500">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $review->created_at->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-400 pl-6 mt-0.5">
                                {{ $review->created_at->format('H:i') }} WIB
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-800 text-sm">{{ $review->user->name }}</span>
                                <span class="text-xs text-gray-500 mb-2">{{ $review->user->email }}</span>
                                
                                <a href="{{ route('admin.orders.show', $review->order_id) }}" 
                                   class="inline-flex items-center w-fit px-2.5 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100 hover:bg-purple-100 transition-colors"
                                   target="_blank">
                                    <i class="fa-solid fa-receipt mr-1.5"></i>
                                    #{{ $review->order->order_number ?? 'Unknown' }}
                                </a>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1 text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-regular fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 font-bold text-xs bg-gray-100 px-1.5 py-0.5 rounded border border-gray-200">
                                    {{ $review->rating }}.0
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                @if($review->question)
                                    <p class="text-xs text-gray-400 italic mb-1 border-l-2 border-gray-300 pl-2">
                                        "{{ Str::limit($review->question, 50) }}"
                                    </p>
                                @endif
                                <p class="text-sm text-gray-700 leading-relaxed">
                                    {{ $review->review_text ?? '-' }}
                                </p>
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            @if($review->media_path)
                                <a href="{{ asset('storage/' . $review->media_path) }}" target="_blank" class="block w-14 h-14 rounded-lg overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition-all group relative">
                                    <img src="{{ asset('storage/' . $review->media_path) }}" alt="Foto Review" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors"></div>
                                </a>
                            @else
                                <span class="inline-flex items-center justify-center w-14 h-14 bg-gray-50 rounded-lg border border-gray-100 text-gray-300 text-xs text-center p-1">
                                    No Img
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-regular fa-comments text-3xl text-gray-300"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-600">Belum ada ulasan</h3>
                                <p class="text-sm text-gray-400 mt-1">Ulasan dari pelanggan akan muncul di sini setelah mereka memberikan rating.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $reviews->links() }}
        </div>
    </div>

</div>
@endsection