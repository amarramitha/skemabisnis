@extends('layouts.admin')

@section('title', 'Riwayat Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Riwayat Penawaran
        </h2>

        <div class="space-y-4">
            @foreach($penawaran as $p)
                @php
                    $itemsArray = $p->items->map(function($it){
                        $hargaSatuan = (float) ($it->harga_satuan ?? 0);
                        $qty = (int) ($it->qty ?? 0);
                        $bulan = (int) ($it->bulan ?? 1);
                        $psb = (float) ($it->psb ?? 0);
                        $diskonRp = (float) ($it->diskon_nominal ?? 0);
                        $subtotal = ($hargaSatuan * $qty * $bulan) + $psb - $diskonRp;
                        return [
                            'produk' => $it->produk->nama_produk ?? '',
                            'qty' => $qty,
                            'bulan' => $bulan,
                            'hargaSatuan' => $hargaSatuan,
                            'mc' => $hargaSatuan * $qty,
                            'total' => $hargaSatuan * $qty * $bulan,
                            'psb' => $psb,
                            'diskonRp' => $diskonRp,
                            'diskon' => (float) ($it->diskon ?? 0),
                            'subtotal' => $subtotal
                        ];
                    });
                    $totalHarga = $itemsArray->sum('total') + $itemsArray->sum('psb');
                    $totalDiskon = $itemsArray->sum('diskonRp') + ($totalHarga * ($p->diskon_layanan/100));
                    $totalAkhir = $totalHarga - $totalDiskon + ($p->total_ppn ?? 0);
                @endphp

                <div x-data="{ open: false }" class="p-4 border rounded-lg shadow-sm">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold">{{ $p->nama }}</span>
                        <button @click="open = true" class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Detail
                        </button>
                    </div>

                    <!-- Modal -->
                    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div @click.away="open = false" class="bg-white rounded-2xl shadow-lg w-11/12 max-w-6xl p-6 overflow-auto max-h-[90vh]">
                            <h3 class="text-lg font-bold mb-4">Ringkasan Penawaran - {{ $p->nama }}</h3>

                            <div class="overflow-x-auto rounded-xl border shadow-md">
                                <table class="min-w-[1000px] text-sm border-collapse w-full">
                                    <thead>
                                        <tr class="bg-gray-800 text-white text-xs uppercase">
                                            <th rowspan="2" class="px-3 py-3 text-left">No</th>
                                            <th rowspan="2" class="px-3 py-3 text-left">Item</th>
                                            <th rowspan="2" class="px-3 py-3 text-center">Jumlah</th>
                                            <th rowspan="2" class="px-3 py-3 text-center">Durasi (Bulan)</th>
                                            <th colspan="3" class="px-3 py-2 text-center bg-blue-700">Tarif Dasar</th>
                                            <th colspan="2" class="px-3 py-3 text-center">PSB</th>
                                            <th rowspan="2" class="px-3 py-2 text-center bg-red-600">Diskon</th>
                                            <th colspan="3" class="px-3 py-2 text-center bg-green-700">Harga Penawaran</th>
                                        </tr>
                                        <tr class="bg-gray-700 text-white text-xs uppercase">
                                            <th class="px-3 py-2 text-center">Satuan</th>
                                            <th class="px-3 py-2 text-center">MC</th>
                                            <th class="px-3 py-2 text-center">Total</th>
                                            <th class="px-3 py-2 text-center">Biaya</th>
                                            <th class="px-3 py-2 text-center">Diskon</th>
                                            <th class="px-3 py-2 text-center">Satuan</th>
                                            <th class="px-3 py-2 text-center">MC</th>
                                            <th class="px-3 py-2 text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 text-gray-700">
                                        @foreach($itemsArray as $i => $item)
                                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                                                <td class="px-3 py-2 text-center">{{ $i+1 }}</td>
                                                <td class="px-3 py-2">{{ $item['produk'] }}</td>
                                                <td class="px-3 py-2 text-center">{{ $item['qty'] }}</td>
                                                <td class="px-3 py-2 text-center">{{ $item['bulan'] }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['hargaSatuan'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['mc'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['total'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['psb'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-center">-</td>
                                                <td class="px-3 py-2 text-center text-red-600">{{ $item['diskon'] }}%</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['hargaSatuan'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['mc'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right font-medium text-green-600">{{ number_format($item['subtotal'],0,',','.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-sm font-semibold">
                                        <tr class="bg-gray-100">
                                            <td colspan="12" class="px-3 py-2 text-right font-medium">Total Akhir:</td>
                                            <td class="px-3 py-2 text-right text-green-700 font-bold">{{ number_format($totalAkhir,0,',','.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="flex justify-end mt-4">
                                <button @click="open = false" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
