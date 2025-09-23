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
        'ppn',
        'ppn_nominal',
    ];

    /**
     * Relasi ke detail produk
     */
    public function items()
    {
        return $this->hasMany(PenawaranProduk::class, 'penawaran_id');
    }
}
