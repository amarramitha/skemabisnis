<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penawaran;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    public function create()
    {
        $produk = Produk::with('kategori')->get();
        return view('admin.penawaran', compact('produk'));
    }

    public function index()
    {
        $penawaran = Penawaran::with('items.produk')->orderBy('created_at', 'desc')->get();
        return view('admin.riwayat', compact('penawaran'));
    }

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
        'nama'         => $request->nama,
        'total_harga'  => 0,
        'total_diskon' => 0,
        'total_akhir'  => 0,
        'ppn'          => $request->ppn,
        'ppn_nominal'  => 0,
    ]);

    foreach ($produkIds as $index => $id) {
        $p = Produk::with('kategori')->find($id);
        if (!$p) continue;

        $qty        = max(1, (int)($qtys[$index] ?? 1));
        $bulan      = max(1, (int)($bulans[$index] ?? 1));
        $diskon     = max(0, (float)($diskons[$index] ?? 0));      // pakai float
        $diskonPsb  = max(0, (float)($diskonPsbs[$index] ?? 0));  // pakai float

        $hargaSatuan = (float) $p->harga;
        $mc          = $hargaSatuan * $qty;
        $hargaTotal  = $mc * $bulan;

        // Diskon layanan
        $potonganLayanan     = round($hargaTotal * $diskon / 100, 2);
        $hargaSetelahDiskon  = $hargaTotal - $potonganLayanan;

        // Biaya PSB
        $psb                = (float) ($p->kategori->psb ?? 0);
        $potonganPsb        = round($psb * $diskonPsb / 100, 2);
        $psbSetelahDiskon   = $psb - $potonganPsb;

        $subtotal = $hargaSetelahDiskon + $psbSetelahDiskon;

        // PPN
        $ppnNominal = round($subtotal * $ppnPersen, 2);
        $hargaAkhir = $subtotal + $ppnNominal;

        // Akumulasi header
        $totalAwal   += $hargaTotal + $psb;
        $totalDiskon += $potonganLayanan + $potonganPsb;
        $totalAkhir  += $hargaAkhir;

        // Simpan detail
        $penawaran->items()->create([
            'produk_id'            => $produkIds[$index],
            'qty'                  => $qty,
            'bulan'                => $bulan,
            'harga_satuan'         => $hargaSatuan,
            'harga_total'          => $hargaTotal,
            'diskon'               => $diskon,       // desimal disimpan apa adanya
            'diskon_nominal'       => $potonganLayanan,
            'diskon_psb'           => $diskonPsb, 
            'psb'                  => $psb,
            'psb_setelah_diskon'   => $psbSetelahDiskon,
            'harga_setelah_diskon' => $hargaSetelahDiskon,
            'ppn_nominal'          => $ppnNominal,
            'harga_akhir'          => $hargaAkhir,
        ]);
    }

    // Update header
    $penawaran->update([
        'total_harga'  => $totalAwal,
        'total_diskon' => $totalDiskon,
        'total_akhir'  => $totalAkhir,
        'ppn_nominal'  => round($totalAkhir * $ppnPersen, 2),
    ]);

    return redirect()->route('penawaran.create')->with('success', 'Penawaran berhasil disimpan!');
}


}
