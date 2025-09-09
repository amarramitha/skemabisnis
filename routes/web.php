<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/admin/masterdata', function () {
    return view('admin.masterdata');
})->name('masterdata')->middleware(['auth']);

Route::get('/admin/penawaran', function () {
    return view('admin.penawaran');
})->name('penawaran')->middleware(['auth']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
