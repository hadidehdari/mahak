<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AudioBook;
use Illuminate\Support\Str;

class AudioBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audioBooks = [
            [
                'title' => 'قصه‌های هزار و یک شب',
                'slug' => 'hezar-o-yek-shab',
                'description' => 'مجموعه داستان‌های قدیمی و جذاب هزار و یک شب',
                'cover_image' => 'audiobooks/hezar-o-yek-shab.jpg',
                'category_id' => 2, // دسته‌بندی کتاب‌های صوتی
                'creator_id' => 1, // خالق/گوینده
                'age_group_id' => 2, // گروه سنی 6 تا 9 سال
                'is_featured' => true,
                'is_active' => true,
                'views_count' => 500,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'قصه‌های کلیله و دمنه',
                'slug' => 'kalileh-o-demneh',
                'description' => 'مجموعه داستان‌های آموزنده کلیله و دمنه',
                'cover_image' => 'audiobooks/kalileh-o-demneh.jpg',
                'category_id' => 2,
                'creator_id' => 2,
                'age_group_id' => 2,
                'is_featured' => true,
                'is_active' => true,
                'views_count' => 400,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($audioBooks as $audioBook) {
            AudioBook::create($audioBook);
        }
    }
} 