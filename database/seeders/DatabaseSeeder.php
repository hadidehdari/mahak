<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            CreatorSeeder::class,
            AgeGroupSeeder::class,
            VideoSeeder::class,
            AudioBooksSeeder::class,
            AudioBookSlidesSeeder::class,
        ]);
    }
}
