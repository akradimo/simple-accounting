<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\PersonCategory;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    public function run()
    {
        // ایجاد دسته‌بندی‌های پیش‌فرض
        $categories = [
            ['name' => 'مشتری', 'color' => '#4F46E5', 'icon' => 'users'],
            ['name' => 'تامین‌کننده', 'color' => '#10B981', 'icon' => 'building'],
            ['name' => 'کارمند', 'color' => '#F59E0B', 'icon' => 'user-tie'],
        ];

        foreach ($categories as $category) {
            PersonCategory::create($category);
        }

        // ایجاد چند شخص نمونه
        Person::create([
            'code' => 'P001',
            'type' => 'individual',
            'first_name' => 'علی',
            'last_name' => 'محمدی',
            'mobile' => '09123456789',
            'category_id' => 1,
            'status' => 'active',
            'credit_limit' => 1000000,
            'balance' => 500000
        ]);

        Person::create([
            'code' => 'P002',
            'type' => 'company',
            'company_name' => 'شرکت نمونه',
            'economic_code' => '123456789',
            'phone' => '02188776655',
            'category_id' => 2,
            'status' => 'active',
            'credit_limit' => 5000000,
            'balance' => -1000000
        ]);
    }
}