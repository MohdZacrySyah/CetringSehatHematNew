<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'subtotal',
        'biaya_pengiriman',
        'biaya_aplikasi',
        'total_bayar',
        'payment_method',
        'status',
        'customer_notes',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke order items (nama asli)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke order items (alias untuk compatibility)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Relasi ke review
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // Relasi ke reviews (plural untuk multiple reviews jika diperlukan)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Generate order number otomatis
    public static function generateOrderNumber()
    {
        return 'ORD' . date('Ymd') . rand(1000, 9999);
    }

    // Helper method: Cek apakah order sudah di-review
    public function hasReview()
    {
        return $this->review()->exists();
    }

    // Helper method: Get total items
    public function getTotalItemsAttribute()
    {
        return $this->items->sum('quantity');
    }
}
