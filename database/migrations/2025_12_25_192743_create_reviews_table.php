<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Hubungkan ke tabel orders dan users
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Kolom data review
            $table->string('question');    // Pertanyaan survey
            $table->text('review_text');   // Isi ulasan
            $table->integer('rating');     // Bintang 1-5
            $table->string('media_path')->nullable(); // Foto/Video (Boleh kosong)
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
};