<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranProduk extends Model
{
    use HasFactory;

    // Nama tabel sesuai di database
    protected $table = 'penawaran_produk';

    protected $fillable = [
        'penawaran_id',
        'produk_id',
        'harga_awal',
        'diskon',
        'harga_akhir'
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    // Relasi ke Penawaran
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }
}
