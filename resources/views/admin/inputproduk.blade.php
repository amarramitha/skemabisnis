@extends('layouts.admin')

@section('title', 'Input Produk')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition-shadow duration-300 p-8 border border-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Tambah Produk Baru
        </h2>

        <form action="{{ route('masterdata.produk.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Pilih Kategori --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="kategori_id" id="kategori_id"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
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
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
            </div>

            {{-- Harga Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga Produk</label>
                <input type="number" name="harga" step="0.01"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
            </div>

            {{-- Diskon Maksimal (auto dari kategori) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diskon Maksimal (%)</label>
                <input type="text" id="diskon_maks" readonly
                    class="w-full border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:ring-blue-950 focus:border-blue-950">
            </div>

            {{-- Jenis Produk (auto dari kategori) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk</label>
                <input type="text" id="jenis" readonly
                    class="w-full border-gray-300 rounded-lg bg-gray-100 shadow-sm focus:ring-blue-950 focus:border-blue-950">
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

@push('scripts')
<script>
    const kategoriData = @json($kategori);

    document.getElementById('kategori_id').addEventListener('change', function () {
        const selectedId = this.value;
        const kategori = kategoriData.find(k => k.id == selectedId);

        if (kategori) {
            document.getElementById('diskon_maks').value = kategori.diskon_maks + ' %';
            document.getElementById('jenis').value = kategori.jenis;
        } else {
            document.getElementById('diskon_maks').value = '';
            document.getElementById('jenis').value = '';
        }
    });
</script>
@endpush
