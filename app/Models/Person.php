<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'company',
        'national_id',
        'economic_code',
        'registration_number',
        'phone',
        'mobile',
        'email',
        'website',
        'province',
        'city',
        'address',
        'postal_code',
        'description',
        'credit_limit',
        'payment_deadline',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_deadline' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // انواع شخص
    const TYPE_CUSTOMER = 'customer';       // مشتری
    const TYPE_SUPPLIER = 'supplier';       // تامین کننده
    const TYPE_EMPLOYEE = 'employee';       // کارمند
    const TYPE_OTHER = 'other';            // سایر

    // وضعیت‌ها
    const STATUS_ACTIVE = 'active';         // فعال
    const STATUS_INACTIVE = 'inactive';     // غیرفعال
    const STATUS_BLOCKED = 'blocked';       // مسدود

    /**
     * ارتباط با تراکنش‌ها
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * ارتباط با فاکتورهای فروش
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * ارتباط با فاکتورهای خرید
     */
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * ارتباط با کاربر ایجاد کننده
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * ارتباط با کاربر ویرایش کننده
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * محاسبه مانده حساب شخص
     */
    public function calculateBalance()
    {
        $receipts = $this->transactions()
            ->whereIn('type', [Transaction::TYPE_RECEIPT, Transaction::TYPE_INCOME])
            ->sum('amount');

        $payments = $this->transactions()
            ->whereIn('type', [Transaction::TYPE_PAYMENT, Transaction::TYPE_EXPENSE])
            ->sum('amount');

        return $receipts - $payments;
    }

    /**
     * بررسی اعتبار مجاز
     */
    public function hasAvailableCredit($amount)
    {
        if ($this->credit_limit <= 0) {
            return true;
        }

        $currentBalance = $this->calculateBalance();
        return ($currentBalance + $amount) <= $this->credit_limit;
    }

    /**
     * دریافت لیست انواع شخص
     */
    public static function getTypes()
    {
        return [
            self::TYPE_CUSTOMER => 'مشتری',
            self::TYPE_SUPPLIER => 'تامین کننده',
            self::TYPE_EMPLOYEE => 'کارمند',
            self::TYPE_OTHER => 'سایر',
        ];
    }

    /**
     * دریافت لیست وضعیت‌ها
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE => 'فعال',
            self::STATUS_INACTIVE => 'غیرفعال',
            self::STATUS_BLOCKED => 'مسدود',
        ];
    }

    /**
     * اسکوپ برای فیلتر بر اساس نوع شخص
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * اسکوپ برای فیلتر بر اساس وضعیت
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * اسکوپ برای جستجوی شخص
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
              ->orWhere('company', 'LIKE', "%{$term}%")
              ->orWhere('national_id', 'LIKE', "%{$term}%")
              ->orWhere('phone', 'LIKE', "%{$term}%")
              ->orWhere('mobile', 'LIKE', "%{$term}%")
              ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }

    /**
     * اسکوپ برای دریافت بدهکاران
     */
    public function scopeDebtors($query)
    {
        return $query->whereHas('transactions', function ($q) {
            $q->selectRaw('person_id, SUM(CASE 
                WHEN type IN (?, ?) THEN amount 
                WHEN type IN (?, ?) THEN -amount 
                ELSE 0 END) as balance', [
                Transaction::TYPE_RECEIPT,
                Transaction::TYPE_INCOME,
                Transaction::TYPE_PAYMENT,
                Transaction::TYPE_EXPENSE
            ])
            ->groupBy('person_id')
            ->having('balance', '<', 0);
        });
    }

    /**
     * اسکوپ برای دریافت بستانکاران
     */
    public function scopeCreditors($query)
    {
        return $query->whereHas('transactions', function ($q) {
            $q->selectRaw('person_id, SUM(CASE 
                WHEN type IN (?, ?) THEN amount 
                WHEN type IN (?, ?) THEN -amount 
                ELSE 0 END) as balance', [
                Transaction::TYPE_RECEIPT,
                Transaction::TYPE_INCOME,
                Transaction::TYPE_PAYMENT,
                Transaction::TYPE_EXPENSE
            ])
            ->groupBy('person_id')
            ->having('balance', '>', 0);
        });
    }
}