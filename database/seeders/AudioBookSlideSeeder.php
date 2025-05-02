<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AudioBookSlide;
use App\Models\AudioBook;

class AudioBookSlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $audioBooks = AudioBook::all();
        
        foreach ($audioBooks as $audioBook) {
            // ایجاد 5 اسلاید برای هر کتاب صوتی
            for ($i = 1; $i <= 5; $i++) {
                AudioBookSlide::create([
                    'audio_book_id' => $audioBook->id,
                    'title' => 'اسلاید ' . $i . ' - ' . $audioBook->title,
                    'description' => 'توضیحات اسلاید ' . $i . ' از کتاب ' . $audioBook->title,
                    'image' => 'audio-book-slides/slide-' . $i . '.jpg',
                    'audio_url' => 'https://example.com/audio/' . $audioBook->slug . '/slide-' . $i . '.mp3',
                    'duration' => rand(60, 180), // مدت زمان بین 1 تا 3 دقیقه
                    'order' => $i,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
    }
} 