<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    protected $table = 'penawaran';

    protected $fillable = [
        'nama',
        'total_harga',
        'total_diskon',
        'total_akhir',
        'total_diskon_persen',
    ];

    /**
     * Relasi ke detail produk
     */
    public function items()
    {
        return $this->hasMany(PenawaranProduk::class, 'penawaran_id');
    }
}
