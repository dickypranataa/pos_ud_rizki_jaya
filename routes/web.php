<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Halaman Utama (Bisa diarahkan ke login)
Route::get('/', function () {
    return redirect()->route('login');
});

// Group Route yang butuh Login
Route::middleware('auth')->group(function () {

    // --- DASHBOARD (Semua User Login Bisa Akses) ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- KHUSUS ADMIN (Manajemen Produk, dll) ---
    Route::middleware(['role:admin'])->group(function () {
        // Ini akan otomatis membuat route untuk index, create, store, edit, update, destroy
        Route::resource('products', ProductController::class);
        Route::get('/products/{product}/restock', [StockController::class, 'create'])->name('stocks.create');
        Route::post('/products/{product}/restock', [StockController::class, 'store'])->name('stocks.store');
    });

    // --- KHUSUS KASIR (Nanti kita buat) ---
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/pos', function () {
            return "Halaman Kasir";
        })->name('pos.index');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

require __DIR__.'/auth.php';
