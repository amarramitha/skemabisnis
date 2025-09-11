@extends('layouts.admin')

@section('title', 'Input Kategori Produk')

@section('content')
<div class="container mx-auto px-6 py-6">

    @if (session('success'))
        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Kategori Produk</h2>

        <form action="{{ route('masterdata.kategori.store') }}" method="POST">
    @csrf


            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kategori</label>
                <input type="text" name="nama_kategori"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500"
                     required>
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
