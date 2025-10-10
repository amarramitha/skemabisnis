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
                       class=" border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2 w-full" required>
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
                                {{ $p->nama_produk ?? '—' }}
                            </option>
                        @endforeach
                    </select>
                </div>

        {{-- Qty --}}
        <div class="col-span-1">
            <label class="block text-xs font-medium text-gray-600 mb-1 text-center">Qty</label>
            <input type="number" name="qty[]" value="1" min="1"
                   class="qtyInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center">
        </div>

        {{-- Bulan --}}
        <div class="col-span-1">
            <label class="block text-xs font-medium text-gray-600 mb-1 text-center">Bulan</label>
            <input type="number" name="bulan[]" value="1" min="1"
                   class="bulanInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center">
        </div>

        {{-- Diskon --}}
            <div class="col-span-2 relative">
                <label class="block text-xs font-medium text-gray-600 mb-1 text-center">Diskon (%)</label>
                <input type="number" name="diskon[]" value="0" step="0.01" lang="en"
                    data-diskon-maks="{{ $p->kategori->diskon_maks }}"
                    class="diskonInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center bg-gray-100 text-gray-500"
                    readonly>
                <p class="diskonMessage text-red-600 text-xs absolute left-0 top-full mt-1 opacity-0 transition-opacity duration-300">
                    Diskon maksimal 0%
                </p>
            </div>


        {{-- Diskon PSB --}}
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1 text-center">Diskon PSB (%)</label>
            <input type="number" name="diskon_psb[]" value="0" step="0.01" lang="en"
                data-diskon-maks="{{ $p->kategori->diskon_psb }}"
                class="diskonPsbInput w-full border-gray-300 rounded-lg shadow-sm px-3 py-2 text-center">
        </div>


        {{-- Tombol hapus --}}
        <div class="col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1 invisible">Aksi</label>
            <button type="button"
                    class="hapusProduk w-full text-red-600 hover:text-red-800 flex items-center justify-center"
                    title="Hapus" aria-label="Hapus produk">
                <i data-lucide="trash-2" class="w-5 h-5 pointer-events-none"></i>
            </button>
        </div>


        {{-- Hidden fields --}}
        <input type="hidden" name="harga_satuan[]" class="hargaSatuanHidden">
        <input type="hidden" name="harga_total[]" class="hargaTotalHidden">
        <input type="hidden" name="diskon_nominal[]" class="diskonNominalHidden">
        <input type="hidden" name="psb[]" class="psbHidden">
        <input type="hidden" name="psb_setelah_diskon[]" class="psbSetelahDiskonHidden">
        <input type="hidden" name="harga_setelah_diskon[]" class="hargaSetelahDiskonHidden">
        <input type="hidden" name="ppn_nominal[]" class="ppnNominalHidden">
        <input type="hidden" name="harga_akhir[]" class="hargaAkhirHidden">
        <input type="hidden" name="diskon_psb[]" class="diskonPsbHidden">
    </div>
</div>

