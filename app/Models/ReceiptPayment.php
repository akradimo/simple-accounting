<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'receipt_id',
        'type',
        'amount',
        'reference',
        'details'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'details' => 'json'
    ];

    // روابط
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($payment) {
            $payment->receipt->updatePaymentStatus();
        });

        static::updated(function ($payment) {
            $payment->receipt->updatePaymentStatus();
        });

        static::deleted(function ($payment) {
            $payment->receipt->updatePaymentStatus();
        });
    }
}