<?php

namespace Database\Seeders;

use App\Models\KelompokPelayanan;
use Illuminate\Database\Seeder;

class KelompokPelayananSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['kode' => 'KK', 'nama' => 'Kartu Keluarga', 'status' => true],
            ['kode' => 'AKTA', 'nama' => 'Akta Pencatatan Sipil', 'status' => true],
            ['kode' => 'KTP', 'nama' => 'KTP Elektronik', 'status' => true],
            ['kode' => 'KIA', 'nama' => 'Kartu Identitas Anak', 'status' => true],
            ['kode' => 'SURAT_PINDAH', 'nama' => 'Surat Pindah', 'status' => true],
            ['kode' => 'PEREKAMAN', 'nama' => 'Perekaman KTP Elektronik', 'status' => true],
        ];

        foreach ($groups as $data) {
            KelompokPelayanan::updateOrCreate(
                ['kode' => $data['kode']],
                $data
            );
        }
    }
}
