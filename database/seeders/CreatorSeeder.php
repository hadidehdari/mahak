<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Creator;
use Illuminate\Support\Str;

class CreatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creators = [
            [
                'name' => 'هادی دهداری',
                'slug' => 'hadi-dehdari',
                'photo' => 'creators/hadi.jpg',
                'description' => 'برنامه‌نویس و توسعه‌دهنده وب',
                'bio' => 'برنامه‌نویس با تجربه در زمینه توسعه وب و موبایل'
            ],
            [
                'name' => 'علی محمدی',
                'slug' => 'ali-mohammadi',
                'photo' => 'creators/ali.jpg',
                'description' => 'کارگردان و تهیه‌کننده',
                'bio' => 'کارگردان با بیش از 10 سال تجربه در ساخت انیمیشن'
            ],
            [
                'name' => 'مریم احمدی',
                'slug' => 'maryam-ahmadi',
                'photo' => 'creators/maryam.jpg',
                'description' => 'نویسنده و گوینده',
                'bio' => 'نویسنده کتاب‌های کودک و گوینده کتاب‌های صوتی'
            ],
            [
                'name' => 'محمدرضا شجریان',
                'slug' => 'mohammadreza-shajarian',
                'photo' => 'creators/shajarian.jpg',
                'description' => 'استاد محمدرضا شجریان، استاد آواز ایران'
            ],
            [
                'name' => 'شهرام ناظری',
                'slug' => 'shahram-nazeri',
                'photo' => 'creators/nazeri.jpg',
                'description' => 'شهرام ناظری، خواننده و موسیقیدان ایرانی'
            ],
            [
                'name' => 'محمدرضا لطفی',
                'slug' => 'mohammadreza-lotfi',
                'photo' => 'creators/lotfi.jpg',
                'description' => 'محمدرضا لطفی، نوازنده و موسیقیدان ایرانی'
            ]
        ];

        foreach ($creators as $creator) {
            Creator::create($creator);
        }
    }
}
