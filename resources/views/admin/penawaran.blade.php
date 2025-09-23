@extends('layouts.admin')

@section('title', 'Penawaran')

@section('content')
<div class="container mx-auto px-6 py-6">
    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-200">
        <h2 class="text-xl font-bold text-gray-800 mb-6 border-b pb-3 text-center">
            Tambah Penawaran Baru
        </h2>

        <form action="{{ route('penawaran.store') }}" method="POST">
            @csrf

            {{-- Nama Konsumen --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Konsumen</label>
                <input type="text" name="nama" placeholder="Masukkan nama konsumen"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2" required>
            </div>

            {{-- Produk --}}
            <div id="produkWrapper" class="space-y-3">
                <div class="produkItem grid grid-cols-12 gap-3 items-end">
                    {{-- Pilih Produk --}}
                    <div class="col-span-4">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Produk</label>
                        <select name="produk_id[]" class="produkSelect w-full border-gray-300 rounded-lg shadow-sm px-3 py-2">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id }}"
                                    data-harga="{{ $p->harga }}"
                                    data-diskonmaks="{{ $p->kategori->diskon_maks ?? 0 }}"
                                    data-psb="{{ $p->kategori->psb ?? 0 }}"
                                    data-diskonpsb="{{ $p->kategori->diskon_psb ?? 0 }}">
                                    {{ $p->kategori->nama_kategori ?? '—' }} — {{ $p->nama }} — Rp {{ number_format($p->harga,0,',','.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Qty --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Qty</label>
                        <input type="number" name="qty[]" value="1" min="1"
                               class="qtyInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center">
                    </div>

                    {{-- Bulan --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
                        <input type="number" name="bulan[]" value="1" min="1"
                               class="bulanInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center">
                    </div>

                    {{-- Diskon --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Diskon (%)</label>
                        <input type="number" name="diskon[]" value="0"
                               class="diskonInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center bg-gray-100 text-gray-500"
                               readonly>
                    </div>

                    {{-- Diskon PSB --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Diskon PSB (%)</label>
                        <input type="number" name="diskon_psb[]" value="0"
                               class="diskonPsbInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center bg-gray-100 text-gray-500"
                               readonly>
                    </div>

                    {{-- Tombol hapus --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1 invisible">Aksi</label>
                        <button type="button" class="hapusProduk w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg shadow">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>

            <button type="button" id="tambahProduk"
                    class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
                + Tambah Produk
            </button>

            {{-- PPN --}}
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">PPN</label>
                <select id="ppnSelect" name="ppn"
                        class="w-full border-gray-300 rounded-lg shadow-sm px-3 py-2">
                    <option value="11">11%</option>
                    <option value="12">12%</option>
                </select>
            </div>

            {{-- Ringkasan --}}
<div id="ringkasanBox" class="hidden mt-8">
    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">
        Ringkasan Penawaran
    </h3>
    <div class="overflow-x-auto rounded-xl border shadow-md">
        <table class="min-w-[1000px] text-sm border-collapse w-full">
            <thead>
                <tr class="bg-gray-800 text-white text-xs uppercase">
                    <th rowspan="2" class="px-3 py-3 text-left">No</th>
                    <th rowspan="2" class="px-3 py-3 text-left">Item</th>
                    <th rowspan="2" class="px-3 py-3 text-center">Satuan</th>
                    <th rowspan="2" class="px-3 py-3 text-center">Jumlah</th>
                    <th rowspan="2" class="px-3 py-3 text-center">Durasi (Bulan)</th>
                    <th colspan="3" class="px-3 py-2 text-center bg-blue-700">Tarif Dasar</th>
                    <th colspan="3" class="px-3 py-2 text-center bg-red-600">Diskon</th>
                    <th colspan="3" class="px-3 py-2 text-center bg-green-700">Harga Penawaran</th>
                </tr>
                <tr class="bg-gray-700 text-white text-xs uppercase">
                    <th class="px-3 py-2 text-center">Satuan</th>
                    <th class="px-3 py-2 text-center">MC</th>
                    <th class="px-3 py-2 text-center">Total</th>
                    <th class="px-3 py-2 text-center">OTC</th>
                    <th class="px-3 py-2 text-center">MC</th>
                    <th class="px-3 py-2 text-center">OTC</th>
                    <th class="px-3 py-2 text-center">Satuan</th>
                    <th class="px-3 py-2 text-center">MC</th>
                    <th class="px-3 py-2 text-center">Total</th>
                </tr>
            </thead>
            <tbody id="tabelRingkasan" class="divide-y divide-gray-200 text-gray-700">
                {{-- baris produk masuk via JS --}}
            </tbody>
            <tfoot class="text-sm font-semibold">
                <tr class="bg-gray-100">
                    <td colspan="6" class="px-3 py-2 text-right font-medium">Sub Total:</td>
                    <td colspan="3" class="px-3 py-2 text-right" id="subtotalTarif">-</td>
                    <td colspan="3" class="px-3 py-2 text-center text-red-600" id="subtotalDiskon">-</td>
                    <td colspan="3" class="px-3 py-2 text-right text-green-700" id="subtotalPenawaran">-</td>
                </tr>
                <tr>
                    <td colspan="13" class="px-3 py-2 text-right">Total Sebelum PPN:</td>
                    <td class="px-3 py-2 text-right" id="totalAwal">-</td>
                </tr>
                <tr>
                    <td colspan="13" class="px-3 py-2 text-right">PPN:</td>
                    <td class="px-3 py-2 text-right" id="ppnNominal">-</td>
                </tr>
                <tr class="bg-green-100 border-t-2 border-green-400">
                    <td colspan="13" class="px-3 py-3 text-right font-bold">Total Akhir:</td>
                    <td class="px-3 py-3 text-right text-green-700 font-bold text-base" id="totalAkhir">-</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

            {{-- Hidden inputs --}}
            <input type="hidden" id="totalHarga" name="total_harga">
            <input type="hidden" id="totalPotongan" name="total_potongan">
            <input type="hidden" id="penawaran" name="penawaran">

            {{-- Tombol Submit --}}
            <div class="flex justify-end mt-6">
                <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-green-600 text-white hover:bg-green-700 shadow">
                    Simpan Penawaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function formatRupiah(n) {
    return "Rp " + (Number(n) || 0).toLocaleString('id-ID');
}

function toggleDiskonField(select) {
    const opt = select.options[select.selectedIndex];
    const diskonMaks = parseInt(opt?.getAttribute("data-diskonmaks")) || 0;
    const diskonInput = select.closest(".produkItem").querySelector(".diskonInput");
    if (diskonMaks === 0) {
        diskonInput.value = 0;
        diskonInput.readOnly = true;
        diskonInput.classList.add("bg-gray-100", "text-gray-500");
    } else {
        diskonInput.readOnly = false;
        diskonInput.classList.remove("bg-gray-100", "text-gray-500");
    }
}

function toggleDiskonPsbField(select) {
    const opt = select.options[select.selectedIndex];
    const diskonPsbMaks = parseInt(opt?.getAttribute("data-diskonpsb")) || 0;
    const diskonPsbInput = select.closest(".produkItem").querySelector(".diskonPsbInput");
    if (diskonPsbMaks === 0) {
        diskonPsbInput.value = 0;
        diskonPsbInput.readOnly = true;
        diskonPsbInput.classList.add("bg-gray-100", "text-gray-500");
    } else {
        diskonPsbInput.readOnly = false;
        diskonPsbInput.classList.remove("bg-gray-100", "text-gray-500");
    }
}

function hitungTotal() {
    let totalAwal = 0;
    let totalDiskonLayanan = 0;
    let totalSetelahDiskon = 0;
    let tbody = document.getElementById('tabelRingkasan');
    tbody.innerHTML = "";

    let produkList = document.querySelectorAll('#produkWrapper .produkItem');
    produkList.forEach((produk, i) => {
        let opt = produk.querySelector('select.produkSelect option:checked');
        if (!opt.value) return; // skip kalau belum pilih produk

        let hargaMc = parseInt(opt.dataset.harga) || 0; // MC per unit
        let qty = parseInt(produk.querySelector('.qtyInput').value) || 1;
        let bulan = parseInt(produk.querySelector('.bulanInput').value) || 1;
        let diskon = parseFloat(produk.querySelector('.diskonInput').value) || 0;
        let diskonPsb = parseFloat(produk.querySelector('.diskonPsbInput').value) || 0;

        // hitungan dasar
        let satuan = hargaMc * qty;
        let total = hargaMc * qty * bulan;

        // hitung potongan
        let potonganDiskon = total * (diskon / 100);
        let potonganPsb = hargaMc * (diskonPsb / 100);
        let totalPotongan = potonganDiskon + potonganPsb;

        // harga penawaran setelah diskon
        let penawaranTotal = total - totalPotongan;

        // akumulasi
        totalAwal += total;
        totalDiskonLayanan += totalPotongan;
        totalSetelahDiskon += penawaranTotal;

        // isi baris tabel
        tbody.innerHTML += `
            <tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
                <td class="px-3 py-2 text-center">${i + 1}</td>
                <td class="px-3 py-2">${opt.text}</td>
                <td class="px-3 py-2 text-center">${formatRupiah(satuan)}</td>
                <td class="px-3 py-2 text-center">${qty}</td>
                <td class="px-3 py-2 text-center">${bulan}</td>

                <!-- Tarif Dasar -->
                <td class="px-3 py-2 text-center">${formatRupiah(satuan)}</td>
                <td class="px-3 py-2 text-center">${formatRupiah(hargaMc)}</td>
                <td class="px-3 py-2 text-center">${formatRupiah(total)}</td>

                <!-- Diskon -->
                <td class="px-3 py-2 text-center">${diskonPsb.toFixed(2)}%</td>
                <td class="px-3 py-2 text-center">${diskon.toFixed(2)}%</td>
                <td class="px-3 py-2 text-center text-red-600">-${formatRupiah(totalPotongan)}</td>

                <!-- Harga Penawaran -->
                <td class="px-3 py-2 text-center">${formatRupiah(satuan)}</td>
                <td class="px-3 py-2 text-center">${formatRupiah(hargaMc)}</td>
                <td class="px-3 py-2 text-center font-medium text-green-600">${formatRupiah(penawaranTotal)}</td>
            </tr>`;

    });

    // subtotal
    document.getElementById('subtotalTarif').innerText = formatRupiah(totalAwal);
    document.getElementById('subtotalDiskon').innerText = "-" + formatRupiah(totalDiskonLayanan);
    document.getElementById('subtotalPenawaran').innerText = formatRupiah(totalSetelahDiskon);

    // total sebelum PPN
    document.getElementById('totalAwal').innerText = formatRupiah(totalAwal);

    // hitung PPN dari select
    let ppnPersen = parseInt(document.getElementById('ppnSelect').value) || 0;
    let ppn = totalSetelahDiskon * (ppnPersen / 100);
    document.getElementById('ppnNominal').innerText = formatRupiah(ppn);

    // total akhir
    let totalAkhir = totalSetelahDiskon + ppn;
    document.getElementById('totalAkhir').innerText = formatRupiah(totalAkhir);

    // tampilkan box ringkasan
    document.getElementById('ringkasanBox').classList.remove('hidden');

    // set hidden input (biar ikut ke server)
    document.getElementById('totalHarga').value = totalAwal;
    document.getElementById('totalPotongan').value = totalDiskonLayanan;
    document.getElementById('penawaran').value = totalSetelahDiskon;
}

// format rupiah
function formatRupiah(angka) {
    return angka.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
}


// Event listeners
const produkWrapper = document.getElementById('produkWrapper');

produkWrapper.addEventListener('change', e => {
    if(e.target.classList.contains('produkSelect')) {
        toggleDiskonField(e.target);
        toggleDiskonPsbField(e.target);
        hitungTotal();
    }
    if(e.target.classList.contains('qtyInput') || e.target.classList.contains('bulanInput')) {
        hitungTotal();
    }
});

produkWrapper.addEventListener('input', e => {
    if(e.target.classList.contains('diskonInput')) {
        const val = parseInt(e.target.value) || 0;
        const max = parseInt(e.target.closest('.produkItem').querySelector('.produkSelect').selectedOptions[0].dataset.diskonmaks) || 0;
        e.target.value = Math.min(Math.max(val,0), max);
        hitungTotal();
    }
    if(e.target.classList.contains('diskonPsbInput')) {
        const val = parseInt(e.target.value) || 0;
        const max = parseInt(e.target.closest('.produkItem').querySelector('.produkSelect').selectedOptions[0].dataset.diskonpsb) || 0;
        e.target.value = Math.min(Math.max(val,0), max);
        hitungTotal();
    }
});

// Tambah produk
document.getElementById('tambahProduk').addEventListener('click', () => {
    const wrapper = document.getElementById('produkWrapper');
    const clone = wrapper.querySelector('.produkItem').cloneNode(true);

    clone.querySelector('.produkSelect').selectedIndex = 0;
    clone.querySelector('.qtyInput').value = 1;
    clone.querySelector('.bulanInput').value = 1;
    clone.querySelector('.diskonInput').value = 0;
    clone.querySelector('.diskonInput').readOnly = true;
    clone.querySelector('.diskonInput').classList.add('bg-gray-100','text-gray-500');
    clone.querySelector('.diskonPsbInput').value = 0;
    clone.querySelector('.diskonPsbInput').readOnly = true;
    clone.querySelector('.diskonPsbInput').classList.add('bg-gray-100','text-gray-500');

    wrapper.appendChild(clone);
});

// Hapus produk
produkWrapper.addEventListener('click', e => {
    if(e.target.classList.contains('hapusProduk')) {
        const item = e.target.closest('.produkItem');
        item?.remove();
        hitungTotal();
    }
});

// Init
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.produkSelect').forEach(s => {
        toggleDiskonField(s);
        toggleDiskonPsbField(s);
    });
    hitungTotal();
});

// PPN change
document.getElementById('ppnSelect').addEventListener('change', hitungTotal);
</script>
@endsection
