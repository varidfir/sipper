<?php

namespace Tests\Feature;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasterDataFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_desa_with_manual_kecamatan_name(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'username' => 'admin-test']);
        $this->actingAs($admin);

        $response = $this->post(route('desa.store'), [
            'kecamatan_manual' => 'Kecamatan Baru',
            'nama_desa' => 'Desa Baru',
        ]);

        $response->assertRedirect(route('desa.index'));
        $this->assertDatabaseHas('kecamatan', ['nama_kecamatan' => 'Kecamatan Baru']);
        $kecamatan = Kecamatan::where('nama_kecamatan', 'Kecamatan Baru')->first();
        $this->assertDatabaseHas('desa', [
            'nama_desa' => 'Desa Baru',
            'kecamatan_id' => $kecamatan->id,
        ]);
    }

    public function test_can_create_kecamatan_from_existing_selection_or_manual_input(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'username' => 'admin-test-2']);
        $this->actingAs($admin);

        Kecamatan::create(['nama_kecamatan' => 'Ada']);

        $response = $this->post(route('kecamatan.store'), [
            'kecamatan_existing' => 'Ada',
            'nama_kecamatan' => '',
        ]);

        $response->assertRedirect(route('kecamatan.index'));
        $this->assertDatabaseHas('kecamatan', ['nama_kecamatan' => 'Ada']);
    }
}
