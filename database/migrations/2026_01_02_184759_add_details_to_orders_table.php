<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_add_details_to_orders_table.php
public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Kolom untuk alamat spesifik pesanan ini
        $table->text('delivery_address')->nullable()->after('user_id'); 
        // Batas waktu pembayaran
        $table->timestamp('payment_due_at')->nullable()->after('paid_at');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['delivery_address', 'payment_due_at']);
    });
}
};
