@extends('layouts.admin')

@section('title', 'Riwayat Penawaran')

@section('content')
<div x-data="{ show: false, transaksi: {} }" class="container mx-auto px-6 py-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Riwayat Penawaran
        </h2>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2 border text-left">Nama Konsumen</th>
                        <th class="px-4 py-2 border text-right">Total Harga</th>
                        <th class="px-4 py-2 border text-right">Total Diskon</th>
                        <th class="px-4 py-2 border text-right">Total Akhir</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($penawaran as $p)
                        @php
                            $itemsArray = $p->items->map(function($it){
                                $hargaSatuan = (float) ($it->harga_satuan ?? 0);
                                $qty = (int) ($it->qty ?? 0);
                                $bulan = (int) ($it->bulan ?? 1);
                                $hargaQty = $hargaSatuan * $qty;
                                $hargaTotalBulan = $hargaQty * $bulan;
                                $diskonRp = (float) ($it->diskon_nominal ?? 0);
                                $psb = (float) ($it->psb ?? 0);
                                $subtotal = $hargaTotalBulan - $diskonRp + $psb;

                                return [
                                    'produk'          => $it->produk->nama_produk ?? '',
                                    'qty'             => $qty,
                                    'bulan'           => $bulan,
                                    'hargaSatuan'     => $hargaSatuan,
                                    'hargaQty'        => $hargaQty,
                                    'hargaTotalBulan' => $hargaTotalBulan,
                                    'diskon'          => (float) ($it->diskon ?? 0),
                                    'diskonRp'        => $diskonRp,
                                    'psb'             => $psb,
                                    'subtotal'        => $subtotal,
                                ];
                            });
                        @endphp

                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                            <td class="px-4 py-2 border">{{ $p->nama }}</td>
                            <td class="px-4 py-2 border text-right">{{ number_format($p->total_harga,0,',','.') }}</td>
                            <td class="px-4 py-2 border text-right text-red-600">-{{ number_format($p->total_diskon,0,',','.') }}</td>
                            <td class="px-4 py-2 border text-right font-semibold text-green-600">{{ number_format($p->total_akhir,0,',','.') }}</td>
                            <td class="px-4 py-2 border text-center">
                                <button 
                                    class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-xs"
                                    @click='transaksi = { 
                                        nama: "{{ $p->nama }}", 
                                        total: {{ $p->total_harga ?? 0 }}, 
                                        totalDiskon: {{ $p->total_diskon ?? 0 }}, 
                                        totalPpn: {{ $p->total_ppn ?? 0 }},
                                        akhir: {{ $p->total_akhir ?? 0 }}, 
                                        items: @json($itemsArray)
                                    }; show = true'>
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div x-show="show" 
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" 
         x-cloak>
        <div class="bg-white rounded-xl shadow-lg w-full max-w-6xl p-6" @click.away="show = false">
            <h3 class="text-lg font-semibold mb-3">Detail Penawaran</h3>

            <div class="mb-4 text-gray-700 text-sm">
                <p><span class="font-semibold">Konsumen:</span> <span x-text="transaksi.nama"></span></p>
            </div>

            <div class="overflow-x-auto max-h-96 overflow-y-auto rounded-lg border">
                <table class="min-w-full text-sm border-collapse">
                    <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                        <tr>
                            <th class="px-3 py-2 border">Produk</th>
                            <th class="px-3 py-2 border">Qty</th>
                            <th class="px-3 py-2 border">Bulan</th>
                            <th class="px-3 py-2 border">Harga Satuan</th>
                            <th class="px-3 py-2 border">Total Harga × Qty</th>
                            <th class="px-3 py-2 border">Total Harga × Bulan</th>
                            <th class="px-3 py-2 border">Diskon (Rp)</th>
                            <th class="px-3 py-2 border">Diskon (%)</th>
                            <th class="px-3 py-2 border">Biaya PSB</th>
                            <th class="px-3 py-2 border">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in transaksi.items" :key="index">
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-3 py-2 border" x-text="item.produk"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.qty"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.bulan"></td>
                                <td class="px-3 py-2 border text-right" x-text="formatRupiah(item.hargaSatuan)"></td>
                                <td class="px-3 py-2 border text-right" x-text="formatRupiah(item.hargaQty)"></td>
                                <td class="px-3 py-2 border text-right" x-text="formatRupiah(item.hargaTotalBulan)"></td>
                                <td class="px-3 py-2 border text-right text-red-600" x-text="formatRupiah(item.diskonRp)"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.diskon + '%'"></td>
                                <td class="px-3 py-2 border text-right" x-text="formatRupiah(item.psb)"></td>
                                <td class="px-3 py-2 border text-right text-green-600 font-semibold" x-text="formatRupiah(item.subtotal)"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold text-gray-800">
                        <tr>
                            <td colspan="9" class="px-3 py-2 border text-right">Total Sebelum PPN</td>
                            <td class="px-3 py-2 border text-right" x-text="formatRupiah(transaksi.total)"></td>
                        </tr>
                        <tr>
                            <td colspan="9" class="px-3 py-2 border text-right">PPN</td>
                            <td class="px-3 py-2 border text-right" x-text="formatRupiah(transaksi.totalPpn)"></td>
                        </tr>
                        <tr class="border-t-2 border-gray-300">
                            <td colspan="9" class="px-3 py-2 border text-right">Total Akhir</td>
                            <td class="px-3 py-2 border text-right text-green-600" x-text="formatRupiah(transaksi.akhir)"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 text-right">
                <button class="px-5 py-2 bg-blue-900 text-white rounded-lg hover:opacity-90 transition"
                        @click="show = false">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function formatRupiah(n) {
        return "Rp " + (Number(n) || 0).toLocaleString('id-ID');
    }
</script>

@endsection
