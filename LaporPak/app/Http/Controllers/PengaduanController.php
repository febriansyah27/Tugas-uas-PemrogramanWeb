<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class PengaduanController extends Controller
{
    // Menampilkan halaman riwayat laporan warga
    public function index()
    {
        // Ambil HANYA pengaduan milik user yang login, urutkan dari terbaru
        $pengaduans = auth()->user()->pengaduans()->latest()->get();
        return view('warga.index', compact('pengaduans'));
    }

    // Menampilkan form buat laporan
    public function create()
    {
        return view('warga.create');
    }

    // Menyimpan data laporan ke database
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'alamat' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib gambar, max 2MB
        ]);

        // 2. Logic Upload Foto
        // Simpan foto ke storage/app/public/fotos, dapatkan path-nya
        $fotoPath = $request->file('foto')->store('fotos', 'public');

        // 3. Simpan data ke Database
        Pengaduan::create([
            'user_id' => auth()->id(), // Ambil ID user yang login
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'alamat' => $request->alamat,
            'foto' => $fotoPath, // Simpan path foto ke DB
            'status' => 'terkirim', // Default status
        ]);

        // 4. Redirect kembali ke riwayat dengan pesan sukses
        return redirect()->route('pengaduan.index')->with('success', 'Laporan berhasil dikirim!');
    }
}