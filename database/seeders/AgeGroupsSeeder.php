<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AgeGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('age_groups')->insert([
            'id' => 1,
            'name' => '3 تا 6 سال',
            'slug' => '3-ta-6-sal',
            'min_age' => 3,
            'max_age' => 6,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('age_groups')->insert([
            'id' => 2,
            'name' => '6 تا 9 سال',
            'slug' => '6-ta-9-sal',
            'min_age' => 6,
            'max_age' => 9,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

        DB::table('age_groups')->insert([
            'id' => 3,
            'name' => '9 تا 13 سال',
            'slug' => '9-ta-13-sal',
            'min_age' => 9,
            'max_age' => 13,
            'is_active' => 1,
            'created_at' => '2025-04-25 16:40:46',
            'updated_at' => '2025-04-25 16:40:46',
            'deleted_at' => null,
        ]);

    }
}
