# Daftar Pekerjaan API

Dokumen ini berisi daftar pekerjaan untuk implementasi API pada proyek REKAP DISPENDUK.

## Tujuan
- Menyediakan endpoint untuk input permohonan baru.
- Menyediakan endpoint untuk mengambil data rekap.
- Menjamin API aman dan valid.
- Memastikan API bisa digunakan di frontend atau sistem lain.

## 1. Desain API
- [x] Tentukan URL endpoint untuk permohonan baru (mis. `POST /api/permohonan`).
- [x] Tentukan URL endpoint untuk rekap permohonan (mis. `GET /api/rekap`).
- [x] Tentukan format request/response JSON.
- [x] Dokumentasikan parameter yang dibutuhkan (tanggal, jenis pelayanan, kecamatan, desa, status, dll.).

## 2. Endpoint CRUD Permohonan
- [x] Implementasi endpoint `POST /api/permohonan` untuk tambah permohonan.
- [x] Implementasi endpoint `GET /api/permohonan` untuk daftar semua permohonan.
- [x] Implementasi endpoint `GET /api/permohonan/{id}` untuk detail permohonan.
- [x] Implementasi endpoint `PUT/PATCH /api/permohonan/{id}` untuk update permohonan.
- [x] Implementasi endpoint `DELETE /api/permohonan/{id}` untuk hapus permohonan.

## 3. Endpoint Rekap dan Filter
- [x] Tambahkan endpoint `GET /api/rekap` untuk hasil rekapitulasi.
- [x] Implementasi endpoint `GET /api/rekap` untuk hasil rekapitulasi.
- [x] Tambahkan filter berdasarkan tanggal, bulan, tahun, jenis pelayanan, kecamatan, desa.
- [x] Tambahkan parameter untuk pagination jika data besar.
- [x] Pastikan rekap dapat ditampilkan secara ringkas dan berbentuk JSON.

## 4. Validasi dan Keamanan
- [x] Tambahkan validasi request pada setiap endpoint API.
- [x] Pastikan data input tidak mengandung nilai yang tidak valid.
- [x] Implementasi autentikasi untuk API jika diperlukan (mis. API token atau session auth).
- [x] Batasi akses hanya untuk user yang berwenang.

## 5. Testing
- [x] Buat test fitur API login dasar.
- [x] Buat test CRUD permohonan API.
- [x] Buat test untuk endpoint rekap.
- [x] Pastikan response JSON sesuai spesifikasi.
- [x] Pastikan validasi error dikembalikan dengan benar.

## 6. Endpoint Master Data
- [x] Endpoint `/api/master/kecamatan` untuk dropdown frontend.
- [x] Endpoint `/api/master/desa` untuk dropdown frontend.
- [x] Endpoint `/api/master/jenis-pelayanan` untuk dropdown frontend.

## 7. Integrasi Frontend
- [ ] Gunakan API `POST /api/permohonan` dari form input permohonan.
- [ ] Gunakan API `GET /api/rekap` untuk menampilkan rekap di halaman.
- [ ] Jika perlu, gunakan polling untuk memperbarui rekap secara berkala.
- [ ] Pastikan error ditangani di frontend dengan benar.

## Prioritas
1. API tambah permohonan dan rekap.
2. Validasi dan keamanan.
3. Filter dan pagination.
4. Pengujian API.
5. Integrasi dengan frontend.
