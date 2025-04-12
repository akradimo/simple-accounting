<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceiptItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'receipt_id',
        'person_id',
        'amount',
        'description'
    ];

    protected $casts = [
        'amount' => 'decimal:2'
    ];

    // روابط
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}