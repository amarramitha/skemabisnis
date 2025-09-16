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
                <select name="kategori_id"
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
                <input type="number" name="harga"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
            </div>

            {{-- Diskon Maksimal (%) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Diskon Maksimal (%)</label>
                <input type="number" name="diskonmaks" id="diskonmaks" min="0" max="100"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
            </div>

            {{-- Jenis Produk --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Produk</label>
                <select name="jenis"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-950 focus:border-blue-950" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="POTS">POTS</option>
                    <option value="Non POTS">Non POTS</option>
                </select>
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
    {{-- Import SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            })
        </script>
    @endif
@endpush
