<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\Pelanggan;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'productCount' => Product::count(),
            'customerCount' => Pelanggan::count(),
            'transactionCount' => Transaction::count(),
            'latestTransactions' => Transaction::with('pelanggan')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    })->name('admin.dashboard');

    Route::resource('products', ProductController::class)->except('show');
    Route::resource('pelanggans', PelangganController::class)->except('show');

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
});