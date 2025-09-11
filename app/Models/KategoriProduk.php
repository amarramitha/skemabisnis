<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk'; // pakai nama tabel kategori_produk
    protected $fillable = ['nama_kategori'];
}
