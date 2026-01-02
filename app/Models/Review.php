<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'question',    // Pertanyaan: "Apa yang membuat Anda puas?"
        'review_text', // Ulasan teks
        'rating',      // Bintang 1-5
        'media_path',  // Foto/Video (jika ada)
    ];

    // Relasi ke User (Siapa yang mereview)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Order (Review untuk pesanan mana)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}