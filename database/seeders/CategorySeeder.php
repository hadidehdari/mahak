<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'باب اسفنجی',
                'slug' => 'spongebob',
                'poster' => 'categories/spongebob.jpg',
                'content_type' => 'video',
                'background_color' => '#9161e0',
                'text_color' => '#FFFFFF',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'کتاب‌های صوتی',
                'slug' => 'audiobooks',
                'poster' => 'categories/audiobooks.jpg',
                'content_type' => 'audio_book',
                'background_color' => '#4CAF50',
                'text_color' => '#FFFFFF',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 