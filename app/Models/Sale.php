<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'invoice_date',
        'due_date',
        'status',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'shipping_cost',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'notes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2'
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Person::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    // Scopes
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'confirmed')
            ->where('remaining_amount', '>', 0)
            ->whereDate('due_date', '<', Carbon::today());
    }

    // Methods
    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum('total_amount');
        
        $this->discount_amount = ($this->subtotal * $this->discount_percentage) / 100;
        $this->tax_amount = (($this->subtotal - $this->discount_amount) * $this->tax_percentage) / 100;
        
        $this->total_amount = $this->subtotal - $this->discount_amount + $this->tax_amount + $this->shipping_cost;
        $this->remaining_amount = $this->total_amount - $this->paid_amount;
        
        $this->save();
    }

    public function confirm()
    {
        if ($this->status !== 'draft') {
            throw new \Exception('فقط فاکتورهای پیش‌نویس قابل تایید هستند');
        }

        // کنترل موجودی
        foreach ($this->items as $item) {
            if ($item->itemable_type === Product::class) {
                $product = $item->itemable;
                if ($product->current_quantity < $item->quantity) {
                    throw new \Exception("موجودی {$product->name} کافی نیست");
                }
                $product->updateStock($item->quantity, 'subtract');
            }
        }

        $this->status = 'confirmed';
        $this->save();

        // ثبت سند حسابداری
        $this->createAccountingEntry();
    }

    public function cancel()
    {
        if ($this->status !== 'confirmed') {
            throw new \Exception('فقط فاکتورهای تایید شده قابل لغو هستند');
        }

        // برگشت موجودی
        foreach ($this->items as $item) {
            if ($item->itemable_type === Product::class) {
                $item->itemable->updateStock($item->quantity, 'add');
            }
        }

        $this->status = 'cancelled';
        $this->save();

        // برگشت سند حسابداری
        $this->reverseAccountingEntry();
    }

    public function addPayment($amount, $description = null)
    {
        if ($amount > $this->remaining_amount) {
            throw new \Exception('مبلغ پرداختی از مانده بیشتر است');
        }

        $this->paid_amount += $amount;
        $this->remaining_amount = $this->total_amount - $this->paid_amount;
        $this->save();

        // ثبت تراکنش
        return $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description ?: 'پرداخت فاکتور شماره ' . $this->invoice_number,
            'transaction_date' => now()
        ]);
    }

    protected function createAccountingEntry()
    {
        // کد مربوط به ثبت سند حسابداری
    }

    protected function reverseAccountingEntry()
    {
        // کد مربوط به برگشت سند حسابداری
    }
}