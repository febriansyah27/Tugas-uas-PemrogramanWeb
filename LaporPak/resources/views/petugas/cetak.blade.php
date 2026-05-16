<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan #{{ $pengaduan->id }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; padding: 30px; }
        .header { text-align: center; border-bottom: 3px solid #1d4ed8; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; font-weight: bold; color: #1d4ed8; }
        .header p { color: #555; font-size: 12px; margin-top: 4px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 999px; font-size: 11px; font-weight: bold; }
        .badge-terkirim { background:#dbeafe; color:#1e40af; }
        .badge-diproses  { background:#fef9c3; color:#854d0e; }
        .badge-selesai   { background:#dcfce7; color:#166534; }
        .badge-ditolak   { background:#fee2e2; color:#991b1b; }
        .section { margin-bottom: 18px; }
        .section h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #888; margin-bottom: 6px; }
        .section p { color: #222; line-height: 1.6; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
        .box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
        .tanggapan { border: 1px solid #bfdbfe; background: #eff6ff; border-radius: 8px; padding: 12px; margin-bottom: 10px; }
        .tanggapan .meta { font-size: 11px; color: #555; margin-bottom: 6px; }
        img { max-width: 250px; border-radius: 8px; border: 1px solid #ddd; margin-top: 6px; }
        .footer { margin-top: 30px; border-top: 1px solid #ddd; padding-top: 12px; text-align: center; font-size: 11px; color: #888; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>

    <div class="header">
        <h1>LaporPak</h1>
        <p>Sistem Pengaduan Warga — Kota Palu, Sulawesi Tengah</p>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:18px;">
        <div>
            <h2 style="font-size:16px; font-weight:bold;">{{ $pengaduan->judul }}</h2>
            <p style="color:#555; font-size:12px; margin-top:4px;">Laporan #{{ $pengaduan->id }}</p>
        </div>
        <span class="badge badge-{{ $pengaduan->status }}">{{ strtoupper($pengaduan->status) }}</span>
    </div>

    <div class="grid">
        <div class="box">
            <div class="section">
                <h3>Pelapor</h3>
                <p><strong>{{ $pengaduan->user->name }}</strong></p>
                <p style="color:#555;">{{ $pengaduan->user->email }}</p>
            </div>
        </div>
        <div class="box">
            <div class="section">
                <h3>Tanggal Lapor</h3>
                <p>{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Lokasi</h3>
        <p>{{ $pengaduan->alamat }}</p>
    </div>

    <div class="section">
        <h3>Isi Laporan</h3>
        <p>{{ $pengaduan->isi_laporan }}</p>
    </div>

    @if($pengaduan->foto)
    <div class="section">
        <h3>Foto Bukti</h3>
        <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto bukti">
    </div>
    @endif

    @if($pengaduan->tanggapans->count() > 0)
    <div class="section">
        <h3>Tanggapan Petugas ({{ $pengaduan->tanggapans->count() }})</h3>
        @foreach($pengaduan->tanggapans as $t)
        <div class="tanggapan">
            <p class="meta">{{ $t->user->name }} — {{ $t->created_at->format('d M Y, H:i') }} WIB</p>
            <p>{{ $t->isi_tanggapan }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <div class="footer">
        Dicetak pada {{ now()->format('d F Y, H:i') }} WIB &nbsp;|&nbsp; LaporPak — Kota Palu
    </div>

    <div class="no-print" style="text-align:center; margin-top:20px;">
        <button onclick="window.print()"
            style="background:#1d4ed8; color:white; border:none; padding:10px 24px; border-radius:8px; font-size:13px; cursor:pointer; font-weight:bold;">
            🖨️ Cetak / Simpan PDF
        </button>
        <button onclick="window.close()"
            style="background:#f1f5f9; color:#333; border:1px solid #ddd; padding:10px 24px; border-radius:8px; font-size:13px; cursor:pointer; margin-left:8px;">
            ✕ Tutup
        </button>
    </div>

</body>
</html>
