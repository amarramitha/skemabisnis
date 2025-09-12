@extends('layouts.admin')

@section('title', 'Riwayat Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6"
     x-data="{
        show: false,
        transaksi: { nama: '', items: [], total: 0, totalDiskon: 0, totalDiskonPersen: 0, totalPpn: 0, akhir: 0 },

        showDetail(items, nama) {
            this.transaksi.nama = nama ?? '';

            this.transaksi.items = (items || []).map(i => {
                const qty = Number(i.qty || 1);
                const hargaTotal = Number(i.harga_total || 0);
                const diskon = Number(i.diskon || 0);
                const hargaSatuan = qty ? (hargaTotal / qty) : hargaTotal;

                const potongan = Math.round(hargaTotal * (diskon / 100));
                const hargaSetelahDiskon = hargaTotal - potongan;
                const ppnRp = Math.round(hargaSetelahDiskon * 0.11);
                const hargaAkhirTotal = hargaSetelahDiskon + ppnRp;

                return {
                    produk: i.produk || '-',
                    qty,
                    hargaTotal,
                    hargaSatuan,
                    diskon,
                    diskonRp: potongan,
                    ppnRp,
                    hargaAkhir: hargaAkhirTotal
                };
            });

            // hitung total
            this.transaksi.total = this.transaksi.items.reduce((a, it) => a + it.hargaTotal, 0);
            this.transaksi.totalDiskon = this.transaksi.items.reduce((a, it) => a + it.diskonRp, 0);
            this.transaksi.totalPpn = this.transaksi.items.reduce((a, it) => a + it.ppnRp, 0);
            this.transaksi.akhir = this.transaksi.items.reduce((a, it) => a + it.hargaAkhir, 0);
            this.transaksi.totalDiskonPersen = this.transaksi.total > 0 
                ? Math.round((this.transaksi.totalDiskon / this.transaksi.total) * 100) 
                : 0;

            this.show = true;
        }
     }">

    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Penawaran</h2>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Detail Produk</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                @forelse($penawaran as $index => $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3">{{ $p->nama }}</td>
                        <td class="px-6 py-3">{{ $p->created_at->format('d-m-Y') }}</td>
                        <td class="px-6 py-3">
                            @if($p->items->count() > 0)
                                <span class="font-medium">{{ $p->items->count() }} produk</span><br>
                                <span class="text-gray-500 text-xs">
                                    {{ $p->items->pluck('produk.nama_produk')->take(2)->join(', ') }}
                                    @if($p->items->count() > 2), dll @endif
                                </span>
                            @else
                                <span class="text-gray-500">Tidak ada produk</span>
                            @endif
                        </td>
                        <td class="px-6 py-3 text-center">
                            @php
                                $itemsJson = $p->items->map(function($it){
                                    $qty = $it->qty ?? 1;
                                    $hargaAwal = $it->harga_awal ?? 0;
                                    return [
                                        'produk' => $it->produk->nama_produk ?? '',
                                        'qty' => (int) $qty,
                                        'harga_total' => (float) $hargaAwal,
                                        'hargaSatuan' => $qty ? $hargaAwal / $qty : $hargaAwal,
                                        'diskon' => (float) ($it->diskon ?? 0),
                                    ];
                                })->toJson();
                            @endphp
                            <button
                                class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                                @click='showDetail({!! $itemsJson !!}, {!! json_encode($p->nama) !!})'>
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-3 text-center text-gray-500">
                            Belum ada penawaran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

{{-- Modal Detail Penawaran --}}
<div x-show="show" x-transition.opacity x-transition.scale
     class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
     x-cloak>
    <div class="bg-white rounded-xl shadow-lg w-full max-w-5xl p-6" @click.away="show = false">
        <h3 class="text-lg font-semibold mb-3">Detail Penawaran</h3>

        <div class="mb-4 text-gray-700 text-sm">
            <p><span class="font-semibold">Konsumen:</span> <span x-text="transaksi.nama"></span></p>
            <p><span class="font-semibold">Jumlah Produk:</span> <span x-text="transaksi.items.length"></span></p>
        </div>

        <div class="overflow-x-auto max-h-80 overflow-y-auto rounded-lg border">
            <table class="min-w-full border-collapse text-sm">
                <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                    <tr>
                        <th class="px-3 py-2 border text-left font-semibold">Produk</th>
                        <th class="px-3 py-2 border text-right font-semibold">Harga Satuan</th>
                        <th class="px-3 py-2 border text-center font-semibold">Qty</th>
                        <th class="px-3 py-2 border text-right font-semibold">Harga Total</th>
                        <th class="px-3 py-2 border text-center font-semibold">Diskon (%)</th>
                        <th class="px-3 py-2 border text-right font-semibold">Potongan</th>
                        <th class="px-3 py-2 border text-right font-semibold">PPN (11%)</th>
                        <th class="px-3 py-2 border text-right font-semibold">Harga Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-gray-700">
                    <template x-for="(item, index) in transaksi.items" :key="index">
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border" x-text="item.produk"></td>
                            <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(item.harga_satuan).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-center" x-text="item.qty"></td>
                            <td class="px-3 py-2 border text-right font-medium" x-text="`Rp ${Number(item.harga_total).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-center" x-text="item.diskon + '%'"></td>
                            <td class="px-3 py-2 border text-right text-red-600" x-text="`Rp ${Number(item.diskon_nominal).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(item.ppn_nominal).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-right font-medium text-green-600" x-text="`Rp ${Number(item.harga_akhir).toLocaleString('id-ID')}`"></td>
                        </tr>
                    </template>
                </tbody>
                <tfoot class="bg-gray-50 font-semibold text-gray-800">
                    <tr>
                        <td colspan="3" class="px-3 py-2 border text-right">TOTAL</td>
                        <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(transaksi.total_harga).toLocaleString('id-ID')}`"></td>
                        <td class="px-3 py-2 border text-center" x-text="transaksi.total_diskon_persen + '%'"></td>
                        <td class="px-3 py-2 border text-right text-red-600" x-text="`Rp ${Number(transaksi.total_diskon).toLocaleString('id-ID')}`"></td>
                        <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(transaksi.total_ppn).toLocaleString('id-ID')}`"></td>
                        <td class="px-3 py-2 border text-right text-green-600" x-text="`Rp ${Number(transaksi.total_akhir).toLocaleString('id-ID')}`"></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="mt-6 text-right">
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    @click="show = false">
                Tutup
            </button>
        </div>
    </div>
</div>

</div>
@endsection
