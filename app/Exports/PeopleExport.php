<?php

namespace App\Exports;

use App\Models\Person;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeopleExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Person::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'کد',
            'نوع',
            'عنوان',
            'نام',
            'نام خانوادگی',
            'نام مستعار',
            'نام شرکت',
            'دسته‌بندی',
            'کد ملی',
            'کد اقتصادی',
            'شماره ثبت',
            'موبایل',
            'تلفن',
            'ایمیل',
            'وب‌سایت',
            'کشور',
            'استان',
            'شهر',
            'کد پستی',
            'آدرس',
            'سقف اعتبار',
            'مانده اول دوره',
            'وضعیت',
            'تاریخ ایجاد'
        ];
    }

    public function map($person): array
    {
        return [
            $person->code,
            $person->type === 'individual' ? 'حقیقی' : 'حقوقی',
            $person->title,
            $person->first_name,
            $person->last_name,
            $person->display_name,
            $person->company_name,
            $person->category->name,
            $person->national_code,
            $person->economic_code,
            $person->registration_number,
            $person->mobile,
            $person->phone,
            $person->email,
            $person->website,
            $person->country,
            $person->state,
            $person->city,
            $person->postal_code,
            $person->address,
            $person->credit_limit,
            $person->opening_balance,
            $person->is_active ? 'فعال' : 'غیرفعال',
            $person->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A1:X1' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}