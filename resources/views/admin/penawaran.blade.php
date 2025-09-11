@extends('layouts.admin')

@section('title', 'Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
        <h2 class="text-lg font-semibold mb-6 text-gray-700">Tambah Penawaran Baru</h2>

        <form action="{{ route('penawaran.store') }}" method="POST" id="formPenawaran" class="space-y-6">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Nama Konsumen</label>
                <input type="text" name="nama"
                    class="w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500 px-4 py-2"
                    placeholder="Masukkan nama konsumen">
            </div>

            <div id="produkWrapper" class="space-y-4">
                <div class="produkItem flex space-x-4">
                    <select name="produk[]" class="w-2/3 produkSelect border-gray-300 rounded-xl shadow-sm px-3 py-2">
                        <option value="">-- Pilih Produk --</option>
                        @foreach ($produk as $p)
                        <option value="{{ $p->id }}"
                            data-harga="{{ (int)$p->harga }}"
                            data-diskon="{{ $p->diskonmaks ?? 0 }}"
                            data-ppn="11">
                            {{ $p->kategori->nama_kategori ?? '—' }} — {{ $p->nama_produk }} — Rp {{ number_format($p->harga,0,',','.') }}
                        </option>
                        @endforeach
                    </select>
                    <button type="button" class="hapusProduk bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl shadow">Hapus</button>
                </div>
            </div>

            <button type="button" id="tambahProduk"
                class="w-40 mt-3 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-xl shadow">
                Tambah Produk
            </button>

            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Total Harga</label>
                <input type="text" id="totalHarga" readonly class="w-full border-gray-300 bg-gray-100 rounded-xl shadow-sm px-4 py-2 font-semibold text-indigo-700">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Total Diskon</label>
                <input type="text" id="totalPotongan" readonly class="w-full border-gray-300 bg-gray-100 rounded-xl shadow-sm px-4 py-2 font-semibold text-green-700">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-600 mb-2">Total Harga Akhir</label>
                <input type="text" name="penawaran" id="penawaran" readonly class="w-full border-gray-300 rounded-xl shadow-sm px-4 py-2 font-semibold text-indigo-700">
            </div>

            <div class="flex space-x-3">
               
                <button type="submit" class="w-40 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold px-3 py-2 rounded-lg shadow text-sm">Simpan</button>
            </div>
        </form>
    </div>

    <div id="ringkasanBox" class="hidden bg-white rounded-2xl shadow-lg p-6">
        <h3 class="flex items-center text-lg font-semibold text-gray-700 mb-4">
            Detail Penawaran
        </h3>
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden text-sm">
            <thead class="bg-red-500 text-gray-100 font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">Produk</th>
                    <th class="px-4 py-3 text-right">Harga Awal</th>
                    <th class="px-4 py-3 text-right">Harga Setelah Diskon</th>
                </tr>
            </thead>
            <tbody id="tabelRingkasan" class="divide-y divide-gray-200 text-gray-700"></tbody>
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
    const tbody = document.getElementById('tabelRingkasan');
    tbody.innerHTML = "";

    document.querySelectorAll('.produkSelect').forEach(select => {
        const opt = select.options[select.selectedIndex];
        const namaProduk = opt?.text || "-";
        const hargaAwal = parseInt(opt?.getAttribute('data-harga')) || 0;
        const diskonPersen = parseInt(opt?.getAttribute('data-diskon')) || 0;
        const ppnPersen = parseInt(opt?.getAttribute('data-ppn')) || 0;

        if(hargaAwal > 0) {
            const potongan = Math.round(hargaAwal * (diskonPersen / 100));
            const hargaDiskon = hargaAwal - potongan;
            const ppnNominal = Math.round(hargaDiskon * (ppnPersen / 100));
            const hargaAkhir = hargaDiskon + ppnNominal;

            totalAwal += hargaAwal;
            totalAkhir += hargaAkhir;
            totalPotongan += potongan;

            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3">${namaProduk}</td>
                    <td class="px-4 py-3 text-right text-red-600">${formatRupiah(hargaAwal)}</td>
                    <td class="px-4 py-3 text-right text-green-700 font-medium">
                        ${formatRupiah(hargaAkhir)} 
                        <span class="text-xs text-gray-500">(-${diskonPersen}% + PPN ${ppnPersen}%)</span>
                    </td>
                </tr>`;
        }
    });

    document.getElementById('totalHarga').value = totalAwal > 0 ? formatRupiah(totalAwal) : "";
    document.getElementById('totalPotongan').value = totalAwal > 0 ? ((totalPotongan/totalAwal)*100).toFixed(2) + " %" : "";
    document.getElementById('penawaran').value = totalAkhir > 0 ? formatRupiah(totalAkhir) : "";

    document.getElementById('totalAwal').innerText = totalAwal > 0 ? formatRupiah(totalAwal) : "-";
    document.getElementById('totalDiskon').innerText = totalAkhir > 0 ? formatRupiah(totalAkhir) : "-";

    document.getElementById('ringkasanBox').classList.remove('hidden');

    return {totalAwal, totalAkhir};
}

// Delegation untuk produk dinamis
document.getElementById('produkWrapper').addEventListener('click', function(e){
    if(e.target.classList.contains('hapusProduk')){
        e.target.closest('.produkItem').remove();
        hitungTotal();
    }
});

// Tambah produk
document.getElementById('tambahProduk').addEventListener('click', function(){
    const wrapper = document.getElementById('produkWrapper');
    const firstItem = wrapper.querySelector('.produkItem');
    const clone = firstItem.cloneNode(true);
    clone.querySelector('select').selectedIndex = 0;
    wrapper.appendChild(clone);
});


// Event onchange untuk semua select
document.getElementById('produkWrapper').addEventListener('change', function(e){
    if(e.target.classList.contains('produkSelect')) hitungTotal();
});

document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endsection
