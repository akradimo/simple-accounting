<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'itemable_type',
        'itemable_id',
        'quantity',
        'unit_price',
        'discount_percentage',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'total_amount',
        'description'
    ];

    protected $casts = [
        'quantity' => 'decimal:3',
        'unit_price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_percentage' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2'
    ];

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }

    // Methods
    public function calculateTotals()
    {
        $subtotal = $this->quantity * $this->unit_price;
        
        $this->discount_amount = ($subtotal * $this->discount_percentage) / 100;
        $this->tax_amount = (($subtotal - $this->discount_amount) * $this->tax_percentage) / 100;
        
        $this->total_amount = $subtotal - $this->discount_amount + $this->tax_amount;
        $this->save();

        // محاسبه مجدد جمع کل فاکتور
        $this->purchase->calculateTotals();
    }

    public function updateProductPrice()
    {
        if ($this->itemable_type === Product::class) {
            $product = $this->itemable;
            // بروزرسانی قیمت خرید محصول
            $product->purchase_price = $this->unit_price;
            $product->save();
        }
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($item) {
            $item->calculateTotals();
        });

        static::updated(function ($item) {
            $item->calculateTotals();
        });

        static::deleted(function ($item) {
            $item->purchase->calculateTotals();
        });
    }
}