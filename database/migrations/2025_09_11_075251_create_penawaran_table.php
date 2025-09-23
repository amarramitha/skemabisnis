<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama penawaran
Schema::create('penawaran', function (Blueprint $table) {
    $table->id();
    $table->string('nama');
    $table->decimal('total_harga', 15, 2);        // Total sebelum diskon & PPN
    $table->decimal('total_diskon', 15, 2);       // Total potongan nominal
    $table->decimal('total_akhir', 15, 2);        // Total setelah diskon + PPN
    $table->unsignedTinyInteger('ppn')->default(11); // PPN (%) biar konsisten dengan view
    $table->decimal('ppn_nominal', 15, 2)->default(0);
    $table->timestamps();
});

// Tabel detail produk
Schema::create('penawaran_produk', function (Blueprint $table) {
    $table->id();
    $table->foreignId('penawaran_id')->constrained('penawaran')->onDelete('cascade');
    $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');

    $table->integer('qty')->default(1);
    $table->integer('bulan')->default(1);

    $table->decimal('harga_satuan', 15, 2);
    $table->decimal('harga_total', 15, 2);          // harga_satuan × qty × bulan
    $table->unsignedTinyInteger('diskon')->default(0);
    $table->decimal('diskon_nominal', 15, 2);

    $table->decimal('psb', 15, 2)->default(0);      // biaya PSB asli
    $table->unsignedTinyInteger('diskon_psb')->default(0); // diskon % PSB
    $table->decimal('psb_setelah_diskon', 15, 2)->default(0);

    $table->decimal('harga_setelah_diskon', 15, 2);
    $table->decimal('ppn_nominal', 15, 2)->default(0);
    $table->decimal('harga_akhir', 15, 2);

    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_produk');
        Schema::dropIfExists('penawaran');
    }
};
