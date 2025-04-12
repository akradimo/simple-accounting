<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'barcode',
        'name',
        'brand',
        'model',
        'unit',
        'purchase_price',
        'sale_price',
        'min_quantity',
        'current_quantity',
        'description',
        'is_active'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'min_quantity' => 'integer',
        'current_quantity' => 'integer',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function saleItems()
    {
        return $this->morphMany(SaleItem::class, 'itemable');
    }

    public function purchaseItems()
    {
        return $this->morphMany(PurchaseItem::class, 'itemable');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('current_quantity <= min_quantity');
    }

    // Methods
    public function updateStock($quantity, $type = 'add')
    {
        if ($type === 'add') {
            $this->current_quantity += $quantity;
        } else {
            $this->current_quantity -= $quantity;
        }
        $this->save();
    }

    public function getProfit()
    {
        return $this->sale_price - $this->purchase_price;
    }

    public function getProfitPercentage()
    {
        if ($this->purchase_price > 0) {
            return ($this->getProfit() / $this->purchase_price) * 100;
        }
        return 0;
    }

    public function getTotalValue()
    {
        return $this->current_quantity * $this->purchase_price;
    }

    public function getStockStatus()
    {
        if ($this->current_quantity <= 0) {
            return 'تمام شده';
        } elseif ($this->current_quantity <= $this->min_quantity) {
            return 'کم';
        }
        return 'موجود';
    }
}