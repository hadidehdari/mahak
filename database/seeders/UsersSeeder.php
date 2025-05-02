<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'admin',
            'phone' => 09130134984,
            'email' => 'admin@example.com',
            'profile_photo' => null,
            'email_verified_at' => null,
            'password' => '$2y$12$yHxHLTmT3hQg6ZZ7ojARAedx48ffJTE4J/TQDxT7amDuVJKQTl04u',
            'is_admin' => 1,
            'role' => 'admin',
            'is_active' => 1,
            'profile_photo_path' => null,
            'remember_token' => null,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

    }
}
