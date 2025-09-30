<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\PenawaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [MasterDataController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


/* ----------------- MASTER DATA ----------------- */
Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Master Data Produk
    Route::get('/masterdata', [MasterDataController::class, 'indexProduk'])->name('masterdata');
    
    Route::get('/masterdata/inputkategori', [MasterDataController::class, 'createKategori'])->name('masterdata.inputkategori');
    Route::post('/masterdata/inputkategori', [MasterDataController::class, 'storeKategori'])->name('masterdata.kategori.store');

    Route::get('/masterdata/inputproduk', [MasterDataController::class, 'createProduk'])->name('masterdata.inputproduk');
    Route::post('/masterdata/inputproduk', [MasterDataController::class, 'storeProduk'])->name('masterdata.produk.store');
    Route::get('/masterdata/produk/{id}/edit', [MasterDataController::class, 'editProduk'])->name('produk.edit');
    Route::put('/masterdata/produk/{id}', [MasterDataController::class, 'updateProduk'])->name('produk.update');
    Route::delete('/masterdata/produk/{id}', [MasterDataController::class, 'destroyProduk'])->name('produk.destroy');

    /* ----------------- PENAWARAN ----------------- */
    Route::get('/penawaran', [PenawaranController::class, 'create'])->name('penawaran.create');
    Route::post('/penawaran', [PenawaranController::class, 'store'])->name('penawaran.store');

    // Riwayat Penawaran
    Route::get('/riwayat', [PenawaranController::class, 'index'])->name('penawaran.riwayat');
    Route::delete('/riwayat/{id}', [PenawaranController::class, 'destroy'])->name('penawaran.destroy');
    

});

/* ----------------- PROFILE ----------------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
