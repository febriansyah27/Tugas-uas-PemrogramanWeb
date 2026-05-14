<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Laporan Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Pesan Sukses -->
            @session('success')
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ $value }}
                </div>
            @endsession

            <div class="mb-4">
                <a href="{{ route('pengaduan.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buat Laporan Baru</a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 text-left">Foto</th>
                            <th class="px-4 py-2 text-left">Judul</th>
                            <th class="px-4 py-2 text-left">Tanggal</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengaduans as $item)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                <img src="{{ Storage::url($item->foto) }}" alt="Foto" class="w-20 h-20 object-cover rounded">
                            </td>
                            <td class="px-4 py-2">{{ $item->judul }}</td>
                            <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded text-xs font-bold
                                    {{ $item->status == 'terkirim' ? 'bg-blue-200 text-blue-800' : '' }}
                                    {{ $item->status == 'diproses' ? 'bg-yellow-200 text-yellow-800' : '' }}
                                    {{ $item->status == 'selesai' ? 'bg-green-200 text-green-800' : '' }}
                                ">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>