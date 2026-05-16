@extends('layouts.app')
@section('title', 'Detail Laporan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('warga.index') }}" class="hover:text-blue-600">Riwayat Laporan</a>
        <span>/</span>
        <span class="text-gray-900 font-medium">Detail #{{ $pengaduan->id }}</span>
    </div>

    {{-- Card Detail --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <h1 class="text-xl font-bold text-white">{{ $pengaduan->judul }}</h1>
                    <p class="text-blue-200 text-sm mt-1">📍 {{ $pengaduan->alamat }}</p>
                </div>
                <x-status-badge :status="$pengaduan->status" />
            </div>
        </div>

        <div class="p-6 space-y-5">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Isi Laporan</p>
                <p class="text-gray-700 leading-relaxed">{{ $pengaduan->isi_laporan }}</p>
            </div>

            @if($pengaduan->foto)
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Foto Bukti</p>
                <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                     alt="Foto laporan"
                     class="w-full max-w-sm rounded-lg border border-gray-200 shadow-sm object-cover">
            </div>
            @endif

            <div class="grid grid-cols-2 gap-4 bg-gray-50 rounded-lg p-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 font-medium">Tanggal Lapor</p>
                    <p class="text-gray-800 font-semibold">{{ $pengaduan->created_at->format('d F Y') }}</p>
                    <p class="text-gray-500 text-xs">{{ $pengaduan->created_at->format('H:i') }} WIB</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium">Status</p>
                    <x-status-badge :status="$pengaduan->status" />
                </div>
            </div>

            {{-- Tombol Cetak Bukti --}}
            <div class="flex justify-end">
                <a href="{{ route('warga.cetak', $pengaduan->id) }}" target="_blank"
                   class="inline-flex items-center gap-2 text-sm border border-gray-300 text-gray-600 hover:bg-gray-50 px-4 py-2 rounded-lg transition font-medium">
                    🖨️ Cetak Bukti Laporan
                </a>
            </div>
        </div>
    </div>

    {{-- Card Tanggapan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">💬 Tanggapan Petugas</h2>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">
                {{ $pengaduan->tanggapans->count() }} tanggapan
            </span>
        </div>

        <div class="p-6">
            @if($pengaduan->tanggapans->isEmpty())
                <div class="text-center py-10">
                    <div class="text-4xl mb-3">⏳</div>
                    <p class="text-gray-600 font-semibold">Menunggu Tanggapan</p>
                    <p class="text-sm text-gray-400 mt-1">Petugas akan segera menindaklanjuti laporan Anda.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($pengaduan->tanggapans as $tanggapan)
                    <div class="flex gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr($tanggapan->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                                <div class="flex items-center gap-2 mb-1">
                                    <p class="text-sm font-semibold text-gray-800">{{ $tanggapan->user->name }}</p>
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Petugas</span>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $tanggapan->isi_tanggapan }}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 ml-1">
                                {{ $tanggapan->created_at->format('d M Y, H:i') }} WIB
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <a href="{{ route('warga.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 font-medium">
        ← Kembali ke Riwayat Laporan
    </a>

</div>
@endsection
