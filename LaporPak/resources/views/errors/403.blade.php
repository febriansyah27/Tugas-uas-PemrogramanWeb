@extends('layouts.app')
@section('title', 'Akses Ditolak')

@section('content')
<div class="max-w-md mx-auto py-20 px-4">
    <div class="text-center">
        <div class="text-7xl font-bold text-red-600 mb-4">403</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Akses Ditolak</h1>
        <p class="text-gray-600 mb-6">Anda tidak memiliki izin untuk mengakses halaman ini.</p>

        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6 text-left">
            <p class="text-sm text-yellow-800">
                <strong>💡 Info:</strong> Halaman ini hanya dapat diakses oleh Petugas. Jika Anda adalah Petugas, hubungi admin untuk aktivasi akun Anda.
            </p>
        </div>

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
