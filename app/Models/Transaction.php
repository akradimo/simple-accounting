<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'type',
        'amount',
        'description',
        'reference_id',
        'reference_type',
        'person_id',
        'account_id',
        'payment_method',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime'
    ];

    // نوع تراکنش‌ها
    const TYPE_INCOME = 'income';          // درآمد
    const TYPE_EXPENSE = 'expense';        // هزینه
    const TYPE_TRANSFER = 'transfer';      // انتقال
    const TYPE_PAYMENT = 'payment';        // پرداخت
    const TYPE_RECEIPT = 'receipt';        // دریافت

    // روش‌های پرداخت
    const METHOD_CASH = 'cash';            // نقدی
    const METHOD_CARD = 'card';            // کارت
    const METHOD_CHEQUE = 'cheque';        // چک
    const METHOD_DEPOSIT = 'deposit';      // واریز
    const METHOD_ONLINE = 'online';        // آنلاین

    // وضعیت‌ها
    const STATUS_PENDING = 'pending';      // در انتظار
    const STATUS_COMPLETED = 'completed';  // تکمیل شده
    const STATUS_FAILED = 'failed';        // ناموفق
    const STATUS_CANCELLED = 'cancelled';  // لغو شده
    const STATUS_RETURNED = 'returned';    // برگشت خورده

    /**
     * ارتباط با شخص
     */
    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    /**
     * ارتباط با حساب
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * ارتباط با مرجع (مورفیک)
     */
    public function reference()
    {
        return $this->morphTo();
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
     * محاسبه مانده حساب
     */
    public function calculateBalance()
    {
        $amount = $this->amount;
        
        if (in_array($this->type, [self::TYPE_EXPENSE, self::TYPE_PAYMENT])) {
            $amount = -$amount;
        }
        
        return $amount;
    }

    /**
     * دریافت لیست روش‌های پرداخت
     */
    public static function getPaymentMethods()
    {
        return [
            self::METHOD_CASH => 'نقدی',
            self::METHOD_CARD => 'کارت',
            self::METHOD_CHEQUE => 'چک',
            self::METHOD_DEPOSIT => 'واریز',
            self::METHOD_ONLINE => 'آنلاین',
        ];
    }

    /**
     * دریافت لیست انواع تراکنش
     */
    public static function getTransactionTypes()
    {
        return [
            self::TYPE_INCOME => 'درآمد',
            self::TYPE_EXPENSE => 'هزینه',
            self::TYPE_TRANSFER => 'انتقال',
            self::TYPE_PAYMENT => 'پرداخت',
            self::TYPE_RECEIPT => 'دریافت',
        ];
    }

    /**
     * دریافت لیست وضعیت‌ها
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'در انتظار',
            self::STATUS_COMPLETED => 'تکمیل شده',
            self::STATUS_FAILED => 'ناموفق',
            self::STATUS_CANCELLED => 'لغو شده',
            self::STATUS_RETURNED => 'برگشت خورده',
        ];
    }

    /**
     * اسکوپ برای فیلتر بر اساس نوع تراکنش
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
     * اسکوپ برای فیلتر بر اساس روش پرداخت
     */
    public function scopeWithPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * اسکوپ برای فیلتر بر اساس بازه زمانی
     */
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('date', [$start, $end]);
    }
}