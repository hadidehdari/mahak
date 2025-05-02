<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'phone' => '09130134984',
            'email' => 'admin@example.com',
            'password' => Hash::make('asdf@1234'),
            'is_admin' => true,
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
} 