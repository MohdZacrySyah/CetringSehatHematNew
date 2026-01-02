<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
        'order_number',
        'subtotal',
        'biaya_pengiriman', // Pastikan ini ada
        'biaya_aplikasi',   // Pastikan ini ada
        'total_bayar',
        'status',
        'paid_at',
        'payment_method',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'payment_response',
        
        // 🔴 TAMBAHKAN 3 BARIS INI (WAJIB) 🔴
        'delivery_address',
        'customer_notes',
        'payment_due_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELASI PENTING: Order punya banyak Item
    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
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
