@extends('layouts.admin')

@section('title', 'Input Master Data')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Card Form Input --}}
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Produk Baru</h2>

        <form action="#" method="POST" class="space-y-4">
            @csrf

            {{-- Kategori Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Produk</label>
                <select name="kategori"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Aksesoris">Aksesoris</option>
                    <option value="Peralatan Kantor">Peralatan Kantor</option>
                </select>
            </div>

            {{-- Nama Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" name="nama"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                    placeholder="Contoh: Laptop ASUS">
            </div>

            {{-- Harga Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Produk</label>
                <input type="number" name="harga"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                    placeholder="Contoh: 5000000">
            </div>

            {{-- Diskon Maksimal --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diskon Maksimal (%)</label>
                <input type="number" name="diskon"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                    placeholder="Contoh: 15">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-4 pt-2">
                <button type="reset"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    Reset
                </button>
                <button type="submit"
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection