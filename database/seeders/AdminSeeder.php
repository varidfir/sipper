<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Create the default development accounts only when they do not exist.
     *
     * IMPORTANT:
     * Existing Admin/Petugas credentials are never overwritten by seeding.
     * This prevents `db:seed` from unexpectedly changing login data.
     */
    public function run(): void
    {
        $this->ensureUser(
            username: (string) env('SIPPER_ADMIN_USERNAME', 'admin'),
            name: (string) env('SIPPER_ADMIN_NAME', 'Administrator'),
            email: (string) env('SIPPER_ADMIN_EMAIL', 'admin@admin.com'),
            password: (string) env('SIPPER_ADMIN_PASSWORD', 'password12345678'),
            role: 'admin',
        );

        $this->ensureUser(
            username: (string) env('SIPPER_PETUGAS_USERNAME', 'petugas'),
            name: (string) env('SIPPER_PETUGAS_NAME', 'Petugas Demo'),
            email: (string) env('SIPPER_PETUGAS_EMAIL', 'petugas@admin.com'),
            password: (string) env('SIPPER_PETUGAS_PASSWORD', 'password12345678'),
            role: 'petugas',
        );
    }

    /**
     * Create an account if the username does not exist.
     *
     * Existing rows are deliberately left untouched, including:
     * - username
     * - email
     * - password
     * - name
     * - role
     *
     * This makes the seeder safe to run repeatedly.
     */
    protected function ensureUser(
        string $username,
        string $name,
        string $email,
        string $password,
        string $role
    ): void {
        User::firstOrCreate(
            ['username' => $username],
            [
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $role,
            ]
        );
    }
}
