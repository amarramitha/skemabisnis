@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto px-6 py-6"
    x-data="{ show: false, transaksi: { nama: '', items: [], total: 0, totalDiskon: 0, akhir: 0 } }">

    {{-- Flash Message (opsional) --}}
    @if (session('success'))
    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Transaksi</h2>

    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Andi</td>
                    <td class="px-6 py-3">04 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            @click="transaksi = { 
                                nama: 'Andi',
                                items: [
                                    { produk: 'Laptop ASUS', harga: 10000000, qty: 2, diskon: 20 },
                                    { produk: 'Mouse Logitech', harga: 500000, qty: 1, diskon: 10 }
                                ]
                            };
                            transaksi.total = transaksi.items.reduce((sum, i) => sum + (i.harga * i.qty), 0);
                            transaksi.totalDiskon = transaksi.items.reduce((sum, i) => sum + ((i.harga * i.qty) * (i.diskon/100)), 0);
                            transaksi.akhir = transaksi.total - transaksi.totalDiskon;
                            show = true">
                            Lihat
                        </button>
                    </td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Budi</td>
                    <td class="px-6 py-3">03 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            @click="transaksi = { 
                                nama: 'Budi',
                                items: [
                                    { produk: 'Smartphone Samsung', harga: 5000000, qty: 1, diskon: 15 }
                                ]
                            };
                            transaksi.total = transaksi.items.reduce((sum, i) => sum + (i.harga * i.qty), 0);
                            transaksi.totalDiskon = transaksi.items.reduce((sum, i) => sum + ((i.harga * i.qty) * (i.diskon/100)), 0);
                            transaksi.akhir = transaksi.total - transaksi.totalDiskon;
                            show = true">
                            Lihat
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-show="show" x-transition.opacity x-transition.scale
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-cloak>
        <div class="bg-white rounded-xl shadow-lg w-[36rem] p-6" @click.away="show = false">
            <h3 class="text-lg font-semibold mb-3">Detail Transaksi</h3>

            <!-- Nama konsumen -->
            <p class="mb-3 text-gray-700"><span class="font-semibold">Konsumen:</span> <span x-text="transaksi.nama"></span></p>

            <!-- Tabel produk -->
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
                                    x-text="`Rp ${((item.harga * item.qty) * (item.diskon/100)).toLocaleString()}`"></td>
                                <td class="px-3 py-2 border"
                                    x-text="`Rp ${((item.harga * item.qty) - ((item.harga * item.qty) * (item.diskon/100))).toLocaleString()}`"></td>
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

            <!-- Tombol tutup -->
            <div class="mt-4 text-right">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    @click="show = false">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection