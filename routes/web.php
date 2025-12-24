<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Models\Menu;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderArchiveController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;

// Grup Rute Khusus Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // TAMBAHKAN INI:
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    // Rute Detail & Update Order
    Route::get('/admin/orders/{order}', [AdminController::class, 'showOrder'])->name('admin.orders.show');
    Route::put('/admin/orders/{order}/update', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');
Route::get('/admin/menus', [AdminController::class, 'menus'])->name('admin.menus');
Route::get('/admin/menus/create', [AdminController::class, 'createMenu'])->name('admin.menus.create');
Route::post('/admin/menus', [AdminController::class, 'storeMenu'])->name('admin.menus.store');
Route::get('/admin/menus/{menu}/edit', [AdminController::class, 'editMenu'])->name('admin.menus.edit');
Route::put('/admin/menus/{menu}', [AdminController::class, 'updateMenu'])->name('admin.menus.update');
Route::delete('/admin/menus/{menu}', [AdminController::class, 'destroyMenu'])->name('admin.menus.destroy');
    
    // Nanti rute manajemen menu, pesanan, dll ditaruh di sini juga
});
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Rute untuk Splash Screen (/)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute untuk Halaman Menu (/menu)
Route::get('/menu', function () {
    return view('menu');
});

// 3. Rute Dashboard - DARI DATABASE!
Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// 4. Tentang Kami
Route::get('/tentang-kami', function () {
    return view('tentang-kami');
})->middleware(['auth', 'verified'])->name('tentang');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Halaman keranjang
    Route::get('/keranjang', [CartController::class, 'show'])->name('cart');
    
    // Tambah ke keranjang
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    
    // Update keranjang
    Route::put('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    
    // Hapus item dari keranjang
    Route::delete('/keranjang/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    // Kosongkan keranjang
    Route::delete('/keranjang/clear', [CartController::class, 'clear'])->name('cart.clear');
});

/*
|--------------------------------------------------------------------------
| Order Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Checkout
    Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    
    // Payment Method
    Route::get('/order/payment-method', [OrderController::class, 'paymentMethod'])->name('order.payment.method');
    Route::post('/order/select-payment', [OrderController::class, 'selectPaymentMethod'])->name('order.payment.select');
    
    // Payment Detail & QR
    Route::get('/order/{order}/detail-payment', [OrderController::class, 'paymentDetail'])->name('order.payment.detail');
    Route::get('/order/{order}/qr-code', [OrderController::class, 'showQRCode'])->name('order.payment.qr');
    Route::get('/order/{order}/payment', [OrderController::class, 'showPayment'])->name('order.payment.show');
    Route::post('/order/{order}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('order.payment.confirm');
    
    // Order Status Pages
    Route::get('/order/{order}/loading', [OrderController::class, 'loading'])->name('order.loading');
    Route::get('/order/{order}/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/order/{order}/detail', [OrderController::class, 'detail'])->name('order.detail');
    
    // Struktur
    Route::get('/order/struktur', [OrderController::class, 'struktur'])->name('order.struktur');
});

/*
|--------------------------------------------------------------------------
| Review/Rating Routes
|--------------------------------------------------------------------------
*/
// Rating & Reviews Route
Route::get('/ratings', [ReviewController::class, 'index'])->name('ratings.index')->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function () {
    // Form review
    Route::get('/order/{order}/review', [ReviewController::class, 'create'])->name('review.create');
    
    // Submit review
    Route::post('/order/{order}/review', [ReviewController::class, 'store'])->name('review.store');
    
    // Success page
    Route::get('/review/success', [ReviewController::class, 'success'])->name('review.success');
});

/*
|--------------------------------------------------------------------------
| Notification Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // List notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');
    
    // Detail notifikasi
    Route::get('/notifikasi/{id}', [NotificationController::class, 'show'])->name('notifikasi.detail');
    
    // Tandai semua sebagai dibaca
    Route::post('/notifikasi/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifikasi.mark-all-read');
    
    // Hapus notifikasi
    Route::delete('/notifikasi/{id}', [NotificationController::class, 'destroy'])->name('notifikasi.destroy');
});

/*
|--------------------------------------------------------------------------
| Order Archive Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // List arsip pesanan
    Route::get('/arsip-pesanan', [OrderArchiveController::class, 'index'])->name('arsip.index');
    
    // Detail pembatalan
    Route::get('/arsip-pesanan/{id}/rincian', [OrderArchiveController::class, 'detail'])->name('arsip.detail');
    
    // Beli lagi
    Route::get('/arsip-pesanan/{id}/beli-lagi', [OrderArchiveController::class, 'buyAgain'])->name('arsip.buy-again');
    
    // Hapus arsip
    Route::delete('/arsip-pesanan/{id}', [OrderArchiveController::class, 'destroy'])->name('arsip.destroy');
    
    // Hapus semua arsip
    Route::delete('/arsip-pesanan', [OrderArchiveController::class, 'clearAll'])->name('arsip.clear-all');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil (view)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    
    // Edit profil (form)
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // Update profil
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/orders/{order}/pay', [PaymentController::class, 'pay'])
    ->name('orders.pay');

    Route::post('/checkout', [CheckoutController::class, 'checkout'])
    ->name('order.checkout');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
