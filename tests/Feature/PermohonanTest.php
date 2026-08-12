<?php

namespace Tests\Feature;

use App\Models\Desa;
use App\Models\JenisPelayanan;
use App\Models\Kecamatan;
use App\Models\Permohonan;
use App\Models\User;
use Database\Seeders\JenisPelayananSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermohonanTest extends TestCase
{
    use RefreshDatabase;

    public function test_rekap_service_seeder_includes_requested_service_types(): void
    {
        $this->seed(JenisPelayananSeeder::class);

        $serviceNames = JenisPelayanan::query()
            ->pluck('nama_pelayanan')
            ->map(fn ($name) => strtolower(trim($name)))
            ->all();

        $this->assertContains('kk', $serviceNames);
        $this->assertContains('kia', $serviceNames);
        $this->assertContains('surat pindah', $serviceNames);
        $this->assertContains('perekaman', $serviceNames);
    }

    public function test_create_form_contains_dynamic_detail_groups_for_selected_categories(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas-create-form',
            'role' => 'petugas',
        ]);

        JenisPelayanan::query()->delete();

        $response = $this->actingAs($user)->get(route('permohonan.create'));

        $response->assertOk();
        $response->assertSee('jenis_pelayanan_select', false);
        $response->assertSee('KK', false);
        $response->assertSee('KIA', false);
        $response->assertSee('KTP', false);
        $response->assertSee('data-detail-group="kk"', false);
        $response->assertSee('data-detail-group="akta"', false);
        $response->assertSee('data-detail-group="ktp"', false);
    }

    public function test_petugas_can_store_permohonan_to_database(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas1',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Test']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Test',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KTP Elektronik',
            'kategori' => 'Administrasi',
        ]);

        $payload = [
            'nomor_permohonan' => 'P-001',
            'nama_pemohon' => 'Budi Santoso',
            'nik_pemohon' => '3201010101010001',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'keterangan' => 'Permohonan baru',
        ];

        $response = $this->actingAs($user)->post(route('permohonan.store'), $payload);

        $response->assertRedirect(route('permohonan.index'));
        $this->assertDatabaseHas('permohonan', [
            'nomor_permohonan' => 'P-001',
            'nama_pemohon' => 'Budi Santoso',
            'user_id' => $user->id,
        ]);
        $this->assertEquals(1, Permohonan::count());
    }

    public function test_petugas_can_store_category_specific_detail_data_for_akta(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas2',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Detail']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Detail',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'Akta Kelahiran Anak',
            'kategori' => 'Akta',
        ]);

        $response = $this->actingAs($user)->post(route('permohonan.store'), [
            'nomor_permohonan' => 'P-900',
            'nama_pemohon' => 'Rina',
            'nik_pemohon' => '3201010101010010',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'keterangan' => 'Permohonan akta baru',
            'detail_data' => [
                'jenis_akta' => 'Akta Kelahiran Anak',
                'nomor_kendali' => 'K-001',
            ],
        ]);

        $response->assertRedirect(route('permohonan.index'));
        $permohonan = Permohonan::where('nomor_permohonan', 'P-900')->first();
        $this->assertNotNull($permohonan);
        $this->assertSame('Akta Kelahiran Anak', $permohonan->detail_data['jenis_akta'] ?? null);
        $this->assertSame('K-001', $permohonan->detail_data['nomor_kendali'] ?? null);
    }

    public function test_petugas_can_update_existing_permohonan(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas3',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Test']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Test',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KTP Elektronik',
            'kategori' => 'Administrasi',
        ]);
        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'P-100',
            'nama_pemohon' => 'Andi',
            'nik_pemohon' => '3201010101010002',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Lama',
        ]);

        $response = $this->actingAs($user)->put(route('permohonan.update', $permohonan), [
            'nomor_permohonan' => 'P-100',
            'nama_pemohon' => 'Andi Wijaya',
            'nik_pemohon' => '3201010101010002',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'keterangan' => 'Baru',
        ]);

        $response->assertRedirect(route('permohonan.index'));
        $this->assertDatabaseHas('permohonan', [
            'id' => $permohonan->id,
            'nama_pemohon' => 'Andi Wijaya',
            'keterangan' => 'Baru',
        ]);
    }

    public function test_petugas_can_view_detail_permohonan(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas3',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Test']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Test',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KTP Elektronik',
            'kategori' => 'Administrasi',
        ]);
        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'P-200',
            'nama_pemohon' => 'Citra',
            'nik_pemohon' => '3201010101010003',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Detail',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.show', $permohonan));

        $response->assertOk();
        $response->assertSee('Citra');
        $response->assertSee('P-200');
    }

    public function test_petugas_can_search_permohonan_by_name_or_number(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas4',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Test']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Test',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KTP Elektronik',
            'kategori' => 'Administrasi',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'P-300',
            'nama_pemohon' => 'Dina',
            'nik_pemohon' => '3201010101010004',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Satu',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'P-400',
            'nama_pemohon' => 'Eko',
            'nik_pemohon' => '3201010101010005',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Dua',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.index', ['search' => 'Dina']));

        $response->assertOk();
        $response->assertSee('Dina');
        $response->assertDontSee('Eko');
    }

    public function test_petugas_can_filter_permohonan_by_date_and_related_master_data(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas5',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Filter']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Filter',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KK',
            'kategori' => 'Administrasi',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'P-500',
            'nama_pemohon' => 'Fani',
            'nik_pemohon' => '3201010101010006',
            'tanggal_permohonan' => '2026-08-15',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Filter satu',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'P-600',
            'nama_pemohon' => 'Gita',
            'nik_pemohon' => '3201010101010007',
            'tanggal_permohonan' => '2026-09-15',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Filter dua',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.index', [
            'month' => '08',
            'year' => '2026',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
        ]));

        $response->assertOk();
        $response->assertSee('Fani');
        $response->assertDontSee('Gita');
    }

    public function test_petugas_can_view_recapitulasi_and_export_data(): void
    {
        $user = User::factory()->create([
            'username' => 'petugas6',
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan Rekap']);
        $desa = Desa::create([
            'nama_desa' => 'Desa Rekap',
            'kecamatan_id' => $kecamatan->id,
        ]);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'Akta',
            'kategori' => 'Administrasi',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'P-700',
            'nama_pemohon' => 'Hana',
            'nik_pemohon' => '3201010101010008',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Rekap',
        ]);

        $response = $this->actingAs($user)->get(route('permohonan.recap', ['period' => 'monthly']));
        $response->assertOk();
        $response->assertSee('Rekapitulasi');

        $exportResponse = $this->actingAs($user)->get(route('permohonan.export', ['format' => 'csv']));
        $exportResponse->assertOk();
        $exportResponse->assertSee('nomor_permohonan');
    }
}
