<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'باب اسفنجی',
                'poster' => 'https://www.uptvs.com/wp-contents/uploads/2021/02/SpongeBob-Poster-UPTV.jpg',
                'content_type' => 'video',
                'background_color' => '#9161e0',
                'text_color' => '#000000',
                'created_at' => '2025-04-25 16:43:35',
                'updated_at' => '2025-04-25 16:43:35',
                'deleted_at' => null,
            ],
            [
                'id' => 2,
                'name' => 'کتاب‌های صوتی',
                'poster' => 'https://example.com/audiobooks-poster.jpg',
                'content_type' => 'audio_book',
                'background_color' => '#4CAF50',
                'text_color' => '#FFFFFF',
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
        ]);
    }
}
