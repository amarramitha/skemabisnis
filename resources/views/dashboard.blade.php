@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Header --}}
    <h1 class="text-2xl font-bold mb-6">Selamat Datang, Admin 👋</h1>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Jumlah Produk</p>
            <h2 class="text-2xl font-bold text-indigo-600">125</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Total Penawaran</p>
            <h2 class="text-2xl font-bold text-green-600">58</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Transaksi Berhasil</p>
            <h2 class="text-2xl font-bold text-blue-600">42</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Transaksi Ditolak</p>
            <h2 class="text-2xl font-bold text-red-600">16</h2>
        </div>
    </div>

    {{-- Grafik Dummy (pakai gambar statis dulu) --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Grafik Penawaran Bulanan</h2>
        <div class="w-full h-48 flex items-center justify-center text-gray-400 border-2 border-dashed rounded-lg">
            (Grafik dummy – bisa pakai Chart.js nanti)
        </div>
    </div>

    {{-- Tabel Ringkas --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Penawaran Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-red-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Total Harga</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">1</td>
                        <td class="px-6 py-3">Budi</td>
                        <td class="px-6 py-3">Laptop ASUS</td>
                        <td class="px-6 py-3">Rp 10.000.000</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Diterima</span>
                        </td>
                        <td class="px-6 py-3">04 Sep 2025</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">2</td>
                        <td class="px-6 py-3">Siti</td>
                        <td class="px-6 py-3">Smartphone Samsung</td>
                        <td class="px-6 py-3">Rp 3.500.000</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Proses</span>
                        </td>
                        <td class="px-6 py-3">03 Sep 2025</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-3">3</td>
                        <td class="px-6 py-3">Andi</td>
                        <td class="px-6 py-3">Printer Epson</td>
                        <td class="px-6 py-3">Rp 2.000.000</td>
                        <td class="px-6 py-3">
                            <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Ditolak</span>
                        </td>
                        <td class="px-6 py-3">02 Sep 2025</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <a href="{{ route('riwayat') }}" class="text-indigo-600 hover:underline text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
    </div>

</div>

</div>
@endsection