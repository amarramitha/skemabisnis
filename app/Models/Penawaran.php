<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    use HasFactory;

    protected $table = 'penawaran';

    protected $fillable = [
        'nama', 
        'total_harga', 
        'total_diskon', 
        'total_akhir'
    ];

    public function produk()
    {
        return $this->hasMany(PenawaranProduk::class);
    }
}
