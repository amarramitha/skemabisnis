<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'harga',
        
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_id');
    }

    // accessor untuk PPN & total harga
    public function getPpnAttribute()
    {
        return $this->harga * 0.11;
    }

    public function getTotalAttribute()
    {
        return $this->harga + $this->ppn;
    }

    public function getPpnHargaMinimalAttribute()
    {
        return $this->harga_minimal * 0.11;
    }

    public function getTotalHargaMinimalAttribute()
    {
        return $this->harga_minimal + $this->ppn_harga_minimal;
    }

    public function penawaran()
{
    return $this->belongsToMany(Penawaran::class, 'penawaran_produk')
                ->withPivot('harga_awal', 'diskon', 'harga_akhir')
                ->withTimestamps();
}
}
