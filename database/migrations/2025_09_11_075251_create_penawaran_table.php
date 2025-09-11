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
            $table->string('nama'); // Nama konsumen
            $table->decimal('total_harga', 15, 2); // Total sebelum diskon & PPN
            $table->decimal('total_diskon', 15, 2); // Total potongan
            $table->decimal('total_akhir', 15, 2); // Total setelah diskon + PPN
            $table->timestamps();
        });

        // Tabel detail produk di penawaran
        Schema::create('penawaran_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->decimal('harga_awal', 15, 2);
            $table->unsignedTinyInteger('diskon')->default(0); // persen
            $table->decimal('harga_akhir', 15, 2); // setelah diskon + PPN
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_produk');
        Schema::dropIfExists('penawaran');
    }
};
