<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    // Halaman daftar semua rating & ulasan
    public function index()
    {
        $reviews = Review::with(['user', 'order.orderItems.menu'])
            ->latest()
            ->get();
        
        return view('review.index', compact('reviews'));
    }

    // Halaman form buat review
    public function create(Order $order)
    {
        // Check if already reviewed
        $existingReview = Review::where('order_id', $order->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return redirect()->route('order.detail', $order->id)
                ->with('error', 'Anda sudah memberikan ulasan untuk pesanan ini.');
        }

        return view('review.create', compact('order'));
    }

    // Proses simpan review
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'review_text' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:10240'
        ]);

        // Handle file upload
        $mediaPath = null;
        if ($request->hasFile('media')) {
            $mediaPath = $request->file('media')->store('reviews', 'public');
        }

        // Create review
        Review::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'question' => $request->question,
            'review_text' => $request->review_text,
            'rating' => $request->rating,
            'media_path' => $mediaPath
        ]);

        return redirect()->route('review.success');
    }

    // Halaman success
    public function success()
    {
        return view('review.success');
    }
}
