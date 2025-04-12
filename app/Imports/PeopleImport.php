<?php

namespace App\Imports;

use App\Models\Person;
use App\Models\PersonCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class PeopleImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;

    public function model(array $row)
    {
        $category = PersonCategory::where('name', $row['category'])->first();
        if (!$category) {
            throw new \Exception('دسته‌بندی یافت نشد: ' . $row['category']);
        }

        return new Person([
            'code' => $row['code'],
            'type' => $row['type'] === 'حقیقی' ? 'individual' : 'company',
            'title' => $row['title'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'display_name' => $row['display_name'],
            'company_name' => $row['company_name'],
            'category_id' => $category->id,
            'national_code' => $row['national_code'],
            'economic_code' => $row['economic_code'],
            'registration_number' => $row['registration_number'],
            'mobile' => $row['mobile'],
            'phone' => $row['phone'],
            'email' => $row['email'],
            'website' => $row['website'],
            'country' => $row['country'],
            'state' => $row['state'],
            'city' => $row['city'],
            'postal_code' => $row['postal_code'],
            'address' => $row['address'],
            'credit_limit' => $row['credit_limit'],
            'opening_balance' => $row['opening_balance'],
            'is_active' => $row['status'] === 'فعال',
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|unique:people,code',
            'type' => 'required|in:حقیقی,حقوقی',
            'category' => 'required|exists:person_categories,name',
        ];
    }
}