# Daftar Pekerjaan Proyek SIPPER

Dokumen ini berisi daftar pekerjaan yang perlu diselesaikan untuk pengembangan sistem SIPPER, dipisahkan antara pengerjaan backend dan frontend. Setiap item dilengkapi checklist progres.

## Status Umum Proyek
- [x] Dokumen perencanaan sistem dibuat
- [x] Struktur project Laravel dasar tersedia
- [x] Model utama dibuat
- [x] Migrasi database dibuat
- [x] Seeder awal dibuat
- [x] Autentikasi dan role user selesai
- [x] CRUD utama selesai
- [x] UI halaman admin/petugas selesai
- [x] Laporan dan rekapitulasi selesai
- [x] Pengujian dan validasi selesai

---

## Backend

### 1. Setup dan Fondasi
- [x] Membuat struktur project Laravel
- [x] Menyiapkan konfigurasi dasar aplikasi
- [x] Menyiapkan file routing awal
- [x] Menyiapkan environment dan konfigurasi database lengkap

### 2. Database dan Model
- [x] Membuat model User
- [x] Membuat model Kecamatan
- [x] Membuat model Desa
- [x] Membuat model JenisPelayanan
- [x] Membuat model Permohonan
- [x] Membuat migrasi untuk tabel utama
- [x] Membuat seeder admin dan jenis pelayanan
- [x] Menyesuaikan relasi antar model secara lengkap
- [x] Menambahkan validasi dan rule data pada model/migration

### 3. Autentikasi dan Akses User
- [x] Membuat login admin/petugas
- [x] Membuat logout
- [x] Membuat middleware admin dan petugas
- [x] Mengatur hak akses tiap menu
- [x] Membuat fitur ganti password
- [x] Membuat profil user

### 4. Modul Master Data
- [x] CRUD kecamatan
- [x] CRUD desa/kelurahan
- [x] CRUD jenis pelayanan
- [x] CRUD user/petugas

### 5. Modul Permohonan
- [x] Form input permohonan
- [x] Simpan data permohonan ke database
- [x] Edit data permohonan
- [x] Hapus data permohonan
- [x] Detail permohonan
- [x] Validasi input data

### 6. Pencarian, Filter, dan Rekapitulasi
- [x] Fitur pencarian data permohonan
- [x] Fitur filter berdasarkan tanggal, bulan, tahun, jenis pelayanan, kecamatan, desa
- [x] Fitur rekapitulasi harian/bulanan/tahunan
- [x] Fitur export laporan PDF/Excel

### 7. Pengujian dan Optimasi
- [x] Menulis test fitur utama
- [x] Menguji alur login dan CRUD
- [x] Menguji export laporan
- [x] Memperbaiki bug dan optimasi performa

---

## Frontend

### 1. Layout dan Template Dasar
- [x] Membuat layout utama aplikasi
- [x] Membuat sidebar/navigation untuk admin
- [x] Membuat sidebar/navigation untuk petugas
- [x] Membuat header, footer, dan area konten

### 2. Halaman Autentikasi
- [x] Halaman login
- [x] Halaman profil pengguna
- [x] Halaman ganti password
- [x] Halaman logout

### 3. Dashboard
- [x] Dashboard admin
- [x] Menampilkan statistik jumlah permohonan
- [ ] Menampilkan grafik permohonan per bulan

### 4. Halaman Master Data
- [x] Halaman daftar kecamatan
- [x] Form tambah/edit kecamatan
- [x] Halaman daftar desa/kelurahan
- [x] Form tambah/edit desa/kelurahan
- [x] Halaman daftar jenis pelayanan
- [x] Form tambah/edit jenis pelayanan
- [x] Halaman daftar user/petugas
- [x] Form tambah/edit user/petugas

### 5. Halaman Permohonan
- [x] Halaman daftar permohonan
- [x] Form tambah permohonan
- [x] Form edit permohonan
- [x] Halaman detail permohonan
- [x] Tombol hapus dengan konfirmasi

### 6. Pencarian, Filter, dan Laporan
- [x] Tampilan pencarian data
- [x] Tampilan filter data
- [x] Tampilan rekapitulasi
- [x] Tampilan laporan harian/bulanan/tahunan
- [x] Tombol export PDF/Excel

### 7. UI/UX dan Responsif
- [ ] Tampilan mobile friendly
- [ ] Konsistensi desain antar halaman
- [x] Validasi feedback form user
- [ ] Penyesuaian warna dan tema aplikasi

---

## Prioritas Pengerjaan
1. Backend: autentikasi, middleware, CRUD master data, CRUD permohonan (selesai)
2. Frontend: layout utama, login, dashboard, daftar permohonan (selesai)
3. Backend dan frontend: pencarian, filter, rekapitulasi, laporan (selesai)
4. Pengujian dan perbaikan bug (selesai)
5. Penyempurnaan UI/UX dan responsivitas lanjutan
