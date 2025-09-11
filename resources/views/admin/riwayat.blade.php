@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto px-6 py-6" x-data="{ show: false, detail: '' }">

    {{-- Flash Message (opsional) --}}
    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Transaksi</h2>
        <p class="text-gray-600 text-sm">Daftar riwayat transaksi dan hasil kalkulasi penawaran per orang</p>
    </div>

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Normal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Akhir</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Final</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Andi</td>
                    <td class="px-6 py-3">Laptop ASUS</td>
                    <td class="px-6 py-3">Rp 10.000.000</td>
                    <td class="px-6 py-3">Rp 8.000.000</td>
                    <td class="px-6 py-3">Rp 8.500.000</td>
                    <td class="px-6 py-3">04 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            @click="detail = 'Andi\nHarga Normal Rp10.000.000\nDiskon 20% → Rp8.000.000\nPenawaran: Rp8.500.000\nHarga Final: Rp8.500.000'; show = true">
                            Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Budi</td>
                    <td class="px-6 py-3">Smartphone Samsung</td>
                    <td class="px-6 py-3">Rp 5.000.000</td>
                    <td class="px-6 py-3">Rp 4.250.000</td>
                    <td class="px-6 py-3">Rp 4.250.000</td>
                    <td class="px-6 py-3">03 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            @click="detail = 'Budi\nHarga Normal Rp5.000.000\nDiskon 15% → Rp4.250.000\nPenawaran: Rp4.250.000\nHarga Final: Rp4.250.000'; show = true">
                            Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">3</td>
                    <td class="px-6 py-3">Citra</td>
                    <td class="px-6 py-3">Headset JBL</td>
                    <td class="px-6 py-3">Rp 1.200.000</td>
                    <td class="px-6 py-3">Rp 960.000</td>
                    <td class="px-6 py-3">-</td>
                    <td class="px-6 py-3">02 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            @click="detail = 'Citra\nHarga Normal Rp1.200.000\nDiskon 20% → Rp960.000\nPenawaran: Rp500.000\nTransaksi gagal karena terlalu rendah'; show = true">
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
        <div class="bg-white rounded-xl shadow-lg w-96 p-6" @click.away="show = false">
            <h3 class="text-lg font-semibold mb-3">Detail Transaksi</h3>
            <pre class="text-gray-700 whitespace-pre-line" x-text="detail"></pre>
            <div class="mt-4 text-right">
                <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    @click="show = false">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
