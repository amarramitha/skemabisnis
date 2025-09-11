<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('produk', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kategori_id')->constrained('kategori_produk')->onDelete('cascade');
        $table->string('nama_produk');
        $table->decimal('harga', 15, 2);
        $table->decimal('total_harga', 15, 2);
        $table->unsignedTinyInteger('diskonmaks');
        $table->enum('jenis', ['POTS', 'Non POTS']); 
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
