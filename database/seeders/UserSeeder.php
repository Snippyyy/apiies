<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'password' => '123456',
            'email' => 'admin@mail.com',
            'role' => 'admin',
            ]);
        User::factory()->create([
            'name' => 'user',
            'password' => '123456',
            'email' => 'user@mail.com',
        ]);
        User::factory()->create([
            'name' => 'partner',
            'password' => '123456',
            'email' => 'partner@mail.com',
            'role' => 'partner',
        ]);

    }
}
