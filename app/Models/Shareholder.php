<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shareholder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'person_id',
        'shares_count',
        'share_percentage',
        'investment_amount',
        'start_date',
        'end_date',
        'status'
    ];

    protected $dates = ['start_date', 'end_date'];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}