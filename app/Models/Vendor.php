<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'vendor_code',
        'credit_limit',
        'payment_terms',
        'status'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}