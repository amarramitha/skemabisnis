<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // ==============================
    // KATEGORI
    // ==============================
    public function createKategori()
    {
        return view('admin.inputkategori');
    }

    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        KategoriProduk::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('masterdata.inputkategori')
                         ->with('success', 'Kategori produk berhasil ditambahkan!');
    }

    // ==============================
    // PRODUK
    // ==============================

    public function indexProduk()
{
    $produk = Produk::with('kategori')->get();
    return view('admin.masterdata', compact('produk'));
}
    public function createProduk()
{
    $kategori = KategoriProduk::all(); 
    return view('admin.inputproduk', compact('kategori'));
}

public function storeProduk(Request $request)
{
    $request->validate([
        'kategori_id' => 'required|exists:kategori_produk,id',
        'nama_produk' => 'required|string|max:255',
        'harga'       => 'required|numeric|min:0',
        'diskonmaks'  => 'required|integer|min:0|max:100',
        'jenis'       => 'required|in:POTS,Non POTS',
    ]);

    $ppn = $request->harga * 0.11;
    $total = $request->harga + $ppn;

    Produk::create([
        'kategori_id' => $request->kategori_id,
        'nama_produk' => $request->nama_produk,
        'harga'       => $request->harga,
        'total_harga' => $total,
        'diskonmaks'  => $request->diskonmaks,
        'jenis'       => $request->jenis,
    ]);

    return redirect()->route('masterdata.inputproduk')
                     ->with('success', 'Produk berhasil ditambahkan');
}




}
