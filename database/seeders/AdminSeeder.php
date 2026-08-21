<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@fichos.sena.edu.co')],
            [
                'name' => env('ADMIN_NAME', 'Administrador'),
                'email' => env('ADMIN_EMAIL', 'admin@fichos.sena.edu.co'),
                'password' => bcrypt(env('ADMIN_PASSWORD', 'admin123456')),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
