<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->decimal('diskon_maks', 5, 2)->default(0); // persen
            $table->enum('jenis', ['pots', 'non-pots'])->default('non-pots');
            $table->integer('psb');
            $table->decimal('diskonmaks_psb')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_produk');
    }
};
