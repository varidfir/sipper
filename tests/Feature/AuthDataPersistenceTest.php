<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthDataPersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_does_not_overwrite_existing_admin_credentials(): void
    {
        $originalPassword = 'AmanPassword123!';

        $admin = User::factory()->create([
            'name' => 'Admin Lama',
            'username' => 'admin',
            'email' => 'admin-lama@example.com',
            'password' => Hash::make($originalPassword),
            'role' => 'admin',
        ]);

        $this->artisan('db:seed', [
            '--class' => DatabaseSeeder::class,
        ])->assertExitCode(0);

        $admin->refresh();

        $this->assertSame('Admin Lama', $admin->name);
        $this->assertSame('admin', $admin->username);
        $this->assertSame('admin-lama@example.com', $admin->email);
        $this->assertSame('admin', $admin->role);
        $this->assertTrue(Hash::check($originalPassword, $admin->password));
    }

    public function test_database_seeder_does_not_overwrite_existing_petugas_credentials(): void
    {
        $originalPassword = 'PetugasPassword123!';

        $petugas = User::factory()->create([
            'name' => 'Petugas Lama',
            'username' => 'petugas',
            'email' => 'petugas-lama@example.com',
            'password' => Hash::make($originalPassword),
            'role' => 'petugas',
        ]);

        $this->artisan('db:seed', [
            '--class' => DatabaseSeeder::class,
        ])->assertExitCode(0);

        $petugas->refresh();

        $this->assertSame('Petugas Lama', $petugas->name);
        $this->assertSame('petugas', $petugas->username);
        $this->assertSame('petugas-lama@example.com', $petugas->email);
        $this->assertSame('petugas', $petugas->role);
        $this->assertTrue(Hash::check($originalPassword, $petugas->password));
    }

    public function test_login_works_with_existing_admin_credentials_after_seeding(): void
    {
        $password = 'AmanPassword123!';

        $admin = User::factory()->create([
            'username' => 'admin',
            'email' => 'admin-lama@example.com',
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->artisan('db:seed', [
            '--class' => DatabaseSeeder::class,
        ])->assertExitCode(0);

        $this->post(route('login.post'), [
            'login' => 'admin',
            'password' => $password,
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($admin);
    }
}
