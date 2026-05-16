@extends('layouts.app')
@section('title', 'Tidak Ditemukan')

@section('content')
<div class="max-w-md mx-auto py-20 px-4">
    <div class="text-center">
        <div class="text-7xl font-bold text-gray-900 mb-4">404</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-600 mb-6">Maaf, halaman yang Anda cari tidak ada atau telah dihapus.</p>

        <div class="flex flex-col gap-3">
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                ← Kembali ke Dashboard
            </a>
            <a href="{{ route('warga.index') }}"
               class="inline-block text-gray-600 hover:text-gray-900 font-medium">
                Atau ke Halaman Utama
            </a>
        </div>
    </div>
</div>
@endsection
