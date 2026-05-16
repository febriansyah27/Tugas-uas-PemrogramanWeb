@extends('layouts.app')
@section('title', 'Kesalahan Server')

@section('content')
<div class="max-w-md mx-auto py-20 px-4">
    <div class="text-center">
        <div class="text-7xl font-bold text-red-700 mb-4">500</div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Kesalahan Server</h1>
        <p class="text-gray-600 mb-6">Maaf, terjadi kesalahan pada server kami. Tim kami sedang memperbaikinya.</p>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6 text-left">
            <p class="text-sm text-red-800">
                <strong>⚠️ Catatan:</strong> Jika masalah ini terus berlanjut, silahkan hubungi tim support kami.
            </p>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('dashboard') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">
                ← Kembali ke Dashboard
            </a>
            <a href="/"
               class="inline-block text-gray-600 hover:text-gray-900 font-medium">
                Atau ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
