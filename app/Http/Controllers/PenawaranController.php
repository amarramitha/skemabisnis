<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    /**
     * Form tambah penawaran baru
     */
    public function create()
    {
        $produk = Produk::all();
        return view('admin.penawaran', compact('produk'));
    }

    /**
     * Simpan penawaran ke database
     */
    public function index()
    {
        $penawaran = Penawaran::with('items.produk')->orderBy('created_at', 'desc')->get();
        return view('admin.riwayat', compact('penawaran'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'produk' => 'required|array|min:1',
        ]);

        $produkIds   = $request->input('produk');
        $totalAwal   = 0;
        $totalAkhir  = 0;
        $totalDiskon = 0;

        $penawaran = Penawaran::create([
            'nama' => $request->nama,
            'total_harga'   => 0,
            'total_diskon'  => 0,
            'total_akhir'   => 0,
        ]);

        foreach ($produkIds as $id) {
            $p = Produk::find($id);
            if (!$p) continue;

            $hargaAwal = $p->harga;
            $diskon    = $p->diskonmaks ?? 0;
            $ppn       = 11;

            $potongan     = round($hargaAwal * ($diskon / 100));
            $hargaDiskon  = $hargaAwal - $potongan;
            $ppnNominal   = round($hargaDiskon * ($ppn / 100));
            $hargaAkhir   = $hargaDiskon + $ppnNominal;

            $totalAwal   += $hargaAwal;
            $totalDiskon += $potongan;
            $totalAkhir  += $hargaAkhir;

            $penawaran->items()->create([
                'produk_id'   => $p->id,
                'harga_awal'  => $hargaAwal,
                'diskon'      => $diskon,
                'harga_akhir' => $hargaAkhir,
            ]);
        }

        $penawaran->update([
            'total_harga'  => $totalAwal,
            'total_diskon' => $totalDiskon,
            'total_akhir'  => $totalAkhir,
        ]);

        return redirect()->route('penawaran.create')->with('success', 'Penawaran berhasil disimpan!');
    }
}
