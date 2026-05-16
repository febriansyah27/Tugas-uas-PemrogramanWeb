<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LaporPak - @yield('title', 'Sistem Pengaduan Warga')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1d4ed8',
                        secondary: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        .badge-terkirim  { @apply bg-blue-100 text-blue-800; }
        .badge-diproses  { @apply bg-yellow-100 text-yellow-800; }
        .badge-selesai   { @apply bg-green-100 text-green-800; }
        .badge-ditolak   { @apply bg-red-100 text-red-800; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- ======= NAVIGASI ======= --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                {{-- Logo --}}
                <div class="flex items-center space-x-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-900">
                        LaporPak
                    </a>
                </div>

                {{-- Menu berdasarkan role --}}
                @auth
                <div class="flex items-center space-x-4">
                    @if(auth()->user()->role === 'petugas')
                        {{-- Menu Petugas --}}
                        <a href="{{ route('petugas.index') }}"
                           class="text-sm font-medium text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-50 transition">
                            🗂️ Kelola Pengaduan
                        </a>
                    @else
                        {{-- Menu Warga --}}
                        <a href="{{ route('warga.create') }}"
                           class="text-sm font-medium text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-50 transition">
                            ✏️ Buat Laporan
                        </a>
                        <a href="{{ route('warga.index') }}"
                           class="text-sm font-medium text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md hover:bg-blue-50 transition">
                            📋 Riwayat Laporan
                        </a>
                    @endif

                    {{-- User info & logout --}}
                    <div class="flex items-center space-x-3 ml-4 pl-4 border-l border-gray-200">
                        <div class="text-right hidden sm:block">
                            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm text-red-600 hover:text-red-800 font-medium px-3 py-1.5 rounded-md border border-red-200 hover:bg-red-50 transition">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ======= FLASH MESSAGES ======= --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center space-x-2">
                <span>❌</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    {{-- ======= KONTEN UTAMA ======= --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- ======= FOOTER ======= --}}
    <footer class="bg-white border-t border-gray-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} LaporPak — Sistem Pengaduan Warga Digital
        </div>
    </footer>

    @stack('scripts')

</body>
</html>