<button type="button" id="tambahProduk"
        class="mt-3 bg-blue-900 hover:bg-blue-800 text-white font-semibold px-4 py-2 rounded-lg shadow">
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
                                <th rowspan="2" class="px-3 py-3 text-center">Jumlah</th>
                                <th rowspan="2" class="px-3 py-3 text-center">Durasi (Bulan)</th>
                                <th colspan="3" class="px-3 py-2 text-center bg-blue-700">Tarif Dasar</th>
                                <th rowspan="2" class="px-3 py-2 text-center bg-red-600">Diskon</th>
                                <th colspan="2" class="px-3 py-3 text-center">PSB</th>
                                <th colspan="3" class="px-3 py-2 text-center bg-green-700">Harga Penawaran</th>
                            </tr>
                            <tr class="bg-gray-700 text-white text-xs uppercase">
                                <th class="px-3 py-2 text-center">Satuan</th>
                                <th class="px-3 py-2 text-center">MC</th>
                                <th class="px-3 py-2 text-center">Total</th>
                                <th class="px-3 py-2 text-center">Biaya</th>
                                <th class="px-3 py-2 text-center">Diskon</th>
                                <th class="px-3 py-2 text-center">Satuan</th>
                                <th class="px-3 py-2 text-center">MC</th>
                                <th class="px-3 py-2 text-center">Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabelRingkasan" class="divide-y divide-gray-200 text-gray-700"></tbody>
                        <tfoot class="text-sm font-semibold">
                            <tr class="bg-gray-100">
                                <td colspan="4" class="px-3 py-2 text-right font-medium">Sub Total:</td>
                                <td class="px-3 py-2 text-right" id="subtotalSatuan">-</td>
                                <td class="px-3 py-2 text-right" id="subtotalMc">-</td>
                                <td class="px-3 py-2 text-right" id="subtotalTotal">-</td>
                                <td class="px-3 py-2 text-center text-red-600" id="subtotalDiskonLayanan">-</td>
                                <td class="px-3 py-2 text-right" id="subtotalPsb">-</td>
                                <td class="px-3 py-2 text-center" id="subtotalDiskonPsb">-</td>
                                
                                <td class="px-3 py-2 text-right text-green-700" id="subtotalPenawaranSatuan">-</td>
                                <td class="px-3 py-2 text-right" id="subtotalPenawaranMc">-</td>
                                <td class="px-3 py-2 text-right text-green-700" id="subtotalPenawaranTotal">-</td>
                            </tr>
                            {{-- <tr>
                                <td colspan="12" class="px-3 py-2 text-right">Total:</td>
                                <td class="px-3 py-2 text-right" id="totalAwal">-</td>
                            </tr> --}}
                            <tr>
                                <td colspan="12" class="px-3 py-2 text-right">PPN:</td>
                                <td class="px-3 py-2 text-right" id="ppnNominal">-</td>
                            </tr>
                            <tr class="bg-green-100 border-t-2 border-green-400">
                                <td colspan="12" class="px-3 py-3 text-right font-bold">Total Akhir:</td>
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
function formatRupiah(angka){return angka.toLocaleString('id-ID',{style:'currency',currency:'IDR'});}

function toggleDiskonField(select) {
    const opt = select.options[select.selectedIndex];
    const diskonMaks = parseFloat(opt?.dataset.diskonmaks) || 0;
    const produkItem = select.closest('.produkItem');
    const diskonInput = produkItem.querySelector('.diskonInput');
    const diskonMessage = produkItem.querySelector('.diskonMessage');

    diskonInput.dataset.diskonMaks = diskonMaks;

    if (diskonMaks === 0) {
        diskonInput.value = 0;
        diskonInput.readOnly = true;
        diskonInput.classList.add('bg-gray-100','text-gray-500');

        diskonMessage.classList.add('opacity-0');
    } else {
        diskonInput.readOnly = false;
        diskonInput.classList.remove('bg-gray-100','text-gray-500');

        diskonMessage.classList.add('opacity-0');

        diskonInput.oninput = null;

        diskonInput.addEventListener('input', function() {
            let value = parseFloat(this.value) || 0;

            if (value > 30) {
                diskonMessage.textContent = `Diskon maksimal ${diskonMaks}%`;

                // munculkan pesan
                diskonMessage.classList.remove('opacity-0');
                diskonMessage.classList.add('opacity-100');

                // kembalikan ke diskon maksimal
                this.value = diskonMaks;

                // sembunyikan pesan otomatis setelah 1.5 detik
                setTimeout(() => {
                    diskonMessage.classList.remove('opacity-100');
                    diskonMessage.classList.add('opacity-0');
                }, 1500);
            }
        });
    }
}



function toggleDiskonPsbField(select){
    const diskonPsbInput = select.closest('.produkItem').querySelector('.diskonPsbInput');
    diskonPsbInput.readOnly = false; // selalu bisa diinput
    diskonPsbInput.classList.remove('bg-gray-100','text-gray-500');
}

// Biar koma otomatis jadi titik di input diskon & diskon psb
document.addEventListener('input', e => {
    if (e.target.classList.contains('diskonInput') || e.target.classList.contains('diskonPsbInput')) {
        e.target.value = e.target.value.replace(',', '.'); 
    }
});


