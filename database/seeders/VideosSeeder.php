<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VideosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('videos')->insert([
            'id' => 1,
            'title' => 'باب مهربان',
            'slug' => 'bab-mhrban',
            'description' => 'مراسمی مهربانی',
            'thumbnail' => 'http://localhost:8000/storage//Screenshot 2025-04-25 164503.png',
            'video_url' => 'https://caspian9.cdn.asset.aparat.com/aparat-video/425cacf47e84656a6941165533847ec264262797-240p.mp4?wmsAuthSign=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6IjE1M2UwZmJhNDBmNjc1M2QwNjRiZGRmODE2MWViMzZhIiwiZXhwIjoxNzQ1NjA1MDY0LCJpc3MiOiJTYWJhIElkZWEgR1NJRyJ9.3Vk3wJ9HImya-uzTwV2h-VjQS5IKL-wJAgViaiQx2pE',
            'duration' => 320,
            'file_size' => '50 MB',
            'background_color' => '#34a3d8',
            'category_id' => 1,
            'creator_id' => 1,
            'age_group_id' => 2,
            'is_featured' => 0,
            'is_active' => 1,
            'views_count' => 0,
            'rating' => 0.00,
            'rating_count' => 0,
            'created_at' => '2025-04-25 16:55:01',
            'updated_at' => '2025-04-25 16:55:01',
            'deleted_at' => null,
        ]);

    }
}
