@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto px-6 py-6">

    {{-- Header --}}
    <h1 class="text-2xl font-bold mb-6">Selamat Datang, Admin 👋</h1>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Jumlah Produk</p>
            <h2 class="text-2xl font-bold text-indigo-600">{{ $jumlahProduk }}</h2>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-md">
            <p class="text-sm text-gray-500">Total Penawaran</p>
            <h2 class="text-2xl font-bold text-green-600">{{ $totalPenawaran }}</h2>
        </div>
    </div>

    {{-- Grafik Penawaran Bulanan --}}
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <h2 class="text-lg font-semibold mb-4">Grafik Penawaran Bulanan</h2>
        <div class="w-full">
            {{-- Tinggi grafik diperkecil --}}
            <canvas id="penawaranChart" class="w-full h-48"></canvas>
        </div>
    </div>

    {{-- Tabel Ringkas --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-lg font-semibold mb-4">Penawaran Terbaru</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-blue-950 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold">#</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Nama Konsumen</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Total Harga</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                    @forelse ($penawaranTerbaru as $index => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $index + 1 }}</td>
                            <td class="px-6 py-3">{{ $p->nama }}</td>
                            <td class="px-6 py-3">Rp {{ number_format($p->total_akhir, 0, ',', '.') }}</td>
                            <td class="px-6 py-3">{{ $p->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-3 text-center text-gray-500">Belum ada penawaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 text-right">
            <a href="{{ route('penawaran.riwayat') }}" class="text-indigo-600 hover:underline text-sm font-medium">
                Lihat Semua →
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('penawaranChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar', // bisa diganti 'line'
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Jumlah Penawaran',
                data: @json($data),
                backgroundColor: 'rgba(79, 70, 229, 0.6)', // indigo
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // biar tinggi mengikuti class h-48
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endpush
