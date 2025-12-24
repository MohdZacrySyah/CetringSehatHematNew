<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->string('order_number')->unique();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // harga
        $table->integer('subtotal');
        $table->integer('biaya_pengiriman')->default(0);
        $table->integer('biaya_aplikasi')->default(1000);
        $table->integer('total_bayar');

        // MIDTRANS
        $table->string('payment_method')->nullable(); // gopay, qris, va, cc
        $table->string('midtrans_transaction_id')->nullable();
        $table->string('midtrans_order_id')->nullable();
        $table->json('payment_response')->nullable();

        // STATUS
        $table->enum('status', [
            'pending',      // baru checkout
            'paid',         // settlement
            'processing',   // catering diproses
            'completed',    // selesai
            'cancelled'     // batal / expire
        ])->default('pending');

        // CATERING
        $table->date('start_date')->nullable();
        $table->integer('duration_days')->nullable();

        // lainnya
        $table->text('customer_notes')->nullable();
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
