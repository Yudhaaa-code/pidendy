<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserTransactionController;
use Illuminate\Http\Request;

// Rute untuk halaman beranda
Route::get('/', [ProductController::class, 'welcome'])->name('welcome');

// Rute untuk halaman daftar produk
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Rute untuk autentikasi user frontend
Route::middleware('guest')->group(function () {
	Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
	Route::post('/login', [LoginController::class, 'login'])->name('login.process');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Rute untuk riwayat transaksi user
Route::middleware('auth')->group(function () {
	Route::get('/my-transactions', [UserTransactionController::class, 'index'])->name('my-transactions.index');
	Route::get('/my-transactions/{transaction}', [UserTransactionController::class, 'show'])->name('my-transactions.show');
});

// Rute untuk pembayaran, wajib login agar transaksi tersimpan ke riwayat user
Route::middleware('auth')->group(function () {
	Route::get('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
	// Fallback untuk request POST lama: redirect ke GET
	Route::post('/checkout', function (Request $request) {
		return redirect()->route('checkout', ['product_id' => $request->input('product_id')]);
	});
	Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
	Route::get('/payment/waiting/{id}', [PaymentController::class, 'waiting'])->name('payment.waiting');
	Route::get('/payment/check/{id}', [PaymentController::class, 'check'])->name('payment.check');
	Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');
	Route::get('/payment/upload/{id}', [PaymentController::class, 'uploadForm'])->name('payment.uploadForm');
	Route::post('/payment/upload/{id}', [PaymentController::class, 'upload'])->name('payment.upload');
});
