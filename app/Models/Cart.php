<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'name',
        'image',
        'price',
        'quantity',
        'total_price'
    ];

    protected $casts = [
        'price' => 'integer',
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Menu
   public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }


    
    // Hitung total semua item di cart
    public function scopeTotal($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId)->sum('total_price');
    }

    // Hitung jumlah item di cart
    public function scopeItemCount($query, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId)->count();
    }

    // Update total_price otomatis saat quantity berubah
    protected static function booted()
    {
        static::updating(function ($cart) {
            $cart->total_price = $cart->price * $cart->quantity;
        });
    }
}
