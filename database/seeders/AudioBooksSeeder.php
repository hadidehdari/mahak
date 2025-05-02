<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AudioBook;
use Illuminate\Support\Str;

class AudioBooksSeeder extends Seeder
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
                'category_id' => 1, // دسته‌بندی کتاب‌های صوتی
                'creator_id' => 1, // خالق/گوینده
                'age_group_id' => 2, // گروه سنی 6 تا 9 سال
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'قصه‌های کلیله و دمنه',
                'slug' => 'kalileh-o-demneh',
                'description' => 'مجموعه داستان‌های آموزنده کلیله و دمنه',
                'cover_image' => 'audiobooks/kalileh-o-demneh.jpg',
                'category_id' => 1,
                'creator_id' => 2,
                'age_group_id' => 2,
                'is_featured' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'قصه‌های مثنوی',
                'slug' => 'masnavi-stories',
                'description' => 'داستان‌های آموزنده از مثنوی مولانا',
                'cover_image' => 'audiobooks/masnavi.jpg',
                'category_id' => 1,
                'creator_id' => 3,
                'age_group_id' => 3, // گروه سنی 9 تا 13 سال
                'is_featured' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($audioBooks as $audioBook) {
            AudioBook::create($audioBook);
        }
    }
} 