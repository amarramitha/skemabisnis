@extends('layouts.admin')

@section('title', 'Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6">
    {{-- Form Input Penawaran --}}
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
        <h2 class="text-lg font-semibold mb-6 text-gray-700">Tambah Penawaran Baru</h2>

        <form action="#" method="POST" id="formPenawaran" class="space-y-6">
            @csrf

            {{-- Nama Konsumen --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nama Konsumen</label>
                <input type="text" name="nama"
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                    placeholder="Masukkan nama konsumen">
            </div>

            {{-- Produk Dinamis --}}
            <div id="produkWrapper" class="space-y-4">
                <div class="produkItem flex space-x-4">
                    <select name="produk[]"
                        class="w-2/3 produkSelect border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-3 py-2">
                        <option value="">-- Pilih Produk --</option>
                        <option value="Laptop ASUS" data-harga="1000000">Laptop ASUS - Rp 1.000.000</option>
                        <option value="Smartphone Samsung" data-harga="3500000">Smartphone Samsung - Rp 3.500.000</option>
                        <option value="Printer Epson" data-harga="2000000">Printer Epson - Rp 2.000.000</option>
                    </select>
                    <button type="button" class="hapusProduk bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl shadow">
                        Hapus
                    </button>
                </div>
            </div>

            {{-- Tombol Tambah Produk --}}
            <button type="button" id="tambahProduk"
                class="w-40 mt-3 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow">
                Tambah Produk
            </button>

            {{-- Total Harga Otomatis --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Total Harga</label>
                <input type="text" id="totalHarga" readonly
                    class="w-full border-gray-300 bg-gray-100 rounded-xl shadow-sm px-4 py-2 font-semibold text-indigo-700">
            </div>

            {{-- Input Penawaran --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Penawaran Konsumen</label>
                <input type="number" name="penawaran" id="penawaran"
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                    placeholder="Masukkan harga tawar">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-3">
                <button type="button" id="btnKalkulasi"
                    class="w-40 bg-yellow-500 hover:bg-yellow-600 text-white font-medium px-3 py-2 rounded-lg shadow text-sm">
                    Kalkulasi
                </button>
                <button type="submit"
                    class="w-40 bg-indigo-500 hover:bg-indigo-600 text-white font-medium px-3 py-2 rounded-lg shadow text-sm">
                    Simpan
                </button>
            </div>


        </form>
    </div>

    {{-- Ringkasan Setelah Kalkulasi --}}
    <div id="ringkasanBox" class="hidden bg-white rounded-2xl shadow-lg p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">📊 Ringkasan Penawaran</h3>
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden">
            <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                <tr>
                    <td class="px-4 py-3 font-semibold">Total Harga Produk</td>
                    <td class="px-4 py-3" id="ringkasanTotal">-</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-semibold">Penawaran Konsumen</td>
                    <td class="px-4 py-3" id="ringkasanPenawaran">-</td>
                </tr>
                <tr>
                    <td class="px-4 py-3 font-semibold">Status</td>
                    <td class="px-4 py-3" id="ringkasanStatus">-</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Script --}}
<script>
    // Tambah produk baru
    document.getElementById('tambahProduk').addEventListener('click', function() {
        let wrapper = document.getElementById('produkWrapper');
        let item = document.querySelector('.produkItem').cloneNode(true);
        item.querySelector('select').selectedIndex = 0;
        wrapper.appendChild(item);

        addRemoveEvent(item.querySelector('.hapusProduk'));
    });

    // Hapus produk
    function addRemoveEvent(button) {
        button.addEventListener('click', function() {
            if (document.querySelectorAll('.produkItem').length > 1) {
                this.parentElement.remove();
            }
        });
    }
    document.querySelectorAll('.hapusProduk').forEach(addRemoveEvent);

    // Kalkulasi total harga + ringkasan
    document.getElementById('btnKalkulasi').addEventListener('click', function() {
        let total = 0;

        document.querySelectorAll('.produkSelect').forEach(select => {
            let harga = select.options[select.selectedIndex]?.getAttribute('data-harga');
            if (harga) {
                total += parseInt(harga);
            }
        });

        let penawaran = parseInt(document.getElementById('penawaran').value) || 0;

        // Update field total harga
        document.getElementById('totalHarga').value = "Rp " + total.toLocaleString('id-ID');

        // Update ringkasan
        document.getElementById('ringkasanTotal').innerText = "Rp " + total.toLocaleString('id-ID');
        document.getElementById('ringkasanPenawaran').innerText = penawaran ? "Rp " + penawaran.toLocaleString('id-ID') : "-";

        let status = "-";
        if (penawaran >= total) {
            status = "Diterima";
        } else if (penawaran >= total * 0.8) {
            status = "Counter Offer";
        } else if (penawaran > 0) {
            status = "Ditolak";
        }
        document.getElementById('ringkasanStatus').innerText = status;

        document.getElementById('ringkasanBox').classList.remove('hidden');
    });
</script>
@endsection