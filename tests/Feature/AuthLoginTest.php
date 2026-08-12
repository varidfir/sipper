<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_login_with_username_and_password(): void
    {
        User::factory()->create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs(User::where('username', 'admin')->first());
    }

    public function test_database_seeder_creates_default_admin_and_petugas_accounts(): void
    {
        $this->artisan('db:seed', ['--class' => DatabaseSeeder::class]);

        $this->assertTrue(User::where('username', 'admin')->where('role', 'admin')->exists());
        $this->assertTrue(User::where('username', 'petugas')->where('role', 'petugas')->exists());
    }

    public function test_login_redirects_to_dashboard_even_if_previous_intended_url_exists(): void
    {
        User::factory()->create([
            'username' => 'petugas',
            'email' => 'petugas@example.com',
            'password' => bcrypt('password123'),
            'role' => 'petugas',
        ]);

        $this->withSession(['url.intended' => '/permohonan'])->post('/login', [
            'login' => 'petugas',
            'password' => 'password123',
        ])->assertRedirect('/dashboard');
    }
}
