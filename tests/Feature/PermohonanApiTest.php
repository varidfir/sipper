<?php

namespace Tests\Feature;

use App\Models\Desa;
use App\Models\JenisPelayanan;
use App\Models\Kecamatan;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermohonanApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_permohonan_via_api(): void
    {
        $user = User::factory()->create([
            'name' => 'Petugas Test',
            'username' => 'petugasapi',
            'email' => 'petugasapi@example.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan A']);
        $desa = Desa::create(['kecamatan_id' => $kecamatan->id, 'nama_desa' => 'Desa A']);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KTP',
            'kategori' => 'umum',
        ]);

        $this->actingAs($user);

        $response = $this->postJson('/api/permohonan', [
            'nomor_permohonan' => 'PMH-001',
            'nama_pemohon' => 'Budi',
            'nik_pemohon' => '1234567890123456',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'keterangan' => 'Test API',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nomor_permohonan', 'PMH-001');

        $this->assertDatabaseHas('permohonan', ['nomor_permohonan' => 'PMH-001']);
    }

    public function test_authenticated_user_can_list_permohonan_via_api(): void
    {
        $user = User::factory()->create([
            'name' => 'Petugas Test 2',
            'username' => 'petugasapi2',
            'email' => 'petugasapi2@example.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan B']);
        $desa = Desa::create(['kecamatan_id' => $kecamatan->id, 'nama_desa' => 'Desa B']);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'KK',
            'kategori' => 'umum',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'PMH-002',
            'nama_pemohon' => 'Siti',
            'nik_pemohon' => '6543210987654321',
            'tanggal_permohonan' => '2026-08-11',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Data test',
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/permohonan');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonFragment(['nomor_permohonan' => 'PMH-002']);
    }

    public function test_recap_api_returns_paginated_summary(): void
    {
        $user = User::factory()->create([
            'name' => 'Petugas Test 3',
            'username' => 'petugasapi3',
            'email' => 'petugasapi3@example.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan C']);
        $desa = Desa::create(['kecamatan_id' => $kecamatan->id, 'nama_desa' => 'Desa C']);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'SIM',
            'kategori' => 'umum',
        ]);

        Permohonan::create([
            'nomor_permohonan' => 'PMH-003',
            'nama_pemohon' => 'Dina',
            'nik_pemohon' => '1111222233334444',
            'tanggal_permohonan' => '2026-08-10',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Rekap test',
        ]);

        $this->actingAs($user);

        $response = $this->getJson('/api/rekap?period=daily&year=2026&per_page=10');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('pagination.total', 1);
    }

    public function test_authenticated_user_can_update_and_delete_permohonan_via_api(): void
    {
        $user = User::factory()->create([
            'name' => 'Petugas Test 4',
            'username' => 'petugasapi4',
            'email' => 'petugasapi4@example.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        $kecamatan = Kecamatan::create(['nama_kecamatan' => 'Kecamatan D']);
        $desa = Desa::create(['kecamatan_id' => $kecamatan->id, 'nama_desa' => 'Desa D']);
        $jenisPelayanan = JenisPelayanan::create([
            'nama_pelayanan' => 'Akta',
            'kategori' => 'umum',
        ]);

        $permohonan = Permohonan::create([
            'nomor_permohonan' => 'PMH-004',
            'nama_pemohon' => 'Rina',
            'nik_pemohon' => '5555666677778888',
            'tanggal_permohonan' => '2026-08-12',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'user_id' => $user->id,
            'keterangan' => 'Before update',
        ]);

        $this->actingAs($user);

        $updateResponse = $this->putJson('/api/permohonan/'.$permohonan->id, [
            'nomor_permohonan' => 'PMH-004',
            'nama_pemohon' => 'Rina Updated',
            'nik_pemohon' => '5555666677778888',
            'tanggal_permohonan' => '2026-08-12',
            'jenis_pelayanan_id' => $jenisPelayanan->id,
            'kecamatan_id' => $kecamatan->id,
            'desa_id' => $desa->id,
            'keterangan' => 'Updated',
        ]);

        $updateResponse->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.nama_pemohon', 'Rina Updated');

        $deleteResponse = $this->deleteJson('/api/permohonan/'.$permohonan->id);

        $deleteResponse->assertStatus(200)
            ->assertJsonPath('success', true);
    }
}
