<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    public function run()
    {
        $persons = [
            [
                'code' => '100001',
                'type' => 'individual',
                'first_name' => 'علی',
                'last_name' => 'محمدی',
                'display_name' => 'علی محمدی',
                'mobile' => '09121234567',
                'email' => 'ali@example.com',
                'category_id' => 1,
                'is_customer' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100002',
                'type' => 'company',
                'company_name' => 'شرکت پارس',
                'display_name' => 'شرکت پارس',
                'economic_code' => '411111111111',
                'registration_number' => '12345',
                'phone' => '02188776655',
                'category_id' => 2,
                'is_supplier' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100003',
                'type' => 'individual',
                'first_name' => 'مریم',
                'last_name' => 'حسینی',
                'display_name' => 'مریم حسینی',
                'mobile' => '09129876543',
                'email' => 'maryam@example.com',
                'category_id' => 3,
                'is_employee' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100004',
                'type' => 'company',
                'company_name' => 'گروه صنعتی ایران',
                'display_name' => 'گروه صنعتی ایران',
                'category_id' => 2,
                'is_supplier' => true,
                'is_active' => false,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100005',
                'type' => 'individual',
                'first_name' => 'رضا',
                'last_name' => 'کریمی',
                'display_name' => 'رضا کریمی',
                'category_id' => 1,
                'is_customer' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100006',
                'type' => 'individual',
                'first_name' => 'زهرا',
                'last_name' => 'رضایی',
                'display_name' => 'زهرا رضایی',
                'category_id' => 3,
                'is_employee' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100007',
                'type' => 'company',
                'company_name' => 'فروشگاه زنجیره‌ای مهر',
                'display_name' => 'فروشگاه مهر',
                'category_id' => 1,
                'is_customer' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100008',
                'type' => 'individual',
                'first_name' => 'محمد',
                'last_name' => 'علوی',
                'display_name' => 'محمد علوی',
                'category_id' => 4,
                'is_shareholder' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100009',
                'type' => 'company',
                'company_name' => 'شرکت نوآوران',
                'display_name' => 'شرکت نوآوران',
                'category_id' => 2,
                'is_supplier' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'code' => '100010',
                'type' => 'individual',
                'first_name' => 'سارا',
                'last_name' => 'احمدی',
                'display_name' => 'سارا احمدی',
                'category_id' => 3,
                'is_employee' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($persons as $person) {
            Person::create($person);
        }
    }
}