function hitungTotal() {
    let totalAwalLayanan = 0; // total tarif layanan sebelum diskon
    let totalPotonganLayanan = 0; // total potongan layanan
    let totalAwalPsb = 0; // total PSB sebelum diskon
    let totalPotonganPsb = 0; // total potongan PSB
    let totalSetelahDiskon = 0; // total keseluruhan setelah diskon

    const tbody = document.getElementById('tabelRingkasan');
    tbody.innerHTML = "";
    const produkList = document.querySelectorAll('#produkWrapper .produkItem');
    const ppnPersen = parseInt(document.getElementById('ppnSelect').value) || 0;
    let rowNo = 0;

    // subtotal untuk ringkasan
    let subtotalSatuan=0, subtotalMc=0, subtotalTotal=0;
    let subtotalPenawaranSatuan = 0;
    let subtotalPenawaranMc = 0;
    let subtotalPenawaranTotal=0;
    let subtotalPsb = 0;

    produkList.forEach(produk => {
        const select = produk.querySelector('.produkSelect');
        const opt = select?.selectedOptions?.[0];
        if(!opt || !select.value) return;
        rowNo++;

        const hargaSatuan = parseFloat(opt.dataset.harga) || 0;
        const psb = parseFloat(opt.dataset.psb) || 0;
        const qty = parseInt(produk.querySelector('.qtyInput')?.value || 1);
        const bulan = parseInt(produk.querySelector('.bulanInput')?.value || 1);
        const diskon = parseFloat(produk.querySelector('.diskonInput')?.value || 0);
        const diskonPsb = parseFloat(produk.querySelector('.diskonPsbInput')?.value || 0);

        const mc = hargaSatuan * qty;
        const tarifTotal = mc * bulan;
        const potonganLayanan = tarifTotal * (diskon / 100);
        const tarifSetelahDiskon = tarifTotal - potonganLayanan;
        const hargaSatuanSetelahDiskon = hargaSatuan * (1 - diskon / 100);
        const mcSetelahDiskon = hargaSatuanSetelahDiskon * qty;


        const potonganPsb = psb * (diskonPsb / 100);
        const psbSetelahDiskon = psb - potonganPsb;

        const subtotal = tarifSetelahDiskon + psbSetelahDiskon;

        totalAwalLayanan += tarifTotal;
        totalPotonganLayanan += potonganLayanan;
        totalAwalPsb += psb;
        totalPotonganPsb += potonganPsb;
        totalSetelahDiskon += subtotal;

        subtotalSatuan += hargaSatuan;
        subtotalMc += mc;
        subtotalTotal += tarifTotal;
        subtotalPsb += psb;
        subtotalPenawaranSatuan += hargaSatuanSetelahDiskon;
        subtotalPenawaranMc += mcSetelahDiskon;
        subtotalPenawaranTotal += subtotal;

        produk.querySelector('.hargaSatuanHidden').value = hargaSatuan;
        produk.querySelector('.hargaTotalHidden').value = tarifTotal;
        produk.querySelector('.diskonNominalHidden').value = potonganLayanan;
        produk.querySelector('.psbHidden').value = psb;
        produk.querySelector('.psbSetelahDiskonHidden').value = psbSetelahDiskon;
        produk.querySelector('.hargaSetelahDiskonHidden').value = subtotal;
        produk.querySelector('.ppnNominalHidden').value = subtotal * (ppnPersen / 100);
        produk.querySelector('.hargaAkhirHidden').value = subtotal * (1 + ppnPersen / 100);
        produk.querySelector('.diskonPsbHidden').value = diskonPsb;

        tbody.innerHTML += `<tr class="odd:bg-white even:bg-gray-50 hover:bg-blue-50 transition">
            <td class="px-3 py-2 text-center">${rowNo}</td>
            <td class="px-3 py-2">${opt.text}</td>
            <td class="px-3 py-2 text-center">${qty}</td>
            <td class="px-3 py-2 text-center">${bulan}</td>
            <td class="px-3 py-2 text-right">${formatRupiah(hargaSatuan)}</td>
            <td class="px-3 py-2 text-right">${formatRupiah(mc)}</td>
            <td class="px-3 py-2 text-right">${formatRupiah(tarifTotal)}</td>
            <td class="px-3 py-2 text-center text-red-600">${diskon.toFixed(2)}%</td>
            <td class="px-3 py-2 text-right">${formatRupiah(psb)}</td>
            <td class="px-3 py-2 text-center">${diskonPsb.toFixed(2)}%</td>
            
            <td class="px-3 py-2 text-right text-green-700">${formatRupiah(hargaSatuanSetelahDiskon)}</td>
            <td class="px-3 py-2 text-right">${formatRupiah(mcSetelahDiskon)}</td>
            <td class="px-3 py-2 text-right font-medium text-green-600">${formatRupiah(subtotal)}</td>
        </tr>`;
    });

    // total diskon layanan (%) = potongan layanan / total layanan
    const totalDiskonLayananPersen = totalAwalLayanan > 0 
        ? (totalPotonganLayanan / totalAwalLayanan) * 100 
        : 0;

    // total diskon PSB (%) = potongan PSB / total PSB
    const totalDiskonPsbPersen = totalAwalPsb > 0 
        ? (totalPotonganPsb / totalAwalPsb) * 100 
        : 0;

    document.getElementById('subtotalDiskonLayanan').innerText = totalDiskonLayananPersen.toFixed(2) + " %";
    document.getElementById('subtotalDiskonPsb').innerText = totalDiskonPsbPersen.toFixed(2) + " %";

    document.getElementById('subtotalSatuan').innerText = formatRupiah(subtotalSatuan);
    document.getElementById('subtotalMc').innerText = formatRupiah(subtotalMc);
    document.getElementById('subtotalTotal').innerText = formatRupiah(subtotalTotal);
    document.getElementById('subtotalPsb').innerText = formatRupiah(subtotalPsb);
    document.getElementById('subtotalPenawaranSatuan').innerText = formatRupiah(subtotalPenawaranSatuan);
    document.getElementById('subtotalPenawaranMc').innerText = formatRupiah(subtotalPenawaranMc);
    document.getElementById('subtotalPenawaranTotal').innerText = formatRupiah(subtotalPenawaranTotal);

    const ppnNominal = totalSetelahDiskon * (ppnPersen / 100);
    document.getElementById('ppnNominal').innerText = formatRupiah(ppnNominal);
    document.getElementById('totalAkhir').innerText = formatRupiah(totalSetelahDiskon + ppnNominal);

    document.getElementById('totalHarga').value = totalAwalLayanan + totalAwalPsb;
    document.getElementById('totalPotongan').value = totalPotonganLayanan + totalPotonganPsb;
    document.getElementById('penawaran').value = totalSetelahDiskon + ppnNominal;

    document.getElementById('ringkasanBox').classList.remove('hidden');
}

