<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Child;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ایجاد کاربر ادمین
        User::create([
            'name' => 'مدیر سیستم',
            'phone' => '09123456789',
            'email' => 'admin@mahak.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
            'role' => 'admin',
        ]);

        // ایجاد چند کاربر عادی با فرزندان
        $users = [
            [
                'name' => 'علی محمدی',
                'phone' => '09123456790',
                'email' => 'ali@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'role' => 'parent',
                'children' => [
                    [
                        'name' => 'سارا محمدی',
                        'gender' => 'female',
                        'birth_date' => '2018-05-15',
                        'is_active' => true,
                    ],
                    [
                        'name' => 'امیر محمدی',
                        'gender' => 'male',
                        'birth_date' => '2020-03-20',
                        'is_active' => true,
                    ],
                ],
            ],
            [
                'name' => 'مریم احمدی',
                'phone' => '09123456791',
                'email' => 'maryam@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'role' => 'parent',
                'children' => [
                    [
                        'name' => 'رضا احمدی',
                        'gender' => 'male',
                        'birth_date' => '2015-08-10',
                        'is_active' => true,
                    ],
                ],
            ],
            [
                'name' => 'حسن رضایی',
                'phone' => '09123456792',
                'email' => 'hasan@example.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_active' => true,
                'role' => 'parent',
                'children' => [
                    [
                        'name' => 'زهرا رضایی',
                        'gender' => 'female',
                        'birth_date' => '2019-11-25',
                        'is_active' => true,
                    ],
                    [
                        'name' => 'محمد رضایی',
                        'gender' => 'male',
                        'birth_date' => '2017-04-30',
                        'is_active' => true,
                    ],
                ],
            ],
        ];

        foreach ($users as $userData) {
            $children = $userData['children'];
            unset($userData['children']);
            
            $user = User::create($userData);
            
            foreach ($children as $childData) {
                $user->children()->create($childData);
            }
        }
    }
}
