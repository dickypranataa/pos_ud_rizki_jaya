<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductImportController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Livewire\PosPage;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- KHUSUS ADMIN (Manajemen Produk, dll) ---
    Route::middleware(['role:admin'])->group(function () {
        // Ini akan otomatis membuat route untuk index, create, store, edit, update, destroy
        Route::resource('products', ProductController::class);
        Route::get('/products/{product}/restock', [StockController::class, 'create'])->name('stocks.create');
        Route::post('/products/{product}/restock', [StockController::class, 'store'])->name('stocks.store');

        //laporan omzet penjualan
        Route::get('/reports/sales', [ReportController::class, 'index'])->name('reports.sales');
        // laporan riwayat stok
        Route::get('/reports/stock', [ReportController::class, 'StockReport'])->name('reports.stock');

        // Category Management (CRUD Kategori)
        Route::resource('categories', CategoryController::class);

        Route::post('/products/import', [ProductImportController::class, 'import'])->name('products.import');
    });


    // --- KHUSUS KASIR (Nanti kita buat) ---
    Route::middleware(['role:kasir'])->group(function () {
        Route::get('/pos', PosPage::class)->name('pos.index');
        
    });

    Route::middleware(['role:admin|kasir'])->group(function () {
        // Rute Cetak Struk
        Route::get('/sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

require __DIR__.'/auth.php';
