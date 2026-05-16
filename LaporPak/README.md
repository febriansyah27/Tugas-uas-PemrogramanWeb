# 🏛️ LaporPak — Sistem Pengaduan Warga Digital

Aplikasi web berbasis Laravel untuk menerima, mengelola, dan menindaklanjuti pengaduan masyarakat secara digital.

---

## 👥 Pembagian Tugas Tim

| Orang | Peran | File Utama |
|-------|-------|------------|
| Orang 1 | Backend Lead | migrations/, models/, Kernel.php |
| Orang 2 | Feature Warga | warga/create.blade.php, warga/index.blade.php, PengaduanController@store |
| Orang 3 | Feature Petugas | petugas/index.blade.php, PengaduanController@indexPetugas, @update |
| Orang 4 | Feature Tanggapan | petugas/show.blade.php, TanggapanController |
| Orang 5 | Frontend & Middleware | IsPetugas.php, layouts/app.blade.php, status-badge component |

---

## 🚀 Cara Setup Project

### 1. Clone & Install Dependencies
```bash
git clone <repo-url> LaporPak
cd LaporPak
composer install
npm install && npm run build
```

### 2. Konfigurasi Environment
```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env` sesuai database lokal:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=LaporPak
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Setup Database
```bash
# Buat database 'LaporPak' di MySQL terlebih dahulu, lalu:
php artisan migrate
php artisan db:seed
```

Setelah seeder berjalan, akun tersedia:
- **Petugas:** `petugas@LaporPak.id` / `password`
- **Warga:** `warga@LaporPak.id` / `password`

### 4. Setup Storage untuk Upload Foto
```bash
php artisan storage:link
```

### 5. Jalankan Server
```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## 📁 Struktur File Penting

```
LaporPak/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── PengaduanController.php   ← Logic warga + petugas
│   │   │   └── TanggapanController.php   ← Logic tanggapan
│   │   ├── Middleware/
│   │   │   └── IsPetugas.php             ← Middleware role check
│   │   └── Kernel.php                    ← Registrasi middleware
│   └── Models/
│       ├── User.php                      ← Model user + relasi
│       ├── Pengaduan.php                 ← Model pengaduan
│       └── Tanggapan.php                 ← Model tanggapan
│
├── database/
│   ├── migrations/
│   │   ├── ..._create_users_table.php
│   │   ├── ..._create_pengaduans_table.php
│   │   └── ..._create_tanggapans_table.php
│   └── seeders/
│       └── DatabaseSeeder.php            ← Data akun awal
│
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php                 ← Layout utama + navigasi
│   ├── components/
│   │   └── status-badge.blade.php        ← Badge warna status
│   ├── warga/
│   │   ├── create.blade.php              ← Form buat laporan
│   │   └── index.blade.php               ← Riwayat laporan warga
│   └── petugas/
│       ├── index.blade.php               ← Daftar semua pengaduan
│       └── show.blade.php                ← Detail + form tanggapan
│
└── routes/
    └── web.php                           ← Semua routing aplikasi
```

---

## 🎯 Fitur Aplikasi

### Warga (role: warga)
- ✅ Registrasi & login
- ✅ Buat laporan pengaduan (dengan upload foto)
- ✅ Lihat riwayat laporan sendiri + status terkini
- ✅ Lihat tanggapan dari petugas

### Petugas (role: petugas)
- ✅ Login khusus petugas
- ✅ Melihat SELURUH pengaduan warga
- ✅ Update status pengaduan (Terkirim → Diproses → Selesai / Ditolak)
- ✅ Memberikan tanggapan/balasan pada pengaduan
- ✅ Hapus pengaduan atau tanggapan
- ✅ Status otomatis berubah ke "Diproses" saat tanggapan pertama dikirim

### Keamanan
- ✅ Middleware `is_petugas`: warga tidak bisa akses halaman petugas
- ✅ Warga hanya bisa lihat laporan milik sendiri
- ✅ CSRF protection pada semua form

---

## 🎨 Badge Status

| Status | Warna | Keterangan |
|--------|-------|------------|
| `terkirim` | 🔵 Biru | Laporan baru masuk |
| `diproses` | 🟡 Kuning | Sedang ditangani |
| `selesai` | 🟢 Hijau | Selesai ditindaklanjuti |
| `ditolak` | 🔴 Merah | Laporan ditolak |

---

## 🌐 Deployment

### GitHub
```bash
git init
git add .
git commit -m "feat: initial LaporPak project"
git remote add origin <github-url>
git push -u origin main
```

### Hosting (Railway / Render)
1. Connect repo GitHub ke platform hosting
2. Set environment variables (`.env`)
3. Set `APP_URL` ke domain hosting
4. Jalankan `php artisan migrate --seed` di console hosting
5. Jalankan `php artisan storage:link`

---

## 🛠️ Tech Stack

- **Framework:** Laravel 10+
- **Auth:** Laravel Breeze
- **Database:** MySQL
- **Styling:** Tailwind CSS (CDN)
- **File Upload:** Laravel Storage (local disk)
