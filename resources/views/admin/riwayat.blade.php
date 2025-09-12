@extends('layouts.admin')

@section('title', 'Riwayat Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6"
    x-data="{ show: false, transaksi: { nama: '', items: [], total: 0, totalDiskon: 0, akhir: 0 } }">

    {{-- Flash Message --}}
    @if (session('success'))
    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Penawaran</h2>
    </div>

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
                        <ul class="list-disc ml-5">
                            @foreach($p->items as $item)
                            <li>
                                {{ $item->produk->nama_produk }}
                                (Harga: Rp {{ number_format($item->harga_awal, 0, ',', '.') }},
                                Diskon: {{ $item->diskon }}%,
                                Harga Akhir: Rp {{ number_format($item->harga_akhir, 0, ',', '.') }})
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <span class="text-gray-500">Tidak ada produk</span>
                        @endif
                    </td>
                    <td class="px-6 py-3 text-center">
                        <button
                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700"
                            @click="
            transaksi.nama = '{{ $p->nama }}';
            transaksi.items = [
                @foreach($p->items as $item)
                    {
                        produk: '{{ $item->produk->nama_produk ?? '' }}',
                        harga: {{ $item->harga_awal ?? 0 }},
                        qty: {{ $item->qty ?? 0 }},
                        diskon: {{ $item->diskon ?? 0 }}
                    }@if(!$loop->last),@endif
                @endforeach
            ];
            transaksi.total = transaksi.items.reduce((acc, i) => acc + (i.harga * i.qty), 0);
            transaksi.totalDiskon = transaksi.items.reduce((acc, i) => acc + ((i.harga * i.qty) * (i.diskon / 100)), 0);
            transaksi.akhir = transaksi.total - transaksi.totalDiskon;
            show = true;
        ">
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
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl p-6" @click.away="show = false">
            <h3 class="text-lg font-semibold mb-3">Detail Penawaran</h3>

            <p class="mb-3 text-gray-700">
                <span class="font-semibold">Konsumen:</span> <span x-text="transaksi.nama"></span>
            </p>

            {{-- Tabel Produk --}}
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border border-gray-200 text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 border">Produk</th>
                            <th class="px-3 py-2 border">Harga Satuan</th>
                            <th class="px-3 py-2 border">Qty</th>
                            <th class="px-3 py-2 border">Diskon (%)</th>
                            <th class="px-3 py-2 border">Total Diskon</th>
                            <th class="px-3 py-2 border">Harga Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in transaksi.items" :key="item.produk">
                            <tr>
                                <td class="px-3 py-2 border" x-text="item.produk"></td>
                                <td class="px-3 py-2 border" x-text="`Rp ${item.harga.toLocaleString()}`"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.qty"></td>
                                <td class="px-3 py-2 border text-center" x-text="item.diskon + '%'"></td>
                                <td class="px-3 py-2 border"
                                    x-text="`Rp ${((item.harga * item.qty) * (item.diskon / 100)).toLocaleString()}`"></td>
                                <td class="px-3 py-2 border"
                                    x-text="`Rp ${((item.harga * item.qty) - ((item.harga * item.qty) * (item.diskon / 100))).toLocaleString()}`"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50 font-semibold">
                        <tr>
                            <td class="px-3 py-2 border text-right" colspan="1">Total</td>
                            <td class="px-3 py-2 border" x-text="`Rp ${transaksi.total.toLocaleString()}`"></td>
                            <td class="px-3 py-2 border"></td>
                            <td class="px-3 py-2 border"></td>
                            <td class="px-3 py-2 border" x-text="`Rp ${transaksi.totalDiskon.toLocaleString()}`"></td>
                            <td class="px-3 py-2 border" x-text="`Rp ${transaksi.akhir.toLocaleString()}`"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 text-right">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    @click="show = false">Tutup</button>
            </div>
        </div>
    </div>

</div>
@endsection