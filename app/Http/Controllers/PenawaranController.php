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
     * Tampilkan riwayat penawaran
     */
    public function index()
    {
        $penawaran = Penawaran::with('items.produk')->orderBy('created_at', 'desc')->get();
        return view('admin.riwayat', compact('penawaran'));
    }

    /**
     * Simpan penawaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'produk' => 'required|array|min:1',
            'qty'    => 'required|array|min:1',
        ]);

        $produkIds   = $request->input('produk');
        $qtys        = $request->input('qty');

        $totalAwal   = 0;
        $totalDiskon = 0;
        $totalAkhir  = 0;

        $penawaran = Penawaran::create([
            'nama'              => $request->nama,
            'total_harga'       => 0,
            'total_diskon'      => 0,
            'total_akhir'       => 0,
            'total_diskon_persen' => 0,
        ]);

        foreach ($produkIds as $index => $id) {
            $p = Produk::find($id);
            if (!$p) continue;

            $qty          = max(1, intval($qtys[$index] ?? 1)); // default 1 kalau kosong
            $hargaSatuan  = $p->harga;
            $hargaTotal   = $hargaSatuan * $qty;
            $diskon       = $p->diskonmaks ?? 0; // diskon %
            $potongan     = round($hargaTotal * ($diskon / 100));
            $hargaDiskon  = $hargaTotal - $potongan;
            $ppnNominal   = round($hargaDiskon * 0.11);
            $hargaAkhir   = $hargaDiskon + $ppnNominal;

            // akumulasi untuk header
            $totalAwal   += $hargaTotal;
            $totalDiskon += $potongan;
            $totalAkhir  += $hargaAkhir;

            // simpan detail produk
            $penawaran->items()->create([
                'produk_id'             => $p->id,
                'qty'                   => $qty,
                'harga_satuan'          => $hargaSatuan,
                'harga_total'           => $hargaTotal,
                'diskon'                => $diskon,
                'diskon_nominal'        => $potongan,
                'harga_setelah_diskon'  => $hargaDiskon,
                'ppn_nominal'           => $ppnNominal,
                'harga_akhir'           => $hargaAkhir,
            ]);
        }

        // hitung diskon % efektif dari total
        $totalDiskonPersen = $totalAwal > 0 
            ? round(($totalDiskon / $totalAwal) * 100, 2)
            : 0;

        // update header penawaran
        $penawaran->update([
            'total_harga'        => $totalAwal,
            'total_diskon'       => $totalDiskon,
            'total_akhir'        => $totalAkhir,
            'total_diskon_persen'=> $totalDiskonPersen,
        ]);

        return redirect()->route('penawaran.create')->with('success', 'Penawaran berhasil disimpan!');
    }
}
