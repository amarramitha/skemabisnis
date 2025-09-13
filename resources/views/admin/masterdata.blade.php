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

    {{-- Toolbar Atas --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 gap-3">
        <div class="flex items-center space-x-2">
            {{-- Dropdown kategori dari produk yang ada --}}
            <select id="filterKategori" 
                class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-indigo-300 w-40">
                <option value="">Semua Kategori</option>
                @foreach ($produk->pluck('kategori')->filter()->unique('id') as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>


            <input type="text" id="searchProduk"
                placeholder="Cari produk..."
                class="border rounded-lg px-3 py-2 text-sm w-48 focus:ring focus:ring-indigo-300">

            <button id="btnSearch" class="bg-blue-900 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm shadow">
                Cari
            </button>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto bg-white rounded-xl shadow-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-red-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Kategori</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nama Produk</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold">Harga</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold">PPN 11%</th>
                    <th class="px-6 py-3 text-right text-sm font-semibold">Total</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Diskon Maks</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Jenis</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody id="produkTable" class="divide-y divide-gray-200 text-sm text-gray-700">
                @foreach ($produk as $index => $p)
                @php
                    $ppn = $p->harga * 0.11;
                    $total = $p->total_harga;
                @endphp
                <tr class="hover:bg-gray-50 transition-colors"
                    data-kategori-id="{{ $p->kategori->id ?? '' }}">
                    <td class="px-6 py-3">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">{{ $p->kategori->nama_kategori ?? '-' }}</td>
                    <td class="px-6 py-3">{{ $p->nama_produk }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format($ppn, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td class="px-6 py-3 text-center">{{ $p->diskonmaks }}%</td>
                    <td class="px-6 py-3 text-center">{{ $p->jenis }}</td>

                    {{-- Aksi --}}
                    <td class="px-6 py-3 flex justify-center space-x-3">
                        <a href="{{ route('produk.edit', $p->id) }}"
                           class="text-yellow-500 hover:text-yellow-600" title="Edit">
                            <i data-lucide="edit-2" class="w-5 h-5"></i>
                        </a>

                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <i data-lucide="trash-2" class="w-5 h-5"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchProduk');
    const kategoriSelect = document.getElementById('filterKategori');
    const btnSearch = document.getElementById('btnSearch');
    const rows = Array.from(document.querySelectorAll('#produkTable tr'));

    function filterTable() {
        const searchText = (searchInput.value || '').toLowerCase().trim();
        const kategoriValue = (kategoriSelect.value || '').toString();

        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            const kategori = row.getAttribute('data-kategori-id') || '';

            let match = true;
            if (searchText && !nama.includes(searchText)) match = false;
            if (kategoriValue && kategori !== kategoriValue) match = false;

            row.style.display = match ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    kategoriSelect.addEventListener('change', filterTable);
    btnSearch.addEventListener('click', filterTable);
});
</script>
@endsection
