@extends('layouts.app')
@section('title', 'Riwayat Laporan Saya')

@section('content')
<div class="max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📋 Riwayat Laporan Saya</h1>
            <p class="mt-1 text-sm text-gray-600">Pantau status dan tanggapan laporan Anda.</p>
        </div>
        <a href="{{ route('warga.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition flex items-center gap-2">
            + Buat Laporan
        </a>
    </div>

    {{-- Statistik --}}
    @php
        $all      = auth()->user()->pengaduans();
        $total    = $all->count();
        $terkirim = $all->where('status','terkirim')->count();
        $diproses = $all->where('status','diproses')->count();
        $selesai  = $all->where('status','selesai')->count();
    @endphp
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white border border-gray-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-gray-900">{{ $total }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Laporan</p>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-blue-700">{{ $terkirim }}</p>
            <p class="text-xs text-blue-600 mt-1">Terkirim</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-yellow-700">{{ $diproses }}</p>
            <p class="text-xs text-yellow-600 mt-1">Diproses</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-2xl font-bold text-green-700">{{ $selesai }}</p>
            <p class="text-xs text-green-600 mt-1">Selesai</p>
        </div>
    </div>

    {{-- Tabel --}}
    @if($pengaduans->isEmpty())
        <div class="bg-white rounded-xl border border-gray-200 p-16 text-center">
            <div class="text-5xl mb-4">📭</div>
            <h3 class="text-lg font-semibold text-gray-700">Belum Ada Laporan</h3>
            <p class="text-sm text-gray-500 mt-2">Anda belum pernah mengirim pengaduan.</p>
            <a href="{{ route('warga.create') }}"
               class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition">
                Buat Laporan Pertama
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Judul Laporan</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Tanggal</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase">Tanggapan</th>
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
                        <td class="px-4 py-3 text-xs text-gray-500 hidden sm:table-cell">
                            {{ $pengaduan->created_at->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <x-status-badge :status="$pengaduan->status" />
                        </td>
                        <td class="px-4 py-3">
                            @if($pengaduan->tanggapans_count > 0)
                                {{-- Badge merah jika ada tanggapan baru --}}
                                <span class="inline-flex items-center gap-1 text-xs font-semibold text-white bg-green-500 px-2 py-1 rounded-full">
                                    💬 {{ $pengaduan->tanggapans_count }}
                                </span>
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('warga.show', $pengaduan->id) }}"
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
                {{ $pengaduans->links() }}
            </div>
            @endif
        </div>
    @endif

</div>
@endsection
