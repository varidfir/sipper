<?php

namespace Database\Seeders;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $hasJenisColumn = Schema::hasColumn('desa', 'jenis');

        $data = [
            'Barat' => [
                'desa' => [
                    'Bangunasri', 'Banjarejo', 'Blaran', 'Bogorejo', 'Jonggrang',
                    'Karangsono', 'Klagen', 'Manjung', 'Ngumpul', 'Panggung',
                    'Purwodadi', 'Rejomulyo',
                ],
                'kelurahan' => [
                    'Mangge', 'Tebon',
                ],
            ],
            'Bendo' => [
                'desa' => [
                    'Belotan', 'Bulak', 'Bulugledeg', 'Carikan', 'Dukuh',
                    'Duwet', 'Kleco', 'Kledokan', 'Kinandang', 'Lemahbang',
                    'Pingkuk', 'Setren', 'Soco', 'Tanjung', 'Tegalarum',
                ],
                'kelurahan' => [
                    'Bendo',
                ],
            ],
            'Karangrejo' => [
                'desa' => [
                    'Baluk', 'Gebyok', 'Gondang', 'Grabahan', 'Kauman',
                    'Mantren', 'Maron', 'Patihan', 'Pelem', 'Prampelan',
                    'Sambirembe',
                ],
                'kelurahan' => [
                    'Karangrejo', 'Manisrejo',
                ],
            ],
            'Karas' => [
                'desa' => [
                    'Botok', 'Geplak', 'Ginuk', 'Jungke', 'Karas',
                    'Kuwon', 'Sobontoro', 'Sumursongo', 'Taji', 'Temboro',
                    'Temenggungan',
                ],
                'kelurahan' => [],
            ],
            'Kartoharjo' => [
                'desa' => [
                    'Bayem Taman', 'Bayem Wetan', 'Gunungan', 'Jajar', 'Jeruk',
                    'Karangmojo', 'Kartoharjo', 'Klurahan', 'Mrahu', 'Ngelang',
                    'Pencol', 'Sukowidi',
                ],
                'kelurahan' => [],
            ],
            'Kawedanan' => [
                'desa' => [
                    'Balerejo', 'Bogem', 'Garon', 'Genengan', 'Giripurno',
                    'Jambangan', 'Karangrejo', 'Mangunrejo', 'Mojorejo', 'Ngadirejo',
                    'Ngentep', 'Ngunut', 'Pojok', 'Selorejo', 'Sugihrejo',
                    'Tladan', 'Tulung',
                ],
                'kelurahan' => [
                    'Kawedanan', 'Rejosari', 'Sampung',
                ],
            ],
            'Lembeyan' => [
                'desa' => [
                    'Dukuh', 'Kediren', 'Kedungpanji', 'Krowe', 'Lembeyan Wetan',
                    'Nguri', 'Pupus', 'Tapen', 'Tunggur',
                ],
                'kelurahan' => [
                    'Lembeyan Kulon',
                ],
            ],
            'Magetan' => [
                'desa' => [
                    'Baron', 'Candirejo', 'Purwosari', 'Ringinagung', 'Tambakrejo',
                ],
                'kelurahan' => [
                    'Bulukerto', 'Kepolorejo', 'Kebonagung', 'Magetan', 'Mangkujayan',
                    'Selosari', 'Sukowinangun', 'Tawanganom', 'Tambran',
                ],
            ],
            'Maospati' => [
                'desa' => [
                    'Gulun', 'Klagen Gambiran', 'Malang', 'Ngujung', 'Pandeyan',
                    'Pesu', 'Ronowijayan', 'Sempol', 'Sugihwaras', 'Sumberejo',
                    'Suratmajan', 'Tanjungsepreh',
                ],
                'kelurahan' => [
                    'Kraton', 'Maospati', 'Mranggen',
                ],
            ],
            'Ngariboyo' => [
                'desa' => [
                    'Baleasri', 'Balegondo', 'Bangsri', 'Banjarejo', 'Banjarpanjang',
                    'Banyudono', 'Mojopurno', 'Ngariboyo', 'Pendem', 'Selopanggung',
                    'Selotinatah', 'Sumberdukun',
                ],
                'kelurahan' => [],
            ],
            'Nguntoronadi' => [
                'desa' => [
                    'Driyorejo', 'Gorang-Gareng', 'Kenongomulyo', 'Nguntoronadi', 'Petungrejo',
                    'Purworejo', 'Semen', 'Simbatan', 'Sukowidi',
                ],
                'kelurahan' => [],
            ],
            'Panekan' => [
                'desa' => [
                    'Banjarejo', 'Bedagung', 'Cepoko', 'Jabung', 'Manjung',
                    'Milangasri', 'Ngiliran', 'Rejomulyo', 'Sidowayah', 'Sukowidi',
                    'Sumberdodol', 'Tanjungsari', 'Tapak', 'Terung', 'Turi',
                    'Wates',
                ],
                'kelurahan' => [
                    'Panekan',
                ],
            ],
            'Parang' => [
                'desa' => [
                    'Bungkuk', 'Joketro', 'Krajan', 'Mategal', 'Ngaglik',
                    'Nglopang', 'Ngunut', 'Pragak', 'Sayutan', 'Sundul',
                    'Trosono', 'Tamanarum',
                ],
                'kelurahan' => [
                    'Parang',
                ],
            ],
            'Plaosan' => [
                'desa' => [
                    'Bogoarum', 'Bulugunung', 'Buluharjo', 'Dadi', 'Ngancar',
                    'Nitikan', 'Pacalan', 'Plumpung', 'Puntukdoro', 'Randugede',
                    'Sendangagung', 'Sidomukti', 'Sumberagung',
                ],
                'kelurahan' => [
                    'Plaosan', 'Sarangan',
                ],
            ],
            'Poncol' => [
                'desa' => [
                    'Cileng', 'Genilangit', 'Gonggang', 'Janggan', 'Plangkrongan',
                    'Poncol', 'Sombo',
                ],
                'kelurahan' => [
                    'Alastuwo',
                ],
            ],
            'Sidorejo' => [
                'desa' => [
                    'Campursari', 'Durenan', 'Getasanyar', 'Kalang', 'Sambirobyong',
                    'Sidokerto', 'Sidomulyo', 'Sidorejo', 'Sumbersawit', 'Widorokandang',
                ],
                'kelurahan' => [],
            ],
            'Sukomoro' => [
                'desa' => [
                    'Bandar', 'Bibis', 'Bogem', 'Bulu', 'Kalangketi',
                    'Kedungguwo', 'Kembangan', 'Kentangan', 'Pojoksari', 'Sukomoro',
                    'Tamanan', 'Tambakmas', 'Truneng',
                ],
                'kelurahan' => [
                    'Tinap',
                ],
            ],
            'Takeran' => [
                'desa' => [
                    'Duyung', 'Jomblang', 'Kepuhrejo', 'Kerang', 'Kerik',
                    'Kiringan', 'Kuwonharjo', 'Madigondo', 'Sawojajar', 'Tawangrejo',
                    'Waduk',
                ],
                'kelurahan' => [
                    'Takeran',
                ],
            ],
        ];

        DB::transaction(function () use ($data, $hasJenisColumn) {
            foreach ($data as $namaKecamatan => $wilayah) {
                $kecamatan = Kecamatan::whereRaw('LOWER(nama_kecamatan) = ?', [strtolower($namaKecamatan)])->first();
                if (! $kecamatan) {
                    $kecamatan = Kecamatan::create(['nama_kecamatan' => strtoupper($namaKecamatan)]);
                } else {
                    $kecamatan->update(['nama_kecamatan' => strtoupper($namaKecamatan)]);
                }

                foreach ($wilayah['desa'] as $namaDesa) {
                    $payload = ['nama_desa' => strtoupper($namaDesa)];
                    if ($hasJenisColumn) {
                        $payload['jenis'] = 'desa';
                    }

                    Desa::updateOrCreate(
                        [
                            'kecamatan_id' => $kecamatan->id,
                            'nama_desa' => strtoupper($namaDesa),
                        ],
                        $payload
                    );
                }

                foreach ($wilayah['kelurahan'] as $namaKelurahan) {
                    $payload = ['nama_desa' => strtoupper($namaKelurahan)];
                    if ($hasJenisColumn) {
                        $payload['jenis'] = 'kelurahan';
                    }

                    Desa::updateOrCreate(
                        [
                            'kecamatan_id' => $kecamatan->id,
                            'nama_desa' => strtoupper($namaKelurahan),
                        ],
                        $payload
                    );
                }
            }
        });
    }
}
