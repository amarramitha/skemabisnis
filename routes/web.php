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

Route::get('/admin/riwayat', function () {
    return view('admin.riwayat');
})->name('riwayat')->middleware(['auth']);

Route::get('/admin/showpenawaran', function () {
    return view('admin.showpenawaran');
})->name('showpenawaran')->middleware(['auth']);

Route::get('/admin/masterdata', [MasterDataController::class, 'indexProduk'])
    ->name('masterdata')
    ->middleware(['auth']);

/* ----------------- MASTER DATA ----------------- */

// Kategori
Route::get('/admin/masterdata/inputkategori', [MasterDataController::class, 'createKategori'])
    ->name('masterdata.inputkategori')
    ->middleware(['auth']);

Route::post('/admin/masterdata/inputkategori', [MasterDataController::class, 'storeKategori'])
    ->name('masterdata.kategori.store')
    ->middleware(['auth']);

// Produk
Route::get('/admin/masterdata/inputproduk', [MasterDataController::class, 'createProduk'])
    ->name('masterdata.inputproduk')
    ->middleware(['auth']);

Route::post('/admin/masterdata/inputproduk', [MasterDataController::class, 'storeProduk'])
    ->name('masterdata.produk.store')
    ->middleware(['auth']);


Route::get('/admin/penawaran', [PenawaranController::class, 'create'])
    ->name('penawaran.create')
    ->middleware(['auth']);

Route::post('/admin/penawaran', [PenawaranController::class, 'store'])
    ->name('penawaran.store')
    ->middleware(['auth']);

// Master Data Produk
Route::get('/masterdata/produk', [MasterDataController::class, 'indexProduk'])->name('masterdata.indexproduk');
Route::get('/masterdata/produk/create', [MasterDataController::class, 'createProduk'])->name('masterdata.inputproduk');
Route::post('/masterdata/produk/store', [MasterDataController::class, 'storeProduk'])->name('masterdata.storeproduk');

// Edit & Update
Route::get('/masterdata/produk/{id}/edit', [MasterDataController::class, 'editProduk'])->name('produk.edit');
Route::put('/masterdata/produk/{id}', [MasterDataController::class, 'updateProduk'])->name('produk.update');


// Hapus
Route::delete('/masterdata/produk/{id}', [MasterDataController::class, 'destroyProduk'])->name('produk.destroy');


/* ----------------- PENAWARAN ----------------- */
Route::get('/admin/penawaran', function () {
    return view('admin.penawaran');
})->name('penawaran')->middleware(['auth']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
