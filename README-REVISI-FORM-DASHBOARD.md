# SIPPER V2 — Revisi Form & Dashboard Sesuai Kebutuhan Rekap

Patch ini menyesuaikan modul Pendataan Permohonan dan Dashboard dengan kebutuhan rekap yang diberikan.

## Form tidak lagi meminta
- NIK
- Nomor permohonan (dibuat otomatis oleh sistem)
- Nomor KIA
- field tambahan lain yang tidak diperlukan

## Form KK
- Nama
- Desa/Kelurahan
- Kecamatan
- Jenis KK: KK Baru / Perubahan KK / Pecah KK
- Keterangan / siapa pemohonnya
- Tanggal

## Form AKTA
- Jenis Akta:
  - Akta Kelahiran Umum
  - Akta Kelahiran Terlambat
  - Akta Petikan Kedua
  - Akta Kematian
  - Pembatalan Akta
  - Pengesahan Anak
  - Akta Perkawinan
  - Akta Perceraian
  - Akta Perubahan Nama
  - Akta Pengangkatan Anak
- Nama
- Desa/Kelurahan
- Kecamatan
- No. Kendali
- Tanggal

## Form KIA
- Nama
- Desa/Kelurahan
- Kecamatan
- Tanggal

## Form KTP
- Jenis KTP:
  - Hilang
  - Rusak
  - Perubahan Elemen
  - PRR / Pemula
- Nama
- Desa/Kelurahan
- Kecamatan
- Keterangan
- Tanggal

## Form Surat Pindah
- Nama
- Desa/Kelurahan
- Kecamatan
- Keterangan / siapa pemohonnya
- Tanggal

## Form Perekaman
- Nama
- Desa/Kelurahan
- Kecamatan
- Keterangan (pemula)
- Tanggal

## Dashboard
Dashboard sekarang menampilkan:
1. Total seluruh permohonan.
2. Total setiap kategori utama.
3. Laporan keseluruhan per jenis pelayanan.
4. Rekap jumlah permohonan per bulan.

## File yang diganti
- app/Http/Controllers/PermohonanController.php
- app/Models/Permohonan.php
- app/Http/Controllers/DashboardController.php
- resources/views/permohonan/form.blade.php
- resources/views/dashboard/index.blade.php

## Penerapan
Backup project dahulu, lalu replace file sesuai path.

Jalankan:
php artisan optimize:clear

Tidak perlu migrate:fresh.
Tidak perlu menghapus database.
Seeder pelayanan Tahap 2B tetap digunakan.