const produkWrapper=document.getElementById('produkWrapper');

produkWrapper.addEventListener('change', e=>{
    if(e.target.classList.contains('produkSelect')){
        toggleDiskonField(e.target);
        toggleDiskonPsbField(e.target);
    }
    hitungTotal();
});

produkWrapper.addEventListener('input', e => {
    if (e.target.classList.contains('diskonInput') || e.target.classList.contains('diskonPsbInput')) {
        let val = parseFloat(e.target.value) || 0;

        // ambil max diskon dari attribute
        let diskonMaks = parseFloat(e.target.dataset.diskonMaks) || 100;

        // nilai input dipaksa antara 0 dan diskonMaks
        e.target.value = Math.min(Math.max(val, 0), diskonMaks);
    }
    hitungTotal();
});


document.getElementById('tambahProduk').addEventListener('click', ()=>{
    const wrapper=document.getElementById('produkWrapper');
    const clone=wrapper.querySelector('.produkItem').cloneNode(true);
    clone.querySelectorAll('input[type="hidden"]').forEach(h=>h.value=0);
    clone.querySelector('.produkSelect').selectedIndex=0;
    clone.querySelector('.qtyInput').value=1;
    clone.querySelector('.bulanInput').value=1;
    clone.querySelector('.diskonInput').value=0;
    clone.querySelector('.diskonInput').readOnly=true;
    clone.querySelector('.diskonInput').classList.add('bg-gray-100','text-gray-500');
    clone.querySelector('.diskonPsbInput').value=0;
    clone.querySelector('.diskonPsbInput').readOnly=false;
    clone.querySelector('.diskonPsbInput').classList.remove('bg-gray-100','text-gray-500');
    wrapper.appendChild(clone);
});

document.addEventListener('DOMContentLoaded', ()=>{
    document.querySelectorAll('.produkSelect').forEach(s=>{
        toggleDiskonField(s);
        toggleDiskonPsbField(s);
    });
    hitungTotal();
});

// Event delegation untuk tombol hapus produk
produkWrapper.addEventListener('click', e => {
    if (e.target.classList.contains('hapusProduk')) {
        const produkItem = e.target.closest('.produkItem');
        
        // Jangan hapus kalau hanya ada 1 produk
        if (document.querySelectorAll('#produkWrapper .produkItem').length > 1) {
            produkItem.remove();
            hitungTotal();
        } else {
            alert("Minimal harus ada 1 produk.");
        }
    }
});


document.getElementById('ppnSelect').addEventListener('change', hitungTotal);
</script>
@endsection