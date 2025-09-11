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
                    <th class="px-6 py-3 text-left text-sm font-semibold">PPN 11%</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Total</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Diskon Maksimal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
    @foreach ($produk as $index => $p)
    <tr class="hover:bg-gray-50">
        <td class="px-6 py-3">{{ $index + 1 }}</td>
        <td class="px-6 py-3">{{ $p->kategori->nama_kategori ?? '-' }}</td>
        <td class="px-6 py-3">{{ $p->nama_produk }}</td>
        <td class="px-6 py-3">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
        <td class="px-6 py-3">Rp {{ number_format($p->ppn, 0, ',', '.') }}</td>
        <td class="px-6 py-3">Rp {{ number_format($p->total, 0, ',', '.') }}</td>
        <td class="px-6 py-3">{{ $p->diskonmaks }}%</td>
    </tr>
    @endforeach
</tbody>
        </table>
    </div>
</div>
@endsection
