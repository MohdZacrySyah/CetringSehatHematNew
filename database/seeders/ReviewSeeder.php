<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Menu;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua user
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn('User tidak ditemukan. Jalankan UserSeeder terlebih dahulu!');
            return;
        }

        // Ambil menu untuk order items
        $menu = Menu::first();
        
        if (!$menu) {
            $this->command->warn('Menu tidak ditemukan. Pastikan ada data menu!');
            return;
        }

        // Data review dummy dengan nama menu yang bervariasi
        $reviewsData = [
            [
                'menu_name' => 'Nasi dan Ayam Sambal Merah',
                'question' => 'Makanannya fresh dan porsi banyak, dessert keju bikin nagih',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 5,
            ],
            [
                'menu_name' => 'Nasi dan Ayam Sambal Merah',
                'question' => 'Salad buahnya segar dan enak, dessert cheese bikin nagih',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 4,
            ],
            [
                'menu_name' => 'Nasi dan Ayam Sambal Merah',
                'question' => 'Nasi goreng umbi nya enak banget, bumbu nya pas',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 5,
            ],
            [
                'menu_name' => 'Tumis Buncis dan Terong',
                'question' => 'Tumis buncis dan terong nya fresh, cocok buat diet',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 4,
            ],
            [
                'menu_name' => 'Ayam Geprek',
                'question' => 'Ayam geprek nya mantap, sambel nya pas pedasnya',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 5,
            ],
            [
                'menu_name' => 'Nasi Sambal Ikan',
                'question' => 'Nasi sambal ikan nya enak, ikan nya fresh',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 5,
            ],
            [
                'menu_name' => 'Mie Goreng Umi',
                'question' => 'Mie goreng umbi nya enak banget, porsi banyak',
                'review_text' => 'Alhamdulillah, pesanan saya sudah sampai. terimakasih aplikasi catering, pesanan sesuai apa yang saya pesan. rasa nya juga sangat nikmat',
                'rating' => 4,
            ],
        ];

        // Buat order dan review untuk setiap user
        foreach ($reviewsData as $index => $reviewData) {
            // Pilih user secara berurutan (cycling)
            $user = $users[$index % $users->count()];

            // Hitung harga
            $quantity = rand(1, 3);
            $price = $menu->price;
            $subtotal = $quantity * $price;

            // Buat order untuk user ini
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'subtotal' => $subtotal,
                'biaya_pengiriman' => 5000,
                'biaya_aplikasi' => 2000,
                'total_bayar' => $subtotal + 5000 + 2000,
                'payment_method' => ['DANA', 'OVO', 'GoPay', 'QRIS'][array_rand(['DANA', 'OVO', 'GoPay', 'QRIS'])],
                'status' => 'completed',
                'customer_notes' => 'Pesanan untuk review',
                'paid_at' => now()->subDays(rand(1, 30)),
            ]);

            // Buat order item dengan menu_name dan subtotal
            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'menu_name' => $reviewData['menu_name'],
                'quantity' => $quantity,
                'price' => $price,
                'subtotal' => $subtotal, // Tambahkan ini!
            ]);

            // Buat review
            Review::create([
                'order_id' => $order->id,
                'user_id' => $user->id,
                'question' => $reviewData['question'],
                'review_text' => $reviewData['review_text'],
                'rating' => $reviewData['rating'],
                'media_path' => null,
            ]);

            $this->command->info("✅ Review dari {$user->name} untuk {$reviewData['menu_name']} berhasil dibuat!");
        }

        $this->command->info('🎉 Semua review seeder berhasil dijalankan!');
    }
}
