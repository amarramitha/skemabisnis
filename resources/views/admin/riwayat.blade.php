@extends('layouts.admin') {{-- pastikan path sesuai dengan tempat kamu simpan layout admin --}}

@section('title', 'Riwayat Transaksi')

@section('content')

<div class="container mx-auto px-6 py-6">

    {{-- Flash Message (opsional) --}}
    @if (session('success'))
    <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
        {{ session('success') }}
    </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Normal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Penawaran Konsumen</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Final</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                {{-- Data Dummy --}}
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Laptop ASUS</td>
                    <td class="px-6 py-3">Rp 10.000.000</td>
                    <td class="px-6 py-3">Rp 8.500.000</td>
                    <td class="px-6 py-3">Rp 9.000.000</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Diterima</span>
                    </td>
                    <td class="px-6 py-3">04 Sep 2025</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Smartphone Samsung</td>
                    <td class="px-6 py-3">Rp 5.000.000</td>
                    <td class="px-6 py-3">Rp 3.000.000</td>
                    <td class="px-6 py-3">Rp 4.250.000</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Counter Offer</span>
                    </td>
                    <td class="px-6 py-3">03 Sep 2025</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">3</td>
                    <td class="px-6 py-3">Headset JBL</td>
                    <td class="px-6 py-3">Rp 1.200.000</td>
                    <td class="px-6 py-3">Rp 500.000</td>
                    <td class="px-6 py-3">-</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Ditolak</span>
                    </td>
                    <td class="px-6 py-3">02 Sep 2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection