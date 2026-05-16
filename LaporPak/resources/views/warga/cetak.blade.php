<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Laporan #{{ $pengaduan->id }} - LaporPak</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 13px; color: #111; padding: 30px; }
        .header { text-align: center; border-bottom: 3px solid #1d4ed8; padding-bottom: 16px; margin-bottom: 20px; }
        .header h1 { font-size: 22px; color: #1d4ed8; font-weight: bold; }
        .header p  { font-size: 12px; color: #555; margin-top: 4px; }
        .badge { display: inline-block; padding: 3px 12px; border-radius: 20px; font-size: 11px; font-weight: bold; }
        .badge-terkirim { background: #dbeafe; color: #1d40af; }
        .badge-diproses { background: #fef9c3; color: #854d0e; }
        .badge-selesai  { background: #dcfce7; color: #166534; }
        .badge-ditolak  { background: #fee2e2; color: #991b1b; }
        table.info { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.info td { padding: 7px 10px; border: 1px solid #e5e7eb; vertical-align: top; }
        table.info td:first-child { background: #f9fafb; font-weight: bold; width: 160px; color: #374151; }
        .section-title { font-size: 12px; font-weight: bold; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin: 20px 0 8px; }
        .isi-laporan { border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; background: #f9fafb; line-height: 1.6; }
        .tanggapan-box { border: 1px solid #bfdbfe; background: #eff6ff; border-radius: 6px; padding: 12px; margin-bottom: 10px; }
        .tanggapan-box .meta { font-size: 11px; color: #3b82f6; font-weight: bold; margin-bottom: 5px; }
        .footer { margin-top: 40px; border-top: 1px solid #e5e7eb; padding-top: 16px; display: flex; justify-content: space-between; font-size: 11px; color: #9ca3af; }
        .ttd { text-align: center; margin-top: 50px; }
        .ttd p { font-size: 12px; }
        .ttd .nama { margin-top: 60px; font-weight: bold; border-top: 1px solid #111; display: inline-block; padding-top: 4px; min-width: 160px; }
        img.foto { max-width: 280px; border: 1px solid #e5e7eb; border-radius: 6px; margin-top: 8px; }
        @media print {
            body { padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>🏛️ LaporPak</h1>
        <p>Sistem Pengaduan Warga — Kota Palu, Sulawesi Tengah</p>
        <p style="margin-top:6px; font-size:11px; color:#9ca3af;">Dicetak pada: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="section-title">Informasi Laporan</div>
    <table class="info">
        <tr>
            <td>Nomor Laporan</td>
            <td><strong>#{{ str_pad($pengaduan->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
        </tr>
        <tr>
            <td>Judul</td>
            <td>{{ $pengaduan->judul }}</td>
        </tr>
        <tr>
            <td>Pelapor</td>
            <td>{{ $pengaduan->user->name }} ({{ $pengaduan->user->email }})</td>
        </tr>
        <tr>
            <td>Lokasi</td>
            <td>{{ $pengaduan->alamat }}</td>
        </tr>
        <tr>
            <td>Tanggal Lapor</td>
            <td>{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <span class="badge badge-{{ $pengaduan->status }}">
                    {{ strtoupper($pengaduan->status) }}
                </span>
            </td>
        </tr>
    </table>

    <div class="section-title">Isi Laporan</div>
    <div class="isi-laporan">{{ $pengaduan->isi_laporan }}</div>

    @if($pengaduan->foto)
    <div class="section-title">Foto Bukti</div>
    <img src="{{ asset('storage/' . $pengaduan->foto) }}" class="foto" alt="Foto laporan">
    @endif

    <div class="section-title">Tanggapan Petugas ({{ $pengaduan->tanggapans->count() }} tanggapan)</div>
    @if($pengaduan->tanggapans->isEmpty())
        <p style="color:#9ca3af; font-style:italic;">Belum ada tanggapan dari petugas.</p>
    @else
        @foreach($pengaduan->tanggapans as $t)
        <div class="tanggapan-box">
            <div class="meta">{{ $t->user->name }} (Petugas) — {{ $t->created_at->format('d M Y, H:i') }} WIB</div>
            <p>{{ $t->isi_tanggapan }}</p>
        </div>
        @endforeach
    @endif

    {{-- Tanda Tangan --}}
    <div style="display:flex; justify-content:space-between; margin-top:50px;">
        <div class="ttd">
            <p>Pelapor</p>
            <p class="nama">{{ $pengaduan->user->name }}</p>
        </div>
        <div class="ttd">
            <p>Petugas LaporPak</p>
            <p class="nama">( __________________ )</p>
        </div>
    </div>

    <div class="footer">
        <span>LaporPak — Kota Palu</span>
        <span>Dokumen ini dicetak secara digital dari sistem LaporPak</span>
        <span>Hal. 1/1</span>
    </div>

    {{-- Auto print --}}
    <script>window.onload = function() { window.print(); }</script>

</body>
</html>
