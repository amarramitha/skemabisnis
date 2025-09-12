<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel utama penawaran (header)
        Schema::create('penawaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama konsumen
            $table->decimal('total_harga', 15, 2); // Total sebelum diskon & PPN
            $table->decimal('total_diskon', 15, 2); // Total potongan nominal
            $table->decimal('total_akhir', 15, 2); // Total setelah diskon + PPN
            $table->decimal('total_diskon_persen', 5, 2)->default(0); // % diskon efektif
            $table->timestamps();
        });

        // Tabel detail produk di penawaran (line items)
        Schema::create('penawaran_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penawaran_id')->constrained('penawaran')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->integer('qty')->default(1);

            $table->decimal('harga_satuan', 15, 2);      // harga asli per unit
            $table->decimal('harga_total', 15, 2);       // harga_satuan × qty
            $table->unsignedTinyInteger('diskon')->default(0); // diskon % per produk
            $table->decimal('diskon_nominal', 15, 2);    // potongan dalam rupiah
            $table->decimal('harga_setelah_diskon', 15, 2); // setelah diskon, sebelum PPN
            $table->decimal('ppn_nominal', 15, 2)->default(0); // PPN kalau dihitung per produk
            $table->decimal('harga_akhir', 15, 2);       // harga final (setelah diskon + PPN per produk)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penawaran_produk');
        Schema::dropIfExists('penawaran');
    }
};
