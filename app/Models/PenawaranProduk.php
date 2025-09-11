<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenawaranProduk extends Model
{
    use HasFactory;

    protected $table = 'penawaran_produk';

    protected $fillable = [
        'penawaran_id',
        'produk_id',
        'harga_awal',
        'diskon',
        'harga_akhir'
    ];

    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
