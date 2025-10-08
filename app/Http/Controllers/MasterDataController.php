<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use App\Models\Penawaran;
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
    $produk = Produk::with('kategori')
    ->join('kategori_produk', 'kategori_produk.id', '=', 'produk.kategori_id')
    ->orderBy('kategori_produk.nama_kategori', 'asc')
    ->orderByRaw('CAST(SUBSTRING_INDEX(nama_produk, " ", 1) AS UNSIGNED) ASC')
    ->select('produk.*')
    ->get();


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
    ]);

    // ambil kategori yang dipilih
    $kategori = KategoriProduk::findOrFail($request->kategori_id);

    $ppn = $request->harga * 0.11;
    $total = $request->harga + $ppn;

    Produk::create([
        'kategori_id' => $request->kategori_id,
        'nama_produk' => $request->nama_produk,
        'harga'       => $request->harga,
        // 'total_harga' => $total,
        // ambil dari kategori, bukan input user
        'diskonmaks'  => $kategori->diskon_maks,
        'jenis'       => $kategori->jenis,
    ]);

    return redirect()->route('masterdata.inputproduk')
                     ->with('success', 'Produk berhasil ditambahkan');
}
    // ==============================
    // EDIT PRODUK
    // ==============================
    public function editProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = KategoriProduk::all();

        return view('admin.editproduk', compact('produk', 'kategori'));
    }

    // ==============================
    // UPDATE PRODUK
    // ==============================
    public function updateProduk(Request $request, $id)
{
    $produk = Produk::findOrFail($id);

    $request->validate([
        'kategori_id' => 'required|exists:kategori_produk,id',
        'nama_produk' => 'required|string|max:255',
        'harga'       => 'required|numeric|min:0',
    ]);

    $kategori = KategoriProduk::findOrFail($request->kategori_id);

    $ppn = $request->harga * 0.11;
    $total = $request->harga + $ppn;

    $produk->update([
        'kategori_id' => $request->kategori_id,
        'nama_produk' => $request->nama_produk,
        'harga'       => $request->harga,
        // 'total_harga' => $total,
        'diskonmaks'  => $kategori->diskon_maks,
        'jenis'       => $kategori->jenis,
    ]);

    return redirect()->route('masterdata')
        ->with('success', 'Produk berhasil diperbarui');
}


    // ==============================
    // HAPUS PRODUK
    // ==============================
    public function destroyProduk($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('masterdata')
            ->with('success', 'Produk berhasil dihapus');
    }

    public function dashboard()
    {
        $jumlahProduk = Produk::count();
        $totalPenawaran = Penawaran::count();

        // Ambil data penawaran per bulan
        $penawaranBulanan = Penawaran::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        // Siapkan label bulan (1 → Januari, dst)
        $labels = [];
        $data = [];
        foreach (range(1, 12) as $i) {
            $labels[] = \Carbon\Carbon::create()->month($i)->translatedFormat('F');
            $data[] = $penawaranBulanan[$i] ?? 0;
        }

        $penawaranTerbaru = Penawaran::with('items.produk')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'jumlahProduk',
            'totalPenawaran',
            'penawaranTerbaru',
            'labels',
            'data'
        ));
    }
}
