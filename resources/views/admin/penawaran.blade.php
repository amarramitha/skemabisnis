@extends('layouts.admin')

@section('title', 'Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Form Penawaran --}}
    <div class="bg-white rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 p-8 border border-gray-100 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Tambah Penawaran Baru
        </h2>

        <form action="{{ route('penawaran.store') }}" method="POST" id="formPenawaran" class="space-y-5">
            @csrf

            {{-- Nama Konsumen --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Konsumen</label>
                <input type="text" name="nama"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 px-4 py-2"
                    placeholder="Masukkan nama konsumen" required>
            </div>

            {{-- Produk --}}
            <div id="produkWrapper" class="space-y-4">
                <div class="produkItem flex space-x-4 items-center">
                    <select name="produk[]" class="w-1/2 produkSelect border-gray-300 rounded-lg shadow-sm px-3 py-2">
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

                    <input type="number" name="qty[]" class="qtyInput w-20 border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center" min="1" value="1">

                    <button type="button" class="hapusProduk bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow">
                        Hapus
                    </button>
                </div>
            </div>

            <button type="button" id="tambahProduk"
                class="mt-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg shadow">
                Tambah Produk
            </button>

            {{-- Total Harga --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Harga</label>
                <input type="text" id="totalHarga" readonly
                    class="w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm px-4 py-2 font-semibold text-red-700">
            </div>

            {{-- Total Diskon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Diskon</label>
                <input type="text" id="totalPotongan" readonly
                    class="w-full border-gray-300 bg-gray-100 rounded-lg shadow-sm px-4 py-2 font-semibold text-green-700">
            </div>

            {{-- Total Akhir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Harga Akhir</label>
                <input type="text" name="penawaran" id="penawaran" readonly
                    class="w-full border-gray-300 rounded-lg shadow-sm px-4 py-2 font-semibold text-indigo-700">
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">
                <button type="submit"
                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700 shadow-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Ringkasan --}}
    <div id="ringkasanBox" class="hidden bg-white rounded-2xl shadow-xl hover:shadow-2xl transition duration-300 p-8 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-6 border-b pb-3">Detail Penawaran</h3>
        <table class="min-w-full border border-gray-200 rounded-xl overflow-hidden text-sm">
            <thead class="bg-blue-950 text-white font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">Produk</th>
                    <th class="px-4 py-3 text-right">Harga Awal</th>
                    <th class="px-4 py-3 text-right">Harga Setelah Diskon + PPN</th>
                </tr>
            </thead>
            <tbody id="tabelRingkasan" class="divide-y divide-gray-200 text-gray-700"></tbody>
            <tfoot class="bg-gray-50 font-semibold text-gray-800">
                <tr>
                    <td class="px-4 py-3 text-right">Total:</td>
                    <td class="px-4 py-3 text-right" id="totalAwal">-</td>
                    <td class="px-4 py-3 text-right" id="totalAkhir">-</td>
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
    let totalAwal = 0, totalPotongan = 0, totalAkhir = 0;
    const tbody = document.getElementById('tabelRingkasan');
    tbody.innerHTML = "";

    document.querySelectorAll('.produkItem').forEach(item => {
        const select = item.querySelector('.produkSelect');
        const qty = parseInt(item.querySelector('.qtyInput')?.value) || 1;
        const opt = select.options[select.selectedIndex];
        const namaProduk = opt?.text || "-";
        const hargaSatuan = parseInt(opt?.getAttribute('data-harga')) || 0;
        const diskonPersen = parseInt(opt?.getAttribute('data-diskon')) || 0;
        const ppnPersen = parseInt(opt?.getAttribute('data-ppn')) || 0;

        if (hargaSatuan > 0 && qty > 0) {
            const hargaAwalTotal = hargaSatuan * qty;
            const potongan = Math.round(hargaAwalTotal * (diskonPersen / 100));
            const hargaDiskon = hargaAwalTotal - potongan;
            const ppnNominal = Math.round(hargaDiskon * (ppnPersen / 100));
            const hargaAkhir = hargaDiskon + ppnNominal;

            totalAwal += hargaAwalTotal;
            totalPotongan += potongan;
            totalAkhir += hargaAkhir;

            tbody.innerHTML += `
                <tr>
                    <td class="px-4 py-3">${namaProduk} <span class="text-xs text-gray-500">(x${qty})</span></td>
                    <td class="px-4 py-3 text-right text-red-600">${formatRupiah(hargaAwalTotal)}</td>
                    <td class="px-4 py-3 text-right text-green-700 font-medium">
                        ${formatRupiah(hargaAkhir)}
                        <span class="text-xs text-gray-500">(-${diskonPersen}% + PPN ${ppnPersen}%)</span>
                    </td>
                </tr>`;
        }
    });

    // hitung persen total diskon
    const totalDiskonPersen = totalAwal > 0 ? Math.round((totalPotongan / totalAwal) * 100) : 0;

    document.getElementById('totalHarga').value = totalAwal > 0 ? formatRupiah(totalAwal) : "";
    document.getElementById('totalPotongan').value = totalPotongan > 0 ? `${formatRupiah(totalPotongan)} (${totalDiskonPersen}%)` : "";
    document.getElementById('penawaran').value = totalAkhir > 0 ? formatRupiah(totalAkhir) : "";

    document.getElementById('totalAwal').innerText = totalAwal > 0 ? formatRupiah(totalAwal) : "-";
    document.getElementById('totalAkhir').innerText = totalAkhir > 0 ? formatRupiah(totalAkhir) : "-";

    document.getElementById('ringkasanBox').classList.remove('hidden');
}


// Delegasi hapus produk
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
    clone.querySelector('.qtyInput').value = 1;
    wrapper.appendChild(clone);
    hitungTotal();
});

// Hitung saat select / qty berubah
document.getElementById('produkWrapper').addEventListener('change', function(e){
    if(e.target.classList.contains('produkSelect') || e.target.classList.contains('qtyInput')){
        hitungTotal();
    }
});

document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endsection
