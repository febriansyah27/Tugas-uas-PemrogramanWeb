@extends('layouts.app')
@section('title', 'Buat Laporan Baru')

@section('content')
<div class="max-w-2xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">📝 Buat Laporan Baru</h1>
        <p class="mt-1 text-sm text-gray-600">Isi formulir di bawah ini untuk mengirimkan pengaduan Anda.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('warga.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Judul --}}
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                    Judul Laporan <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="{{ old('judul') }}"
                    placeholder="Contoh: Jalan Berlubang di Jl. Merdeka"
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                           {{ $errors->has('judul') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">
                @error('judul')
                    <p class="mt-1 text-xs text-red-600">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Isi Laporan --}}
            <div>
                <label for="isi_laporan" class="block text-sm font-medium text-gray-700 mb-1">
                    Isi Laporan <span class="text-red-500">*</span>
                </label>
                <textarea
                    id="isi_laporan"
                    name="isi_laporan"
                    rows="4"
                    placeholder="Deskripsikan masalah yang Anda temui secara lengkap..."
                    class="w-full px-4 py-2.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none
                           {{ $errors->has('isi_laporan') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}">{{ old('isi_laporan') }}</textarea>
                @error('isi_laporan')
                    <p class="mt-1 text-xs text-red-600">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- ===================== LOKASI BERTINGKAT ===================== --}}
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">
                    Lokasi Kejadian <span class="text-red-500">*</span>
                </label>

                <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-2.5 text-sm text-blue-700 font-medium">
                    📍 Kota Palu, Sulawesi Tengah
                </div>

                {{-- Step 1: Pilih Kecamatan --}}
                <div>
                    <label for="kecamatan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        1. Pilih Kecamatan
                    </label>
                    <select id="kecamatan" name="kecamatan"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Pilih Kecamatan --</option>
                        <option value="Palu Barat"     {{ old('kecamatan') == 'Palu Barat'     ? 'selected' : '' }}>Palu Barat</option>
                        <option value="Palu Timur"     {{ old('kecamatan') == 'Palu Timur'     ? 'selected' : '' }}>Palu Timur</option>
                        <option value="Palu Selatan"   {{ old('kecamatan') == 'Palu Selatan'   ? 'selected' : '' }}>Palu Selatan</option>
                        <option value="Palu Utara"     {{ old('kecamatan') == 'Palu Utara'     ? 'selected' : '' }}>Palu Utara</option>
                        <option value="Tatanga"        {{ old('kecamatan') == 'Tatanga'        ? 'selected' : '' }}>Tatanga</option>
                        <option value="Ulujadi"        {{ old('kecamatan') == 'Ulujadi'        ? 'selected' : '' }}>Ulujadi</option>
                        <option value="Mantikulore"    {{ old('kecamatan') == 'Mantikulore'    ? 'selected' : '' }}>Mantikulore</option>
                        <option value="Tawaeli"        {{ old('kecamatan') == 'Tawaeli'        ? 'selected' : '' }}>Tawaeli</option>
                    </select>
                </div>

                {{-- Step 2: Pilih Kelurahan (muncul setelah pilih kecamatan) --}}
                <div id="box-kelurahan" class="{{ old('kecamatan') ? '' : 'hidden' }}">
                    <label for="kelurahan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        2. Pilih Kelurahan
                    </label>
                    <select id="kelurahan" name="kelurahan"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                        <option value="">-- Pilih Kelurahan --</option>
                    </select>
                </div>

                {{-- Step 3: Nama Jalan --}}
                <div id="box-jalan" class="{{ old('kecamatan') ? '' : 'hidden' }}">
                    <label for="nama_jalan" class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        3. Nama Jalan / RT / RW (opsional)
                    </label>
                    <input
                        type="text"
                        id="nama_jalan"
                        name="nama_jalan"
                        value="{{ old('nama_jalan') }}"
                        placeholder="Contoh: Jl. Kartini No. 5, RT 02/RW 03"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Hasil Alamat Lengkap (readonly, dikirim ke server) --}}
                <div id="box-hasil" class="{{ old('alamat') ? '' : 'hidden' }}">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">
                        Alamat Lengkap
                    </label>
                    <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-lg px-4 py-2.5">
                        <span class="text-green-600">✅</span>
                        <span id="preview-alamat" class="text-sm text-green-800 font-medium">{{ old('alamat') }}</span>
                    </div>
                    <input type="hidden" id="alamat" name="alamat" value="{{ old('alamat') }}">
                </div>

                @error('alamat')
                    <p class="text-xs text-red-600">⚠️ {{ $message }}</p>
                @enderror
            </div>
            {{-- ============================================================ --}}

            {{-- Upload Foto --}}
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                    Foto Bukti <span class="text-gray-400 font-normal">(opsional, maks. 2MB)</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-400 transition
                            {{ $errors->has('foto') ? 'border-red-400 bg-red-50' : '' }}">
                    <input type="file" id="foto" name="foto" accept="image/*"
                           class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                  file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="mt-2 text-xs text-gray-400">JPG, PNG, GIF hingga 2MB</p>
                </div>
                @error('foto')
                    <p class="mt-1 text-xs text-red-600">⚠️ {{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-between pt-2">
                <a href="{{ route('warga.index') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                    ← Kembali
                </a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-6 py-2.5 rounded-lg transition">
                    📤 Kirim Laporan
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ===================== DATA KELURAHAN KOTA PALU ===================== --}}
<script>
const dataKelurahan = {
    "Palu Barat": [
        "Baru", "Balaroa", "Ujuna", "Kamonji", "Sungguminasa",
        "Lere", "Siranindi", "Silae"
    ],
    "Palu Timur": [
        "Besusu Barat", "Besusu Tengah", "Besusu Timur",
        "Lasoani", "Poboya", "Tondo", "Talise"
    ],
    "Palu Selatan": [
        "Birobuli Selatan", "Birobuli Utara", "Palupi",
        "Petobo", "Tatura Selatan", "Tatura Utara", "Pengawu"
    ],
    "Palu Utara": [
        "Boyaoge", "Donggala Kodi", "Lambara", "Mamboro",
        "Mamboro Barat", "Nunu", "Taipa"
    ],
    "Tatanga": [
        "Duyu", "Tanamodindi", "Tavanjuka", "Layana Indah",
        "Pengawu", "Vatutela", "Boyaoge"
    ],
    "Ulujadi": [
        "Buluri", "Donggala Kodi", "Kabonena", "Kayumalue Ngapa",
        "Kayumalue Pajeko", "Panau", "Tipo"
    ],
    "Mantikulore": [
        "Kawatuna", "Lasoani", "Poboya", "Talise",
        "Tondo", "Tanamodindi", "Pantoloan Boya"
    ],
    "Tawaeli": [
        "Baiya", "Lambara", "Pantoloan", "Pantoloan Boya",
        "Kayumalue Ngapa", "Kayumalue Pajeko", "Mamboro"
    ]
};

