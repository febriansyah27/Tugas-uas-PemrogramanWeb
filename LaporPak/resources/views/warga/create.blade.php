<!-- resources/views/warga/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Laporan Pengaduan Baru
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Pesan Error Validasi -->
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Judul Laporan</label>
                        <input type="text" name="judul" class="w-full border rounded-md py-2 px-3" value="{{ old('judul') }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Isi Laporan</label>
                        <textarea name="isi_laporan" rows="4" class="w-full border rounded-md py-2 px-3">{{ old('isi_laporan') }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Alamat Lokasi</label>
                        <input type="text" name="alamat" class="w-full border rounded-md py-2 px-3" value="{{ old('alamat') }}">
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Upload Foto Lokasi</label>
                        <input type="file" name="foto" class="w-full border rounded-md py-2 px-3">
                        <p class="text-sm text-gray-500 mt-1">Format: jpg, png. Maks: 2MB</p>
                    </div>

                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Kirim Laporan
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>