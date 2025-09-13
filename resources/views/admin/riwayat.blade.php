@extends('layouts.admin')

@section('title', 'Riwayat Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6"
     x-data="{
        show: false,
        transaksi: { nama: '', items: [], total: 0, totalDiskon: 0, totalDiskonPersen: 0, totalPpn: 0, akhir: 0 },

        showDetail(items, nama, total, totalDiskon, totalDiskonPersen, totalAkhir) {
            this.transaksi.nama = nama ?? '';
            this.transaksi.items = items || [];
            this.transaksi.total = total;
            this.transaksi.totalDiskon = totalDiskon;
            this.transaksi.totalDiskonPersen = totalDiskonPersen;
            this.transaksi.akhir = totalAkhir;
            this.transaksi.totalPpn = this.transaksi.items.reduce((a, it) => a + (it.ppnRp || 0), 0);
            this.show = true;
        }
     }">

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow-md animate-fade-in">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Penawaran</h2>

    {{-- Table --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-md hover:shadow-lg transition">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                @forelse($penawaran as $index => $p)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-3">{{ $index + 1 }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ $p->nama }}</td>
                        <td class="px-6 py-3">{{ $p->created_at->format('d-m-Y') }}</td>
                        <td class="px-6 py-3 text-center">
                            @php
                                $itemsJson = $p->items->map(function($it){
                                    return [
                                        'produk'      => $it->produk->nama_produk ?? '',
                                        'qty'         => (int) $it->qty,
                                        'harga_total' => (float) $it->harga_total,
                                        'hargaSatuan' => (float) $it->harga_satuan,
                                        'diskon'      => (float) ($it->diskon ?? 0),
                                        'diskonRp'    => (float) ($it->diskon_nominal ?? 0),
                                        'ppnRp'       => (float) ($it->ppn_nominal ?? 0),
                                        'hargaAkhir'  => (float) ($it->harga_akhir ?? 0),
                                    ];
                                })->toJson();
                            @endphp
                            <button
                                class="px-4 py-2 bg-blue-900 text-white rounded-lg shadow hover:opacity-90 transition"
                                @click='showDetail({!! $itemsJson !!}, {!! json_encode($p->nama) !!}, {{ $p->total_harga }}, {{ $p->total_diskon }}, {{ $p->total_diskon_persen }}, {{ $p->total_akhir }})'>
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-center text-gray-500">
                            Belum ada penawaran
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    <div x-show="show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-cloak>
         
        <div class="bg-white rounded-xl shadow-lg w-full max-w-5xl p-6"
             @click.away="show = false">
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
                    <tbody class="text-gray-700">
                        <template x-for="(item, index) in transaksi.items" :key="index">
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100 transition">
                                <td class="px-3 py-2 border" x-text="item.produk"></td>
                                <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(item.hargaSatuan).toLocaleString('id-ID')}`"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.qty"></td>
                                <td class="px-3 py-2 border text-right font-medium" x-text="`Rp ${Number(item.harga_total).toLocaleString('id-ID')}`"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.diskon + '%'"></td>
                                <td class="px-3 py-2 border text-right text-red-600" x-text="`Rp ${Number(item.diskonRp).toLocaleString('id-ID')}`"></td>
                                <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(item.ppnRp).toLocaleString('id-ID')}`"></td>
                                <td class="px-3 py-2 border text-right font-medium text-green-600" x-text="`Rp ${Number(item.hargaAkhir).toLocaleString('id-ID')}`"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold text-gray-800">
                        <tr>
                            <td colspan="3" class="px-3 py-2 border text-right">TOTAL</td>
                            <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(transaksi.total).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-center" x-text="transaksi.totalDiskonPersen + '%'"></td>
                            <td class="px-3 py-2 border text-right text-red-600" x-text="`Rp ${Number(transaksi.totalDiskon).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-right" x-text="`Rp ${Number(transaksi.totalPpn).toLocaleString('id-ID')}`"></td>
                            <td class="px-3 py-2 border text-right text-green-600" x-text="`Rp ${Number(transaksi.akhir).toLocaleString('id-ID')}`"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-6 text-right">
                <button class="px-5 py-2 bg-blue-900 text-white rounded-lg shadow hover:opacity-90 transition"
                        @click="show = false">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
