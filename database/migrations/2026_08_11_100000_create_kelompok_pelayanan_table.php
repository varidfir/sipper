<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_pelayanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 30)->unique();
            $table->string('nama', 100)->unique();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        $now = now();

        DB::table('kelompok_pelayanan')->insert([
            ['kode' => 'KK', 'nama' => 'Kartu Keluarga (KK)', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'AKTA', 'nama' => 'Akta Pencatatan Sipil', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'KTP', 'nama' => 'KTP Elektronik', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'KIA', 'nama' => 'Kartu Identitas Anak (KIA)', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'SURAT_PINDAH', 'nama' => 'Surat Pindah', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
            ['kode' => 'PEREKAMAN', 'nama' => 'Perekaman KTP Elektronik', 'status' => true, 'created_at' => $now, 'updated_at' => $now],
        ]);

        Schema::table('jenis_pelayanan', function (Blueprint $table) {
            $table->foreignId('kelompok_pelayanan_id')
                ->nullable()
                ->after('id')
                ->constrained('kelompok_pelayanan')
                ->nullOnDelete();

            $table->string('kode', 50)->nullable()->after('nama_pelayanan');
            $table->boolean('status')->default(true)->after('kode');
        });

        $groups = DB::table('kelompok_pelayanan')->pluck('id', 'kode');

        DB::table('jenis_pelayanan')->update([
            'kelompok_pelayanan_id' => $groups['KK'],
        ]);

        DB::table('jenis_pelayanan')
            ->where('kategori', 'Akta Pencatatan Sipil')
            ->update(['kelompok_pelayanan_id' => $groups['AKTA']]);

        DB::table('jenis_pelayanan')
            ->where('kategori', 'KTP Elektronik')
            ->update(['kelompok_pelayanan_id' => $groups['KTP']]);

        DB::table('jenis_pelayanan')
            ->where('kategori', 'Kartu Identitas Anak (KIA)')
            ->update(['kelompok_pelayanan_id' => $groups['KIA']]);

        DB::table('jenis_pelayanan')
            ->where('kategori', 'Surat Pindah')
            ->update(['kelompok_pelayanan_id' => $groups['SURAT_PINDAH']]);

        DB::table('jenis_pelayanan')
            ->where('kategori', 'Perekaman KTP Elektronik')
            ->update(['kelompok_pelayanan_id' => $groups['PEREKAMAN']]);

        $codes = [
            'KK Baru' => 'KK_BARU',
            'Perubahan KK' => 'KK_PERUBAHAN',
            'Pecah KK' => 'KK_PECAH',
            'Akta Kelahiran Anak' => 'AKTA_KELAHIRAN_UMUM',
            'Akta Kelahiran Terlambat' => 'AKTA_KELAHIRAN_TERLAMBAT',
            'Akta Petikan Kedua' => 'AKTA_PETIKAN_KEDUA',
            'Akta Kematian' => 'AKTA_KEMATIAN',
            'Pembatalan Akta Perkawinan' => 'AKTA_PEMBATALAN',
            'Akta Perceraian' => 'AKTA_PERCERAIAN',
            'Akta Perubahan Nama' => 'AKTA_PERUBAHAN_NAMA',
            'Akta Pengangkatan Anak' => 'AKTA_PENGANGKATAN_ANAK',
            'Pengesahan Anak' => 'AKTA_PENGESAHAN_ANAK',
            'Hilang' => 'KTP_HILANG',
            'Rusak' => 'KTP_RUSAK',
            'Perubahan Elemen' => 'KTP_ELEMEN',
            'PRR (Print Ready Record)' => 'KTP_PRR',
            'Pembuatan KIA' => 'KIA',
            'Pindah Keluar' => 'SURAT_PINDAH',
            'Pindah Datang' => 'SURAT_PINDAH',
            'Perekaman Baru' => 'PEREKAMAN',
        ];

        foreach ($codes as $name => $code) {
            DB::table('jenis_pelayanan')
                ->where('nama_pelayanan', $name)
                ->update(['kode' => $code]);
        }

        // Normalisasi istilah agar sesuai rancangan SIPPER.
        DB::table('jenis_pelayanan')
            ->where('nama_pelayanan', 'Akta Kelahiran Anak')
            ->update(['nama_pelayanan' => 'Akta Kelahiran Umum']);

        DB::table('jenis_pelayanan')
            ->where('nama_pelayanan', 'Pembuatan KIA')
            ->update(['nama_pelayanan' => 'KIA']);

        DB::table('jenis_pelayanan')
            ->where('nama_pelayanan', 'Perekaman Baru')
            ->update(['nama_pelayanan' => 'Perekaman KTP-el']);

        // "Surat Pindah" menjadi satu jenis utama. Data lama tetap dipertahankan,
        // tetapi Pindah Datang dinonaktifkan agar tidak muncul pada form baru.
        DB::table('jenis_pelayanan')
            ->where('nama_pelayanan', 'Pindah Keluar')
            ->update([
                'nama_pelayanan' => 'Surat Pindah',
                'kode' => 'SURAT_PINDAH',
                'status' => true,
            ]);

        DB::table('jenis_pelayanan')
            ->where('nama_pelayanan', 'Pindah Datang')
            ->update([
                'status' => false,
                'kode' => 'LEGACY_PINDAH_DATANG',
            ]);

        // Pastikan semua baris lama memiliki kelompok.
        DB::table('jenis_pelayanan')
            ->whereNull('kelompok_pelayanan_id')
            ->update(['status' => false]);

        // Kode harus unik pada data aktif. Duplikasi legacy tidak dihapus agar
        // foreign key permohonan lama tetap aman.
    }

    public function down(): void
    {
        Schema::table('jenis_pelayanan', function (Blueprint $table) {
            $table->dropForeign(['kelompok_pelayanan_id']);
            $table->dropColumn(['kelompok_pelayanan_id', 'kode', 'status']);
        });

        Schema::dropIfExists('kelompok_pelayanan');
    }
};
