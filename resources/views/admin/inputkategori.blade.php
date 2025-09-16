@extends('layouts.admin')

@section('title', 'Input Kategori Produk')

@section('content')
<div class="container mx-auto px-6 py-6">

    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Tambah Kategori Produk
        </h2>

        <form action="{{ route('masterdata.kategori.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Nama Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">
                <button type="reset" class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-600 bg-gray-50 hover:bg-gray-100 shadow-sm">
                    Reset
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-950 text-white hover:bg-blue-900 shadow-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
