<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AgeGroup;
use Illuminate\Support\Str;

class AgeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ageGroups = [
            [
                'name' => '3 تا 6 سال',
                'slug' => '3-ta-6-sal',
                'min_age' => 3,
                'max_age' => 6,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '6 تا 9 سال',
                'slug' => '6-ta-9-sal',
                'min_age' => 6,
                'max_age' => 9,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => '9 تا 13 سال',
                'slug' => '9-ta-13-sal',
                'min_age' => 9,
                'max_age' => 13,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($ageGroups as $ageGroup) {
            AgeGroup::create($ageGroup);
        }
    }
} 