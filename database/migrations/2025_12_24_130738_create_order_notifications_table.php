<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // KITA UBAH JADI LEBIH SIMPEL & FLEKSIBEL
        Schema::create('order_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Tambahkan order_id agar user bisa klik notif lalu ke detail order
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade'); 
            
            $table->string('title');   // Judul Notif
            $table->text('message');   // Isi Pesan
            $table->boolean('is_read')->default(false); // Status Baca
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_notifications');
    }
};