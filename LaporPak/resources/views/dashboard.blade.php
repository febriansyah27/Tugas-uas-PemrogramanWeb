<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Warga
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h3>
                <p class="text-gray-600 mb-6">Ini adalah dashboard Anda. Silakan buat laporan pengaduan baru atau cek riwayat laporan Anda.</p>
                
                <div class="flex space-x-4">
                    <a href="{{ route('pengaduan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Buat Laporan Baru
                    </a>
                    <a href="{{ route('pengaduan.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Riwayat Laporan Saya
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>