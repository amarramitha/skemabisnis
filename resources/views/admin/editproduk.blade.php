@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mx-auto px-6 py-6">
    <h2 class="text-2xl font-semibold mb-4">Edit Produk</h2>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium">Kategori</label>
            <select name="kategori_id" class="border rounded-lg px-3 py-2 w-full">
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ $produk->kategori_id == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="border rounded-lg px-3 py-2 w-full">
        </div>

        <div>
            <label class="block text-sm font-medium">Harga</label>
            <input type="number" name="harga" value="{{ $produk->harga }}" class="border rounded-lg px-3 py-2 w-full">
        </div>

        <button type="submit" class="bg-blue-900 text-white px-4 py-2 rounded-lg">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
