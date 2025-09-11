@extends('layouts.admin')

@section('title', 'Input Produk')

@section('content')
<div class="container mx-auto px-6 py-6">

    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Produk Baru</h2>

        <form action="{{ route('masterdata.produk.store') }}" method="POST">
    @csrf

            {{-- Pilih Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="nama_produk"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                     required>
            </div>

            {{-- Harga Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Produk</label>
                <input type="number" name="harga"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                     required>
            </div>

            {{-- Diskon Maksimal (%) --}}
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Diskon Maksimal (%)</label>
    <input type="number" name="diskonmaks" id="diskonmaks" min="0" max="100"
        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
        required>
</div>


            {{-- Jenis Produk (POTS / Non POTS) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk</label>
                <select name="jenis"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="POTS">POTS</option>
                    <option value="Non POTS">Non POTS</option>
                </select>
            </div>

            <div class="flex space-x-4 pt-2">
                <button type="reset" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow">
                    Reset
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
