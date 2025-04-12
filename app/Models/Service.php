<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'unit',
        'price',
        'description',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
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

    // Methods
    public function getTotalSales($startDate = null, $endDate = null)
    {
        $query = $this->saleItems()
            ->whereHas('sale', function ($q) {
                $q->where('status', 'confirmed');
            });

        if ($startDate) {
            $query->whereHas('sale', function ($q) use ($startDate) {
                $q->whereDate('invoice_date', '>=', $startDate);
            });
        }

        if ($endDate) {
            $query->whereHas('sale', function ($q) use ($endDate) {
                $q->whereDate('invoice_date', '<=', $endDate);
            });
        }

        return $query->sum('total_amount');
    }
}