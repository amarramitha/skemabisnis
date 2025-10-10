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
                        $diskonPersen = (float) ($it->diskon ?? 0);
                        $diskonPsbPersen = (float) ($it->diskon_psb ?? 0);

                        $mc = $hargaSatuan * $qty;
                        $total = $mc * $bulan;

                        $potonganLayanan = $total * ($diskonPersen/100);
                        $potonganPsb = $psb * ($diskonPsbPersen/100);
                        $hargaSatuanSetelahDiskon = $hargaSatuan * (1 - $diskonPersen / 100);
                        $mcSetelahDiskon = $hargaSatuanSetelahDiskon * $qty;

                        $subtotal = ($total - $potonganLayanan) + ($psb - $potonganPsb);

                        return [
                            'produk' => $it->produk->nama_produk ?? '',
                            'qty' => $qty,
                            'bulan' => $bulan,
                            'hargaSatuan' => $hargaSatuan,
                            'mc' => $mc,
                            'total' => $total,
                            'psb' => $psb,
                            'diskonPersen' => $diskonPersen,
                            'diskonPsbPersen' => $diskonPsbPersen,
                            'potonganLayanan' => $potonganLayanan,
                            'potonganPsb' => $potonganPsb,
                            'hargaSatuanPenawaran' => $hargaSatuanSetelahDiskon,
                            'mcPenawaran' => $mcSetelahDiskon,
                            'subtotal' => $subtotal
                        ];
                    });

                    // hitung total sebelum PPN
                    $totalTarif = $itemsArray->sum('total');
                    $totalPsb = $itemsArray->sum('psb');
                    $totalPotonganLayanan = $itemsArray->sum('potonganLayanan');
                    $totalPotonganPsb = $itemsArray->sum('potonganPsb');
                    $totalDiskonNominal = $totalPotonganLayanan + $totalPotonganPsb;

                    // diskon persentase
                    $totalDiskonPersen = ($totalTarif + $totalPsb) > 0 
                        ? ($totalDiskonNominal / ($totalTarif + $totalPsb)) * 100 
                        : 0;

                    // PPN
                    $ppnPersen = (float) ($p->ppn ?? 0);
                    $ppnNominal = ($totalTarif + $totalPsb - $totalDiskonNominal) * ($ppnPersen/100);

                    // total akhir
                    $totalAkhir = ($totalTarif + $totalPsb - $totalDiskonNominal) + $ppnNominal;
                @endphp

                <div x-data="{ open: false }" class="p-4 border rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <span class="font-semibold">{{ $p->nama }}</span>

                        <div class="flex items-center space-x-2 ml-auto">
                            <button @click="open = true" 
                                class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Detail
                            </button>

                            <form action="{{ route('penawaran.destroy', $p->id) }}" method="POST" 
                                onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                    class="px-3 py-1 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>

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
                                            <th rowspan="2" class="px-3 py-2 text-center bg-red-600">Diskon</th>
                                            <th colspan="2" class="px-3 py-3 text-center">PSB</th>
                                            
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
                                                <td class="px-3 py-2 text-center text-red-600">{{ number_format($item['diskonPersen'],2) }}%</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['psb'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-center">{{ number_format($item['diskonPsbPersen'],2) }}%</td>
                                                
                                                <td class="px-3 py-2 text-right text-green-600">{{ number_format($item['hargaSatuanPenawaran'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right">{{ number_format($item['mcPenawaran'],0,',','.') }}</td>
                                                <td class="px-3 py-2 text-right font-medium text-green-600">{{ number_format($item['subtotal'],0,',','.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="text-sm font-semibold">
                                        <tr class="bg-gray-100">
                                            <td colspan="4" class="px-3 py-2 text-right font-medium">Sub Total:</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($itemsArray->sum('hargaSatuan'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($itemsArray->sum('mc'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($itemsArray->sum('total'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-center text-red-600">{{ number_format($totalPotonganLayanan > 0 ? ($totalPotonganLayanan / $totalTarif * 100) : 0,2) }}%</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($itemsArray->sum('psb'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-center">{{ number_format($totalPotonganPsb > 0 ? ($totalPotonganPsb / $totalPsb * 100) : 0,2) }}%</td>
                                            
                                            <td class="px-3 py-2 text-right text-green-600">{{ number_format($itemsArray->sum('hargaSatuanPenawaran'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($itemsArray->sum('mcPenawaran'),0,',','.') }}</td>
                                            <td class="px-3 py-2 text-right text-green-700">{{ number_format($itemsArray->sum('subtotal'),0,',','.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" class="px-3 py-2 text-right">Total:</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($totalTarif + $totalPsb - $totalDiskonNominal,0,',','.') }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="12" class="px-3 py-2 text-right">PPN ({{ $ppnPersen }}%):</td>
                                            <td class="px-3 py-2 text-right">{{ number_format($ppnNominal,0,',','.') }}</td>
                                        </tr>
                                        <tr class="bg-green-100 border-t-2 border-green-400">
                                            <td colspan="12" class="px-3 py-3 text-right font-bold">Total Akhir:</td>
                                            <td class="px-3 py-3 text-right text-green-700 font-bold">{{ number_format($totalAkhir,0,',','.') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="flex justify-end mt-4 space-x-3">
                            <!-- Tombol Print -->
                            <button onclick="printPenawaran('{{ $p->id }}', '{{ $p->nama }}')" 
                                class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-800 flex items-center">
                                <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Print
                            </button>
                            <!-- Tombol Tutup -->
                            <button @click="open = false" 
                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
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

<script>
function printPenawaran(id, namaKonsumen) {
    const button = event.target.closest('button');
    const modal = button.closest('.fixed');
    if (!modal) return;

    const tableContent = modal.querySelector('table').outerHTML;

    const printWindow = window.open('', '_blank', 'width=1000,height=800');
    printWindow.document.write(`
        <html>
        <head>
            <title>Penawaran - ${namaKonsumen}</title>
            <style>
                body { 
                    font-family: Arial, sans-serif; 
                    padding: 20px; 
                    color: #111827;
                }
                h1 { 
                    color: #1e3a8a; 
                    text-align: center; 
                    margin-bottom: 5px;
                }
                h3 {
                    text-align: center;
                    color: #374151;
                    margin-top: 0;
                    font-weight: normal;
                }
                table { 
                    width: 100%; 
                    border-collapse: collapse; 
                    margin-top: 20px;
                }
                th, td { 
                    border: 1px solid #999; 
                    padding: 8px; 
                    text-align: right; 
                    font-size: 12px;
                }
                th { 
                    background-color: #e5e7eb; 
                    color: #111827; 
                    text-align: center;
                }
                td:nth-child(2) { 
                    text-align: left; 
                }
                tfoot td { 
                    font-weight: bold; 
                    background-color: #f3f4f6;
                }
            </style>
        </head>
        <body>
            <h1>${namaKonsumen}</h1>
            <h3>Detail Penawaran</h3>
            ${tableContent}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.onload = () => printWindow.print();
}
</script>

@endsection
