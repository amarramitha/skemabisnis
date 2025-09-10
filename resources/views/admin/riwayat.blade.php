@extends('layouts.admin')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="container mx-auto px-6 py-6">

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
                {{-- Data Dummy --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Andi</td>
                    <td class="px-6 py-3">Laptop ASUS</td>
                    <td class="px-6 py-3">Rp 10.000.000</td>
                    <td class="px-6 py-3">Rp 8.500.000</td>
                    <td class="px-6 py-3">Rp 9.000.000</td>
                    <td class="px-6 py-3">04 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            onclick="alert('Dummy detail kalkulasi Andi: Harga Normal Rp10.000.000 → Diskon 20% Rp8.000.000, Penawaran Rp8.500.000, Harga Final Rp9.000.000')">
                            Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Budi</td>
                    <td class="px-6 py-3">Smartphone Samsung</td>
                    <td class="px-6 py-3">Rp 5.000.000</td>
                    <td class="px-6 py-3">Rp 3.000.000</td>
                    <td class="px-6 py-3">Rp 4.250.000</td>
                    <td class="px-6 py-3">03 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            onclick="alert('Dummy detail kalkulasi Budi: Harga Normal Rp5.000.000 → Diskon 20% Rp4.000.000, Penawaran Rp3.000.000, Harga Final Rp4.250.000')">
                            Lihat
                        </button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">3</td>
                    <td class="px-6 py-3">Citra</td>
                    <td class="px-6 py-3">Headset JBL</td>
                    <td class="px-6 py-3">Rp 1.200.000</td>
                    <td class="px-6 py-3">Rp 500.000</td>
                    <td class="px-6 py-3">-</td>
                    <td class="px-6 py-3">02 Sep 2025</td>
                    <td class="px-6 py-3">
                        <button class="text-blue-600 hover:underline"
                            onclick="alert('Dummy detail kalkulasi Citra: Harga Normal Rp1.200.000 → Diskon 20% Rp960.000, Penawaran Rp500.000, Transaksi Gagal')">
                            Lihat
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection