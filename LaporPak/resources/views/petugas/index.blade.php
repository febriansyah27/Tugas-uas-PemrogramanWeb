@extends('layouts.app')
@section('title', 'Dashboard Petugas')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">🗂️ Kelola Pengaduan</h1>
            <p class="text-sm text-gray-500 mt-1">Seluruh laporan warga Kota Palu.</p>
        </div>
        {{-- Export CSV --}}
        <a href="{{ route('petugas.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
           class="flex items-center gap-2 text-sm bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2.5 rounded-lg transition">
            📥 Export CSV
        </a>
    </div>

    {{-- Statistik --}}
    @php
        use App\Models\Pengaduan;
        $statTotal    = Pengaduan::count();
        $statTerkirim = Pengaduan::where('status','terkirim')->count();
        $statDiproses = Pengaduan::where('status','diproses')->count();
        $statSelesai  = Pengaduan::where('status','selesai')->count();
        $statDitolak  = Pengaduan::where('status','ditolak')->count();
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
        <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-gray-900">{{ $statTotal }}</p>
            <p class="text-xs text-gray-500 mt-1">Total</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-blue-700">{{ $statTerkirim }}</p>
            <p class="text-xs text-blue-600 mt-1">Terkirim</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-yellow-700">{{ $statDiproses }}</p>
            <p class="text-xs text-yellow-600 mt-1">Diproses</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-green-700">{{ $statSelesai }}</p>
            <p class="text-xs text-green-600 mt-1">Selesai</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-red-700">{{ $statDitolak }}</p>
            <p class="text-xs text-red-600 mt-1">Ditolak</p>
        </div>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4">
        <form method="GET" action="{{ route('petugas.index') }}" class="flex flex-wrap gap-3 items-end">

            {{-- Cari --}}
            <div class="flex-1 min-w-48">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Cari</label>
                <input type="text" name="cari" value="{{ request('cari') }}"
                    placeholder="Judul atau nama pelapor..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            {{-- Filter Status --}}
            <div class="min-w-36">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">Semua Status</option>
                    <option value="terkirim" {{ request('status')=='terkirim' ? 'selected':'' }}>📤 Terkirim</option>
                    <option value="diproses" {{ request('status')=='diproses' ? 'selected':'' }}>⚙️ Diproses</option>
                    <option value="selesai"  {{ request('status')=='selesai'  ? 'selected':'' }}>✅ Selesai</option>
                    <option value="ditolak"  {{ request('status')=='ditolak'  ? 'selected':'' }}>❌ Ditolak</option>
                </select>
            </div>

            {{-- Filter Kecamatan --}}
            <div class="min-w-40">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-1">Kecamatan</label>
                <select name="kecamatan" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">Semua Kecamatan</option>
                    @foreach(['Palu Barat','Palu Timur','Palu Selatan','Palu Utara','Tatanga','Ulujadi','Mantikulore','Tawaeli'] as $kec)
                    <option value="{{ $kec }}" {{ request('kecamatan')==$kec ? 'selected':'' }}>{{ $kec }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Tombol --}}
            <div class="flex gap-2">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition">
                    🔍 Filter
                </button>
                <a href="{{ route('petugas.index') }}"
                   class="border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm font-medium px-4 py-2 rounded-lg transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Pengaduan --}}
    @if($pengaduans->isEmpty())
        <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
            <div class="text-5xl mb-4">🔍</div>
            <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Data</h3>
            <p class="text-sm text-gray-500 mt-2">Tidak ada pengaduan yang sesuai filter.</p>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Laporan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Pelapor</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Tanggal</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($pengaduans as $index => $pengaduan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400 text-xs">{{ $pengaduans->firstItem() + $index }}</td>
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900 leading-tight">{{ $pengaduan->judul }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 line-clamp-1">📍 {{ $pengaduan->alamat }}</p>
                        </td>
                        <td class="px-4 py-3 hidden sm:table-cell">
                            <p class="font-medium text-gray-700 text-xs">{{ $pengaduan->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $pengaduan->user->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500 hidden md:table-cell">
                            {{ $pengaduan->created_at->format('d M Y') }}<br>
                            <span class="text-gray-400">{{ $pengaduan->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$pengaduan->status" />
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('petugas.show', $pengaduan->id) }}"
                               class="inline-flex items-center gap-1 text-xs bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition font-medium">
                                🔍 Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            @if($pengaduans->hasPages())
            <div class="px-4 py-4 border-t border-gray-100 bg-gray-50">
                {{ $pengaduans->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    @endif

</div>
@endsection
