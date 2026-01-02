<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;    // Semua logika order & midtrans disini
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderArchiveController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\MenuController; 

/*
|--------------------------------------------------------------------------
| Web Routes (Fixed & Clean)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Rute untuk Detail Menu
Route::get('/menu/{id}', [MenuController::class, 'show'])->name('menu.detail');

Route::get('/menu', function () {
    return view('menu');
});

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->middleware(['auth', 'verified'])->name('tentang');


/* |--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/keranjang', [CartController::class, 'show'])->name('cart');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/keranjang/clear', [CartController::class, 'clear'])->name('cart.clear');
});


/*
|--------------------------------------------------------------------------
| ORDER & PAYMENT ROUTES (UPDATED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Halaman Checkout (Input Alamat & Note)
    Route::get('/checkout', [OrderController::class, 'checkoutPage'])->name('order.checkoutPage');
    
    // 2. Proses Buat Order (Dari tombol "Buat Pesanan")
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('order.process');
    
    // 3. Halaman Bayar Midtrans
    // Nama route disesuaikan dengan controller: 'order.payment.show'
    Route::get('/orders/{id}/pay', [OrderController::class, 'showPayment'])->name('order.payment.show');
    
    // 4. Sukses Bayar
    Route::get('/order/{id}/success', [OrderController::class, 'success'])->name('order.success');
    
    // 5. Detail Pesanan
    Route::get('/order/{id}/detail', [OrderController::class, 'detail'])->name('order.detail');
    
    // 6. Batalkan Pesanan (Fitur Baru)
    Route::put('/order/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');

    // 7. Cetak Struk (Opsional)
    Route::get('/order/struktur', [OrderController::class, 'struktur'])->name('order.struktur');
});


/* |--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Menu Management
    Route::get('/admin/menus', [AdminController::class, 'menus'])->name('admin.menus');
    Route::get('/admin/menus/create', [AdminController::class, 'createMenu'])->name('admin.menus.create');
    Route::post('/admin/menus', [AdminController::class, 'storeMenu'])->name('admin.menus.store');
    Route::get('/admin/menus/{menu}/edit', [AdminController::class, 'editMenu'])->name('admin.menus.edit');
    Route::put('/admin/menus/{menu}', [AdminController::class, 'updateMenu'])->name('admin.menus.update');
    Route::delete('/admin/menus/{menu}', [AdminController::class, 'destroyMenu'])->name('admin.menus.destroy');
    
    // Order & Review Management
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders');
        Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::put('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    });
});


/* |--------------------------------------------------------------------------
| REVIEW, NOTIFICATION, ARCHIVE, PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Reviews
    Route::get('/ratings', [ReviewController::class, 'index'])->name('ratings.index');
    Route::get('/order/{order}/review', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/order/{order}/review', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/review/success', [ReviewController::class, 'success'])->name('review.success');

    // Notifications
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
    Route::get('/notifikasi/{id}', [NotificationController::class, 'show'])->name('notifikasi.detail');
    Route::post('/notifikasi/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifikasi.mark-all-read');
    Route::delete('/notifikasi/{id}', [NotificationController::class, 'destroy'])->name('notifikasi.destroy');

    // Archives
    Route::get('/arsip-pesanan', [OrderArchiveController::class, 'index'])->name('arsip.index');
    Route::get('/arsip-pesanan/{id}/rincian', [OrderArchiveController::class, 'detail'])->name('arsip.detail');
    Route::get('/arsip-pesanan/{id}/beli-lagi', [OrderArchiveController::class, 'buyAgain'])->name('arsip.buy-again');
    Route::delete('/arsip-pesanan/{id}', [OrderArchiveController::class, 'destroy'])->name('arsip.destroy');
    Route::delete('/arsip-pesanan', [OrderArchiveController::class, 'clearAll'])->name('arsip.clear-all');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});


require __DIR__.'/auth.php';