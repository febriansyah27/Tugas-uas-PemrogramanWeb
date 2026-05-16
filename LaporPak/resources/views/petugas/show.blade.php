@extends('layouts.app')
@section('title', 'Detail Pengaduan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <a href="{{ route('petugas.index') }}" class="hover:text-blue-600">Kelola Pengaduan</a>
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

        <div class="p-6 grid sm:grid-cols-3 gap-6">
            {{-- Konten kiri --}}
            <div class="sm:col-span-2 space-y-5">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Isi Laporan</p>
                    <p class="text-gray-700 leading-relaxed">{{ $pengaduan->isi_laporan }}</p>
                </div>

                @if($pengaduan->foto)
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Foto Bukti</p>
                    <img src="{{ asset('storage/' . $pengaduan->foto) }}"
                         alt="Foto pengaduan"
                         class="w-full max-w-sm rounded-lg border border-gray-200 shadow-sm object-cover cursor-pointer"
                         onclick="document.getElementById('modal-foto').classList.remove('hidden')">
                    <p class="text-xs text-gray-400 mt-1">Klik foto untuk perbesar</p>
                </div>
                @endif
            </div>

            {{-- Panel kanan --}}
            <div class="space-y-4">
                {{-- Info pelapor --}}
                <div class="bg-gray-50 rounded-xl p-4 space-y-3 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Pelapor</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $pengaduan->user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Tanggal Lapor</p>
                        <p class="text-gray-800">{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Jumlah Tanggapan</p>
                        <p class="font-semibold text-gray-800">{{ $pengaduan->tanggapans->count() }} tanggapan</p>
                    </div>
                </div>

                {{-- Update Status --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">Update Status</p>
                    <form action="{{ route('petugas.update', $pengaduan->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 mb-3 bg-white">
                            <option value="terkirim"  {{ $pengaduan->status=='terkirim'  ? 'selected':'' }}>📤 Terkirim</option>
                            <option value="diproses"  {{ $pengaduan->status=='diproses'  ? 'selected':'' }}>⚙️ Diproses</option>
                            <option value="selesai"   {{ $pengaduan->status=='selesai'   ? 'selected':'' }}>✅ Selesai</option>
                            <option value="ditolak"   {{ $pengaduan->status=='ditolak'   ? 'selected':'' }}>❌ Ditolak</option>
                        </select>
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2 rounded-lg transition">
                            Simpan Status
                        </button>
                    </form>
                </div>

                {{-- Cetak & Hapus --}}
                <a href="{{ route('petugas.cetak', $pengaduan->id) }}" target="_blank"
                   class="w-full flex items-center justify-center gap-2 border border-gray-300 text-gray-600 hover:bg-gray-50 text-sm font-medium py-2 rounded-lg transition">
                    🖨️ Cetak Laporan
                </a>

                <button onclick="document.getElementById('modal-hapus').classList.remove('hidden')"
                    class="w-full border border-red-300 text-red-600 hover:bg-red-50 text-sm font-medium py-2 rounded-lg transition">
                    🗑️ Hapus Pengaduan
                </button>
            </div>
        </div>
    </div>

    {{-- Card Tanggapan --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-bold text-gray-900">💬 Tanggapan</h2>
            <span class="text-xs bg-gray-100 text-gray-500 px-2 py-1 rounded-full">
                {{ $pengaduan->tanggapans->count() }}
            </span>
        </div>

        <div class="p-6">
            {{-- Daftar tanggapan --}}
            @if($pengaduan->tanggapans->isEmpty())
                <div class="text-center py-6 text-gray-400 mb-6">
                    <p class="text-sm">Belum ada tanggapan. Kirim tanggapan pertama di bawah.</p>
                </div>
            @else
                <div class="space-y-4 mb-6">
                    @foreach($pengaduan->tanggapans as $tanggapan)
                    <div class="flex gap-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr($tanggapan->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <p class="text-sm font-semibold text-gray-800">{{ $tanggapan->user->name }}</p>
                                        <span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Petugas</span>
                                    </div>
                                    <form action="{{ route('petugas.tanggapan.destroy', $tanggapan->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus tanggapan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 text-xs px-2 py-1 rounded hover:bg-red-50">✕ Hapus</button>
                                    </form>
                                </div>
                                <p class="text-sm text-gray-700 leading-relaxed">{{ $tanggapan->isi_tanggapan }}</p>
                            </div>
                            <p class="text-xs text-gray-400 mt-1 ml-1">{{ $tanggapan->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif

            {{-- Form tambah tanggapan --}}
            <div class="border-t border-gray-100 pt-5">
                <h3 class="text-sm font-bold text-gray-700 mb-3">✏️ Tulis Tanggapan</h3>
                <form action="{{ route('petugas.tanggapan.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="pengaduan_id" value="{{ $pengaduan->id }}">
                    <textarea name="isi_tanggapan" rows="4"
                        placeholder="Tulis tanggapan atau tindak lanjut di sini (min. 10 karakter)..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none
                               {{ $errors->has('isi_tanggapan') ? 'border-red-400 bg-red-50' : '' }}">{{ old('isi_tanggapan') }}</textarea>
                    @error('isi_tanggapan')
                        <p class="text-xs text-red-600">⚠️ {{ $message }}</p>
                    @enderror
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
                            📨 Kirim Tanggapan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('petugas.index') }}" class="inline-flex items-center gap-1 text-sm text-gray-600 hover:text-gray-900 font-medium">
        ← Kembali ke Daftar Pengaduan
    </a>
</div>

{{-- Modal Foto --}}
@if($pengaduan->foto)
<div id="modal-foto" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4"
     onclick="this.classList.add('hidden')">
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="max-w-2xl max-h-screen rounded-lg shadow-2xl" alt="Foto">
    <p class="absolute bottom-6 text-white text-sm opacity-70">Klik di mana saja untuk tutup</p>
</div>
@endif

{{-- Modal Konfirmasi Hapus --}}
<div id="modal-hapus" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-6 max-w-sm w-full">
        <div class="text-center mb-4">
            <div class="text-5xl mb-3">⚠️</div>
            <h3 class="text-lg font-bold text-gray-900">Hapus Pengaduan?</h3>
            <p class="text-sm text-gray-500 mt-2">Data pengaduan beserta semua tanggapan akan dihapus permanen dan tidak bisa dikembalikan.</p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('modal-hapus').classList.add('hidden')"
                class="flex-1 border border-gray-300 text-gray-700 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                Batal
            </button>
            <form action="{{ route('petugas.destroy', $pengaduan->id) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-lg text-sm font-semibold transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
