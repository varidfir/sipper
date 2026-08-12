<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_returns_success_message(): void
    {
        User::factory()->create([
            'name' => 'Admin Test',
            'username' => 'adminapi',
            'email' => 'adminapi@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'adminapi@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Login berhasil']);
    }

    public function test_unauthenticated_user_cannot_access_permohonan_api(): void
    {
        $response = $this->getJson('/api/permohonan');

        $response->assertStatus(401);
    }
}
