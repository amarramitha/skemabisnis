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
                        <option value="Laptop ASUS" data-harga="1000000" data-diskon="20">Laptop ASUS - Rp 1.000.000</option>
                        <option value="Smartphone Samsung" data-harga="3500000" data-diskon="15">Smartphone Samsung - Rp 3.500.000</option>
                        <option value="Printer Epson" data-harga="2000000" data-diskon="0">Printer Epson - Rp 2.000.000</option>
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

            {{-- Total Diskon Otomatis --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Total Diskon</label>
                <input type="text" id="totalPotongan" readonly
                    class="w-full border-gray-300 bg-gray-100 rounded-xl shadow-sm px-4 py-2 font-semibold text-green-700">
            </div>

            {{-- Input Penawaran --}}
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Harga maksimum diskon</label>
                <input type="number" name="penawaran" id="penawaran"
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                    placeholder="Harga setelah diskon">
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex space-x-3">
                <button type="button" id="btnKalkulasi"
                    class="w-40 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-3 py-2 rounded-lg shadow text-sm">
                    Kalkulasi
                </button>
                <button type="submit"
                    class="w-40 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-3 py-2 rounded-lg shadow text-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Form Kalkulasi Harga --}}
    <div id="ringkasanBox" class="hidden bg-white rounded-2xl shadow-lg p-6">
        <h3 class="flex items-center text-lg font-semibold text-gray-700 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-red-500 mr-2"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17v-6a2 2 0 012-2h0a2 2 0 012 2v6m-6 0H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-4" />
            </svg>
            Detail
        </h3>
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden text-sm">
            <thead class="bg-red-500 text-gray-100 font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">Produk</th>
                    <th class="px-4 py-3 text-right">Harga Awal</th>
                    <th class="px-4 py-3 text-right">Harga Setelah Diskon</th>
                </tr>
            </thead>
            <tbody id="tabelRingkasan" class="divide-y divide-gray-200 text-gray-700">
                {{-- Baris produk akan diisi lewat JS --}}
            </tbody>
            <tfoot class="bg-gray-50 font-semibold text-gray-800">
                <tr>
                    <td class="px-4 py-3 text-right">Total:</td>
                    <td class="px-4 py-3 text-right" id="totalAwal">-</td>
                    <td class="px-4 py-3 text-right" id="totalDiskon">-</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<script>
function formatRupiah(n) {
    return "Rp " + n.toLocaleString('id-ID');
}

function hitungTotal() {
    let totalAwal = 0, totalAkhir = 0, totalPotongan = 0;

    document.querySelectorAll('.produkSelect').forEach(select => {
        let opt = select.options[select.selectedIndex];
        let hargaAwal = parseInt(opt?.getAttribute('data-harga')) || 0;
        let diskonPersen = parseInt(opt?.getAttribute('data-diskon')) || 0;

        if (hargaAwal > 0) {
            let potongan = Math.round(hargaAwal * (diskonPersen / 100));
            let hargaSetelahDiskon = hargaAwal - potongan;

            totalAwal += hargaAwal;
            totalAkhir += hargaSetelahDiskon;
            totalPotongan += potongan;
        }
    });

    let totalPersen = totalAwal > 0 ? ((totalPotongan / totalAwal) * 100).toFixed(2) : 0;

    document.getElementById('totalHarga').value = totalAwal > 0 ? formatRupiah(totalAwal) : "";
    document.getElementById('totalPotongan').value = totalAwal > 0 ? totalPersen + " %" : "";
    document.getElementById('penawaran').value = totalAkhir > 0 ? totalAkhir : "";

    return { totalAwal, totalAkhir, totalPotongan, totalPersen };
}

function addRemoveEvent(button) {
    button.addEventListener('click', function() {
        if (document.querySelectorAll('.produkItem').length > 1) {
            this.parentElement.remove();
            hitungTotal();
        }
    });
}

document.querySelectorAll('.hapusProduk').forEach(addRemoveEvent);
document.querySelectorAll('.produkSelect').forEach(select => {
    select.addEventListener('change', hitungTotal);
});

document.getElementById('tambahProduk').addEventListener('click', function() {
    let wrapper = document.getElementById('produkWrapper');
    let item = document.querySelector('.produkItem').cloneNode(true);

    let sel = item.querySelector('select');
    if (sel) sel.selectedIndex = 0;

    wrapper.appendChild(item);

    addRemoveEvent(item.querySelector('.hapusProduk'));
    let newSelect = item.querySelector('.produkSelect');
    if (newSelect) newSelect.addEventListener('change', hitungTotal);

    hitungTotal();
});

document.getElementById('btnKalkulasi').addEventListener('click', function() {
    let tbody = document.getElementById('tabelRingkasan');
    tbody.innerHTML = "";

    let totals = hitungTotal();
    let totalAwal = totals.totalAwal;
    let totalAkhir = totals.totalAkhir;

    document.querySelectorAll('.produkSelect').forEach(select => {
        let opt = select.options[select.selectedIndex];
        let namaProduk = opt?.value || "-";
        let hargaAwal = parseInt(opt?.getAttribute('data-harga')) || 0;
        let diskonPersen = parseInt(opt?.getAttribute('data-diskon')) || 0;

        if (hargaAwal > 0) {
            let potongan = Math.round(hargaAwal * (diskonPersen / 100));
            let hargaDiskon = hargaAwal - potongan;
            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3">${namaProduk}</td>
                    <td class="px-4 py-3 text-right text-red-600">${formatRupiah(hargaAwal)}</td>
                    <td class="px-4 py-3 text-right text-green-700 font-medium">
                        ${formatRupiah(hargaDiskon)} <span class="text-xs text-gray-500">(-${diskonPersen}%)</span>
                    </td>
                </tr>
            `;
        }
    });

    document.getElementById('totalAwal').innerText = totalAwal > 0 ? formatRupiah(totalAwal) : "-";
    document.getElementById('totalDiskon').innerText = totalAkhir > 0 ? formatRupiah(totalAkhir) : "-";

    document.getElementById('ringkasanBox').classList.remove('hidden');
});

document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endsection
