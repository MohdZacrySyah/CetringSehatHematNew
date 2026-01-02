<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'is_paket_hemat', // Pastikan kolom ini ada jika Anda pakai fitur paket hemat
    ];

    /**
     * Relasi: Satu Menu memiliki banyak Review
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    // Opsional: Jika Anda ingin mengambil rata-rata rating secara otomatis
    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}