const selKecamatan = document.getElementById('kecamatan');
const selKelurahan = document.getElementById('kelurahan');
const inputJalan   = document.getElementById('nama_jalan');
const hiddenAlamat = document.getElementById('alamat');
const previewAlamat = document.getElementById('preview-alamat');

const boxKelurahan = document.getElementById('box-kelurahan');
const boxJalan     = document.getElementById('box-jalan');
const boxHasil     = document.getElementById('box-hasil');

// Fungsi update dropdown kelurahan
function updateKelurahan(kecamatan, selectedKel = '') {
    selKelurahan.innerHTML = '<option value="">-- Pilih Kelurahan --</option>';
    if (!kecamatan || !dataKelurahan[kecamatan]) return;

    dataKelurahan[kecamatan].forEach(kel => {
        const opt = document.createElement('option');
        opt.value = kel;
        opt.textContent = kel;
        if (kel === selectedKel) opt.selected = true;
        selKelurahan.appendChild(opt);
    });
}

// Fungsi build alamat lengkap
function buildAlamat() {
    const kec = selKecamatan.value;
    const kel = selKelurahan.value;
    const jln = inputJalan.value.trim();

    if (!kec || !kel) {
        hiddenAlamat.value = '';
        boxHasil.classList.add('hidden');
        return;
    }

    let alamat = `Kel. ${kel}, Kec. ${kec}, Kota Palu, Sulawesi Tengah`;
    if (jln) alamat = `${jln}, ${alamat}`;

    hiddenAlamat.value = alamat;
    previewAlamat.textContent = alamat;
    boxHasil.classList.remove('hidden');
}

// Event: pilih kecamatan
selKecamatan.addEventListener('change', function() {
    const kec = this.value;
    if (kec) {
        updateKelurahan(kec);
        boxKelurahan.classList.remove('hidden');
        boxJalan.classList.remove('hidden');
    } else {
        boxKelurahan.classList.add('hidden');
        boxJalan.classList.add('hidden');
        boxHasil.classList.add('hidden');
    }
    selKelurahan.value = '';
    hiddenAlamat.value = '';
    buildAlamat();
});

// Event: pilih kelurahan
selKelurahan.addEventListener('change', buildAlamat);

// Event: isi nama jalan
inputJalan.addEventListener('input', buildAlamat);

// Restore state jika ada old() value (validasi gagal)
const oldKec = "{{ old('kecamatan') }}";
const oldKel = "{{ old('kelurahan') }}";
if (oldKec) {
    updateKelurahan(oldKec, oldKel);
    buildAlamat();
}
</script>
{{-- ================================================================== --}}

@endsection
