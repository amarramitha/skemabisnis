@extends('layouts.admin')

@section('title', 'Master Data')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Flash Message --}}
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
                    <th class="px-6 py-3 text-left text-sm font-semibold">Kategori Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Produk</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">PPn 11%</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Kategori</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Harga Minimal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">PPN 11% Harga Minimal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Total Harga Minimal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Diskon Maksimal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">1</td>
                    <td class="px-6 py-3">Elektronik</td>
                    <td class="px-6 py-3">Laptop ASUS</td>
                    <td class="px-6 py-3">Rp 10.000.000</td>
                    <td class="px-6 py-3">Rp 1.100.000</td>
                    <td class="px-6 py-3">Rp 11.100.000</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Diterima</span>
                    </td>
                    <td class="px-6 py-3">Rp 8.500.000</td>
                    <td class="px-6 py-3">Rp 935.000</td>
                    <td class="px-6 py-3">Rp 9.435.000</td>
                    <td class="px-6 py-3">15%</td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">2</td>
                    <td class="px-6 py-3">Elektronik</td>
                    <td class="px-6 py-3">Smartphone Samsung</td>
                    <td class="px-6 py-3">Rp 5.000.000</td>
                    <td class="px-6 py-3">Rp 550.000</td>
                    <td class="px-6 py-3">Rp 5.550.000</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Counter Offer</span>
                    </td>
                    <td class="px-6 py-3">Rp 3.000.000</td>
                    <td class="px-6 py-3">Rp 330.000</td>
                    <td class="px-6 py-3">Rp 3.330.000</td>
                    <td class="px-6 py-3">15%</td>
                </tr>

                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">3</td>
                    <td class="px-6 py-3">Aksesoris</td>
                    <td class="px-6 py-3">Headset JBL</td>
                    <td class="px-6 py-3">Rp 1.200.000</td>
                    <td class="px-6 py-3">Rp 132.000</td>
                    <td class="px-6 py-3">Rp 1.332.000</td>
                    <td class="px-6 py-3">
                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Ditolak</span>
                    </td>
                    <td class="px-6 py-3">Rp 500.000</td>
                    <td class="px-6 py-3">Rp 55.000</td>
                    <td class="px-6 py-3">Rp 555.000</td>
                    <td class="px-6 py-3">15%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
