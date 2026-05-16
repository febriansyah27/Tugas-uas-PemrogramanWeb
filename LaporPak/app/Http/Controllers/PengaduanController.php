<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    // WARGA: Riwayat laporan sendiri
    public function index()
    {
        $pengaduans = auth()->user()->pengaduans()
            ->withCount('tanggapans')
            ->latest()
            ->paginate(10);
        return view('warga.index', compact('pengaduans'));
    }

    // WARGA: Form buat laporan
    public function create()
    {
        return view('warga.create');
    }

    // WARGA: Simpan laporan
    public function store(Request $request)
    {
        $request->validate([
            'judul'       => 'required|string|max:255',
            'isi_laporan' => 'required|string',
            'kecamatan'   => 'required|string',
            'kelurahan'   => 'required|string',
            'nama_jalan'  => 'nullable|string|max:255',
            'alamat'      => 'required|string|max:500',
            'foto'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'judul.required'       => 'Judul laporan wajib diisi.',
            'isi_laporan.required' => 'Isi laporan wajib diisi.',
            'kecamatan.required'   => 'Kecamatan wajib dipilih.',
            'kelurahan.required'   => 'Kelurahan wajib dipilih.',
            'alamat.required'      => 'Lokasi lengkap wajib diisi.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.max'             => 'Ukuran foto maksimal 2MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('fotos', 'public');
        }

        Pengaduan::create([
            'user_id'     => auth()->id(),
            'judul'       => $request->judul,
            'isi_laporan' => $request->isi_laporan,
            'alamat'      => $request->alamat,
            'foto'        => $fotoPath,
            'status'      => 'terkirim',
        ]);

        return redirect()->route('warga.index')
            ->with('success', 'Laporan berhasil dikirim! Kami akan segera menindaklanjutinya.');
    }

    // WARGA: Detail laporan + tanggapan
    public function showWarga($id)
    {
        $pengaduan = Pengaduan::with(['tanggapans.user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('warga.show', compact('pengaduan'));
    }

    // WARGA: Cetak bukti laporan
    public function cetakWarga($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapans.user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
        return view('warga.cetak', compact('pengaduan'));
    }

    // PETUGAS: Semua pengaduan + filter + search + pagination
    public function indexPetugas(Request $request)
    {
        $query = Pengaduan::with('user')->latest();

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$cari%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kecamatan')) {
            $query->where('alamat', 'like', "%{$request->kecamatan}%");
        }

        $pengaduans = $query->paginate(10)->withQueryString();
        return view('petugas.index', compact('pengaduans'));
    }

    // PETUGAS: Detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapans.user'])->findOrFail($id);
        return view('petugas.show', compact('pengaduan'));
    }

    // PETUGAS: Update status
    public function update(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:terkirim,diproses,selesai,ditolak']);
        Pengaduan::findOrFail($id)->update(['status' => $request->status]);
        return redirect()->route('petugas.show', $id)
            ->with('success', 'Status berhasil diperbarui.');
    }

    // PETUGAS: Hapus pengaduan
    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        if ($pengaduan->foto) {
            \Storage::disk('public')->delete($pengaduan->foto);
        }
        $pengaduan->delete();
        return redirect()->route('petugas.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }

    // PETUGAS: Cetak laporan
    public function cetak($id)
    {
        $pengaduan = Pengaduan::with(['user', 'tanggapans.user'])->findOrFail($id);
        return view('petugas.cetak', compact('pengaduan'));
    }

    // PETUGAS: Export CSV
    public function export(Request $request)
    {
        $query = Pengaduan::with('user')->latest();

        if ($request->filled('status'))    $query->where('status', $request->status);
        if ($request->filled('kecamatan')) $query->where('alamat', 'like', "%{$request->kecamatan}%");
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function($q) use ($cari) {
                $q->where('judul', 'like', "%$cari%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$cari%"));
            });
        }

        $pengaduans = $query->get();
        $filename   = 'laporan-laporpak-' . now()->format('Ymd-His') . '.csv';
        $headers    = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename=$filename"];

        $callback = function() use ($pengaduans) {
            $file = fopen('php://output', 'w');
            // BOM agar Excel bisa baca UTF-8
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, ['No','Judul','Pelapor','Email','Alamat','Status','Tanggal','Jml Tanggapan']);
            foreach ($pengaduans as $i => $p) {
                fputcsv($file, [
                    $i + 1,
                    $p->judul,
                    $p->user->name,
                    $p->user->email,
                    $p->alamat,
                    $p->status,
                    $p->created_at->format('d/m/Y H:i'),
                    $p->tanggapans()->count(),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
