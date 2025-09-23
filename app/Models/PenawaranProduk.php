<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenawaranProduk extends Model
{
    protected $table = 'penawaran_produk';

    protected $fillable = [
        'penawaran_id',
        'produk_id',
        'qty',
        'bulan',
        'harga_satuan',
        'mc',
        'harga_total',
        'diskon',
        'diskon_nominal',
        'psb',
        'diskon_psb',
        'psb_setelah_diskon',
        'harga_setelah_diskon',
        'ppn_nominal',
        'harga_akhir',
    ];

    /**
     * Relasi balik ke penawaran
     */
    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class, 'penawaran_id');
    }

    /**
     * Relasi ke produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
