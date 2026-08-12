# Sistem Informasi Pendataan dan Rekapitulasi Permohonan Pelayanan Dokumen Kependudukan (SIPPER)

## Deskripsi Sistem
SIPPER (Sistem Informasi Pendataan dan Rekapitulasi Permohonan Pelayanan Dokumen Kependudukan) merupakan sistem informasi berbasis web yang digunakan untuk membantu proses pendataan dan rekapitulasi permohonan pelayanan dokumen kependudukan pada Dinas Kependudukan dan Pencatatan Sipil Kabupaten Magetan. Sistem ini dirancang untuk memudahkan petugas dalam melakukan pencatatan data permohonan, pencarian data, penyaringan data, rekapitulasi berdasarkan periode maupun wilayah, serta penyusunan laporan secara otomatis. Dengan adanya SIPPER, proses administrasi yang sebelumnya dilakukan secara manual menjadi lebih efektif, efisien, dan terstruktur.

## Spesifikasi Perangkat Lunak
* **Sistem Operasi**: Windows 10 / Windows 11
* **Bahasa Pemrograman**: PHP 8.2+
* **Framework**: Laravel 12
* **Database**: MySQL (Laragon)
* **Dependency Manager**: Composer
* **Code Editor**: Visual Studio Code
* **Version Control**: Git & GitHub

## Aktor Sistem
1. **Admin**
   * **Fitur**: Login, Dashboard, Kelola Data Kecamatan, Kelola Data Desa/Kelurahan, Kelola Data Petugas, Pendataan Permohonan, Pencarian Data, Filter Data, Rekapitulasi Permohonan, Cetak Laporan, Profil, Ganti Password, Logout
2. **Petugas**
   * **Fitur**: Login, Dashboard, Pendataan Permohonan, Edit Data Permohonan, Hapus Data Permohonan, Pencarian Data, Filter Data, Rekapitulasi Permohonan, Cetak Laporan, Profil, Ganti Password, Logout

## Dashboard Sistem
### Dashboard Admin
* Total Permohonan
* Total Permohonan Kartu Keluarga (KK)
* Total Permohonan Akta Pencatatan Sipil
* Total Permohonan KTP Elektronik
* Total Permohonan Kartu Identitas Anak (KIA)
* Total Permohonan Surat Pindah
* Total Permohonan Perekaman KTP-el
* Grafik Permohonan per Bulan

### Dashboard Petugas
* Total Permohonan Hari Ini
* Total Permohonan Bulan Ini
* Total Permohonan Berdasarkan Jenis Pelayanan
* Grafik Permohonan Bulanan
* Daftar Permohonan Terbaru

## Jenis Pelayanan
1. **Kartu Keluarga (KK)**
   * KK Baru
   * Perubahan KK
   * Pecah KK
2. **Akta Pencatatan Sipil**
   * Akta Kelahiran Anak
   * Akta Kelahiran Terlambat
   * Akta Petikan Kedua
   * Akta Kematian
   * Pembatalan Akta Perkawinan
   * Akta Perceraian
   * Akta Perubahan Nama
   * Akta Pengangkatan Anak
   * Pengesahan Anak
3. **KTP Elektronik**
   * Hilang
   * Rusak
   * Perubahan Elemen
   * PRR (Print Ready Record)
4. **Kartu Identitas Anak (KIA)**
5. **Surat Pindah**
6. **Perekaman KTP Elektronik**

## Alur Sistem
`Login` ➔ `Dashboard` ➔ `Input Data Permohonan` ➔ `Pilih Jenis Pelayanan` ➔ `Input Data Pemohon` ➔ `Simpan Data` ➔ `Data Tersimpan pada Database` ➔ `Pencarian dan Filter Data` ➔ `Rekapitulasi Permohonan` ➔ `Cetak Laporan (PDF / Excel)`

## Kebutuhan Fungsional Sistem
1. **Modul Autentikasi**: Login, Logout, Ganti Password
2. **Modul Dashboard**: Menampilkan statistik permohonan, grafik jumlah permohonan per bulan, jumlah permohonan berdasarkan jenis pelayanan.
3. **Modul Manajemen Data Master**:
   * **Kecamatan**: Tambah, Edit, Hapus
   * **Desa/Kelurahan**: Tambah, Edit, Hapus
4. **Modul Pendataan Permohonan**: Tambah, Edit, Hapus, Melihat Detail Permohonan. (Jenis pelayanan didukung: KK, Akta Pencatatan Sipil, KTP Elektronik, KIA, Surat Pindah, Perekaman KTP Elektronik)
5. **Modul Pencarian Data**: Berdasarkan Nama Pemohon, Nomor Permohonan, Jenis Pelayanan, Kecamatan, Desa/Kelurahan.
6. **Modul Filter Data**: Berdasarkan Tanggal, Bulan, Tahun, Jenis Pelayanan, Kecamatan, Desa/Kelurahan.
7. **Modul Rekapitulasi**: Berdasarkan Jenis Pelayanan, Kecamatan, Desa/Kelurahan, Periode (Bulanan, Tahunan).
8. **Modul Laporan**: Cetak Laporan Harian, Bulanan, Tahunan. (Format: PDF, Excel)
9. **Modul Manajemen User**: Tambah Akun Petugas, Edit Akun Petugas, Hapus Akun Petugas, Reset Password.
10. **Modul Profil**: Edit Profil, Ganti Password.

## Hak Akses Sistem
| Menu | Admin | Petugas |
|---|---|---|
| Login | ✓ | ✓ |
| Dashboard | ✓ | ✓ |
| Kelola User | ✓ | ✗ |
| Kelola Kecamatan | ✓ | ✗ |
| Kelola Desa/Kelurahan | ✓ | ✗ |
| Pendataan Permohonan | ✓ | ✓ |
| Edit Data Permohonan | ✓ | ✓ |
| Hapus Data Permohonan | ✓ | ✓ |
| Pencarian Data | ✓ | ✓ |
| Filter Data | ✓ | ✓ |
| Rekapitulasi | ✓ | ✓ |
| Cetak Laporan | ✓ | ✓ |
| Profil | ✓ | ✓ |
| Ganti Password | ✓ | ✓ |
| Logout | ✓ | ✓ |

## Struktur Proyek Laravel 12
```text
sipper/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Kecamatan.php
│   │   ├── Desa.php
│   │   ├── Permohonan.php
│   │   ├── JenisPelayanan.php
│   │   └── Rekapitulasi.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   └── LogoutController.php
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── KecamatanController.php
│   │   │   │   ├── DesaController.php
│   │   │   │   ├── PermohonanController.php
│   │   │   │   ├── RekapitulasiController.php
│   │   │   │   ├── LaporanController.php
│   │   │   │   ├── ProfilController.php
│   │   │   │   └── PasswordController.php
│   │   │   └── Petugas/
│   │   │       ├── DashboardController.php
│   │   │       ├── PermohonanController.php
│   │   │       ├── RekapitulasiController.php
│   │   │       ├── LaporanController.php
│   │   │       ├── ProfilController.php
│   │   │       └── PasswordController.php
│   ├── Middleware/
│   │   ├── AdminMiddleware.php
│   │   └── PetugasMiddleware.php
│   └── Services/
│       ├── RekapitulasiService.php
│       └── LaporanService.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   ├── js/
│   └── images/
├── routes/
│   ├── web.php
│   ├── auth.php
│   ├── admin.php
│   └── petugas.php
├── storage/
└── public/
```

