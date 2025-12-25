<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. BUAT TABEL ORDERS
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Harga
            $table->integer('subtotal');
            $table->integer('biaya_pengiriman')->default(0);
            $table->integer('biaya_aplikasi')->default(1000);
            $table->integer('total_bayar');

            // Midtrans Data
            $table->string('payment_method')->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->json('payment_response')->nullable();

            // Status
            $table->enum('status', [
                'pending',      // Menunggu pembayaran
                'paid',         // Sudah dibayar
                'processing',   // Sedang dimasak
                'completed',    // Selesai/Diantar
                'cancelled'     // Dibatalkan
            ])->default('pending');

            $table->date('start_date')->nullable();
            $table->integer('duration_days')->nullable();
            $table->text('customer_notes')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        // 2. BUAT TABEL ORDER ITEMS (BAGIAN INI YANG HILANG SEBELUMNYA)
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            
            // Kita simpan snapshot data (nama & harga saat beli)
            // agar jika menu asli diedit/dihapus, data history order aman
            $table->string('menu_name'); 
            $table->string('menu_image')->nullable();
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};