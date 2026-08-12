<?php

namespace Database\Seeders;

use App\Models\JenisPelayanan;
use App\Models\KelompokPelayanan;
use Illuminate\Database\Seeder;

class JenisPelayananSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'KK' => [
                [
                    'kode' => 'KK_BARU',
                    'nama' => 'KK Baru',
                    'kategori' => 'Kartu Keluarga (KK)',
                ],
                [
                    'kode' => 'KK_PERUBAHAN',
                    'nama' => 'Perubahan KK',
                    'kategori' => 'Kartu Keluarga (KK)',
                ],
                [
                    'kode' => 'KK_PECAH',
                    'nama' => 'Pecah KK',
                    'kategori' => 'Kartu Keluarga (KK)',
                ],
            ],

            'AKTA' => [
                [
                    'kode' => 'AKTA_KELAHIRAN_UMUM',
                    'nama' => 'Akta Kelahiran Umum',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_KELAHIRAN_TERLAMBAT',
                    'nama' => 'Akta Kelahiran Terlambat',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PETIKAN_KEDUA',
                    'nama' => 'Akta Petikan Kedua',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_KEMATIAN',
                    'nama' => 'Akta Kematian',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PEMBATALAN',
                    'nama' => 'Pembatalan Akta',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PENGESAHAN_ANAK',
                    'nama' => 'Pengesahan Anak',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PERKAWINAN',
                    'nama' => 'Akta Perkawinan',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PERCERAIAN',
                    'nama' => 'Akta Perceraian',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PERUBAHAN_NAMA',
                    'nama' => 'Akta Perubahan Nama',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
                [
                    'kode' => 'AKTA_PENGANGKATAN_ANAK',
                    'nama' => 'Akta Pengangkatan Anak',
                    'kategori' => 'Akta Pencatatan Sipil',
                ],
            ],

            'KTP' => [
                [
                    'kode' => 'KTP_HILANG',
                    'nama' => 'Hilang',
                    'kategori' => 'KTP Elektronik',
                ],
                [
                    'kode' => 'KTP_RUSAK',
                    'nama' => 'Rusak',
                    'kategori' => 'KTP Elektronik',
                ],
                [
                    'kode' => 'KTP_ELEMEN',
                    'nama' => 'Perubahan Elemen',
                    'kategori' => 'KTP Elektronik',
                ],
                [
                    'kode' => 'KTP_PRR',
                    'nama' => 'PRR / Pemula',
                    'kategori' => 'KTP Elektronik',
                ],
            ],

            'KIA' => [
                [
                    'kode' => 'KIA',
                    'nama' => 'KIA',
                    'kategori' => 'Kartu Identitas Anak (KIA)',
                ],
            ],

            'SURAT_PINDAH' => [
                [
                    'kode' => 'SURAT_PINDAH',
                    'nama' => 'Surat Pindah',
                    'kategori' => 'Surat Pindah',
                ],
            ],

            'PEREKAMAN' => [
                [
                    'kode' => 'PEREKAMAN',
                    'nama' => 'Perekaman KTP-el',
                    'kategori' => 'Perekaman KTP Elektronik',
                ],
            ],
        ];

        foreach ($data as $kelompokKode => $pelayananList) {
            $kelompok = KelompokPelayanan::where('kode', $kelompokKode)->first();

            if (!$kelompok) {
                continue;
            }

            foreach ($pelayananList as $pelayanan) {
                JenisPelayanan::updateOrCreate(
                    [
                        'kode' => $pelayanan['kode'],
                    ],
                    [
                        'kelompok_pelayanan_id' => $kelompok->id,
                        'nama_pelayanan' => $pelayanan['nama'],
                        'kategori' => $pelayanan['kategori'],
                        'status' => true,
                    ]
                );
            }
        }
    }
}