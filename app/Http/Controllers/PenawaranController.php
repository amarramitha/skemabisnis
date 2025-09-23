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
        $produk = Produk::with('kategori')->get();
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
            'nama'       => 'required|string|max:255',
            'produk_id'  => 'required|array|min:1',
            'qty'        => 'required|array|min:1',
            'bulan'      => 'required|array|min:1',
            'diskon'     => 'required|array|min:1',
            'diskon_psb' => 'required|array|min:1',
            'ppn'        => 'required|numeric',
        ]);

        $produkIds  = $request->input('produk_id');
        $qtys       = $request->input('qty');
        $bulans     = $request->input('bulan');
        $diskons    = $request->input('diskon');
        $diskonPsbs = $request->input('diskon_psb');
        $ppnPersen  = (float) $request->input('ppn') / 100;

        $totalAwal   = 0;
        $totalDiskon = 0;
        $totalAkhir  = 0;

        $penawaran = Penawaran::create([
            'nama'                => $request->nama,
            'total_harga'         => 0,
            'total_diskon'        => 0,
            'total_akhir'         => 0,
            'total_diskon_persen' => 0,
        ]);

        foreach ($produkIds as $index => $id) {
            $p = Produk::with('kategori')->find($id);
            if (!$p) continue;

            $qty    = max(1, intval($qtys[$index] ?? 1));
            $bulan  = max(1, intval($bulans[$index] ?? 1));
            $diskon = max(0, intval($diskons[$index] ?? 0));
            $diskonPsb = max(0, intval($diskonPsbs[$index] ?? 0));

            $hargaSatuan  = $p->harga;
            $hargaTotal   = $hargaSatuan * $qty * $bulan;

            // diskon layanan
            $potonganLayanan = round($hargaTotal * $diskon / 100);
            $hargaSetelahDiskon = $hargaTotal - $potonganLayanan;

            // biaya PSB + diskonnya
            $psb = $p->kategori->psb ?? 0;
            $potonganPsb = round($psb * $diskonPsb / 100);
            $psbSetelahDiskon = $psb - $potonganPsb;

            // subtotal sebelum PPN
            $subtotal = $hargaSetelahDiskon + $psbSetelahDiskon;

            // PPN
            $ppnNominal = round($subtotal * $ppnPersen);
            $hargaAkhir = $subtotal + $ppnNominal;

            // akumulasi untuk header
            $totalAwal   += $hargaTotal + $psb;
            $totalDiskon += $potonganLayanan + $potonganPsb;
            $totalAkhir  += $hargaAkhir;

            // simpan detail produk
            $penawaran->items()->create([
                'produk_id'            => $p->id,
                'qty'                  => $qty,
                'bulan'                => $bulan,
                'harga_satuan'         => $hargaSatuan,
                'harga_total'          => $hargaTotal,
                'diskon'               => $diskon,
                'diskon_nominal'       => $potonganLayanan + $potonganPsb,
                'harga_setelah_diskon' => $subtotal,
                'ppn_nominal'          => $ppnNominal,
                'harga_akhir'          => $hargaAkhir,
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
