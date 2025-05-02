<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Video;
use Illuminate\Support\Str;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $videos = [
            [
                'title' => 'باب اسفنجی - قسمت 1',
                'slug' => 'spongebob-episode-1',
                'description' => 'قسمت اول سریال باب اسفنجی',
                'thumbnail' => 'videos/spongebob-ep1.jpg',
                'video_url' => 'https://example.com/videos/spongebob-ep1.mp4',
                'duration' => 1200, // 20 دقیقه
                'file_size' => '150MB',
                'background_color' => '#9161e0',
                'category_id' => 1, // دسته‌بندی باب اسفنجی
                'creator_id' => 1, // خالق/کارگردان
                'age_group_id' => 1, // گروه سنی 3 تا 6 سال
                'is_featured' => true,
                'is_active' => true,
                'views_count' => 1000,
                'rating' => 4.5,
                'rating_count' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'باب اسفنجی - قسمت 2',
                'slug' => 'spongebob-episode-2',
                'description' => 'قسمت دوم سریال باب اسفنجی',
                'thumbnail' => 'videos/spongebob-ep2.jpg',
                'video_url' => 'https://example.com/videos/spongebob-ep2.mp4',
                'duration' => 1200,
                'file_size' => '150MB',
                'background_color' => '#9161e0',
                'category_id' => 1,
                'creator_id' => 1,
                'age_group_id' => 1,
                'is_featured' => false,
                'is_active' => true,
                'views_count' => 800,
                'rating' => 4.2,
                'rating_count' => 40,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}
