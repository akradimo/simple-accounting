<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'person_id',
        'type',
        'amount',
        'date',
        'description'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime'
    ];

    // رابطه با شخص
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}