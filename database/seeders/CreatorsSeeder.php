<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreatorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('creators')->insert([
            'id' => 1,
            'name' => 'هادی دهداری',
            'slug' => 'hadi-dehdari',
            'bio' => 'برنامه‌نویس با تجربه در زمینه توسعه وب و موبایل',
            'photo' => 'creators/hadi.jpg',
            'description' => 'برنامه‌نویس و توسعه‌دهنده وب',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('creators')->insert([
            'id' => 2,
            'name' => 'علی محمدی',
            'slug' => 'ali-mohammadi',
            'bio' => 'کارگردان با بیش از 10 سال تجربه در ساخت انیمیشن',
            'photo' => 'creators/ali.jpg',
            'description' => 'کارگردان و تهیه‌کننده',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('creators')->insert([
            'id' => 3,
            'name' => 'مریم احمدی',
            'slug' => 'maryam-ahmadi',
            'bio' => 'نویسنده کتاب‌های کودک و گوینده کتاب‌های صوتی',
            'photo' => 'creators/maryam.jpg',
            'description' => 'نویسنده و گوینده',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('creators')->insert([
            'id' => 4,
            'name' => 'محمدرضا شجریان',
            'slug' => 'mohammadreza-shajarian',
            'bio' => null,
            'photo' => 'creators/shajarian.jpg',
            'description' => 'استاد محمدرضا شجریان، استاد آواز ایران',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('creators')->insert([
            'id' => 5,
            'name' => 'شهرام ناظری',
            'slug' => 'shahram-nazeri',
            'bio' => null,
            'photo' => 'creators/nazeri.jpg',
            'description' => 'شهرام ناظری، خواننده و موسیقیدان ایرانی',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('creators')->insert([
            'id' => 6,
            'name' => 'محمدرضا لطفی',
            'slug' => 'mohammadreza-lotfi',
            'bio' => null,
            'photo' => 'creators/lotfi.jpg',
            'description' => 'محمدرضا لطفی، نوازنده و موسیقیدان ایرانی',
            'avatar' => null,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

    }
}
