<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use App\Models\Pengaduan;
use Illuminate\Http\Request;

class TanggapanController extends Controller
{
    // =============================================
    // PETUGAS: Simpan tanggapan baru
    // =============================================
    public function store(Request $request)
    {
        $request->validate([
            'pengaduan_id'  => 'required|exists:pengaduans,id',
            'isi_tanggapan' => 'required|string|min:10',
        ], [
            'isi_tanggapan.required' => 'Isi tanggapan tidak boleh kosong.',
            'isi_tanggapan.min'      => 'Tanggapan minimal 10 karakter.',
        ]);

        // Simpan tanggapan
        Tanggapan::create([
            'pengaduan_id'  => $request->pengaduan_id,
            'user_id'       => auth()->id(),
            'isi_tanggapan' => $request->isi_tanggapan,
        ]);

        // Nilai Plus: Otomatis ubah status ke 'diproses' jika ini tanggapan pertama
        $pengaduan = Pengaduan::findOrFail($request->pengaduan_id);
        if ($pengaduan->status === 'terkirim') {
            $pengaduan->update(['status' => 'diproses']);
        }

        return redirect()->route('petugas.show', $request->pengaduan_id)
            ->with('success', 'Tanggapan berhasil dikirim.');
    }

    // =============================================
    // PETUGAS: Hapus tanggapan (opsional)
    // =============================================
    public function destroy($id)
    {
        $tanggapan = Tanggapan::findOrFail($id);
        $pengaduanId = $tanggapan->pengaduan_id;
        $tanggapan->delete();

        return redirect()->route('petugas.show', $pengaduanId)
            ->with('success', 'Tanggapan berhasil dihapus.');
    }
}
