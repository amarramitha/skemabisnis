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
                    <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
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

                    {{-- Aksi --}}
                    <td class="px-6 py-3 flex space-x-3">
                        <!-- Tombol Edit (pakai Alpine untuk toggle modal) -->
                        <div x-data="{ open: false }" class="inline-block">
                            <!-- Tombol Edit (ikon pensil kuning) -->
                            <button @click="open = true" class="text-yellow-500 hover:text-yellow-600" title="Edit">
                                <i data-lucide="edit-2" class="w-5 h-5"></i>
                            </button>

                            <!-- Modal Edit -->
                            <div x-show="open" x-cloak x-transition.opacity x-transition.scale
                                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6" @click.away="open = false">
                                    <h2 class="flex items-center text-lg font-semibold mb-4 text-gray-800">
                                        <i data-lucide="edit-2" class="w-5 h-5 text-yellow-500 mr-2"></i>
                                        Edit Produk
                                    </h2>

                                    <form method="POST" action="{{ route('produk.update', $p->id) }}" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                            <!-- Kategori -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Kategori</label>
                                                <select name="kategori_id" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300">
                                                    @foreach ($p->kategori->all() as $k)
                                                    <option value="{{ $k->id }}" {{ $p->kategori_id == $k->id ? 'selected' : '' }}>
                                                        {{ $k->nama_kategori }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Nama Produk -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Produk</label>
                                                <input type="text" name="nama_produk" value="{{ $p->nama_produk }}"
                                                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300">
                                            </div>

                                            <!-- Harga -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Harga</label>
                                                <input type="number" name="harga" value="{{ $p->harga }}"
                                                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300">
                                            </div>

                                            <!-- Diskon Maks -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Diskon Maks (%)</label>
                                                <input type="number" name="diskonmaks" value="{{ $p->diskonmaks }}"
                                                    class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300">
                                            </div>

                                            <!-- Jenis -->
                                            <div>
                                                <label class="block text-sm font-medium text-gray-600 mb-1">Jenis</label>
                                                <select name="jenis" class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-yellow-300">
                                                    <option value="POTS" {{ $p->jenis == 'POTS' ? 'selected' : '' }}>POTS</option>
                                                    <option value="Non POTS" {{ $p->jenis == 'Non POTS' ? 'selected' : '' }}>Non POTS</option>
                                                </select>
                                            </div>

                                            <div class="flex justify-end space-x-2 pt-2 border-t">
                                                <button type="button" @click="open = false"
                                                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </form>
                                </div>
                            </div>

                        </div>



                        <!-- Tombol Hapus -->
                        <form action="{{ route('produk.destroy', $p->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2"
                                    class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 7V5a2 2 0 012-2h0a2 2 0 012 2v2" />
                                </svg>
                            </button>
                        </form>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection