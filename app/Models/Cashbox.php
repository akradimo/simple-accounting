<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cashbox extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'responsible_person_id',
        'balance',
        'min_balance',
        'max_balance',
        'description',
        'is_active'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'min_balance' => 'decimal:2',
        'max_balance' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function responsiblePerson()
    {
        return $this->belongsTo(Person::class, 'responsible_person_id');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowBalance($query)
    {
        return $query->whereRaw('balance <= min_balance');
    }

    public function scopeHighBalance($query)
    {
        return $query->whereRaw('balance >= max_balance');
    }

    // Methods
    public function updateBalance()
    {
        $credits = $this->transactions()->credit()->sum('amount');
        $debits = $this->transactions()->debit()->sum('amount');
        
        $this->balance = $credits - $debits;
        $this->save();
    }

    public function deposit($amount, $description = null)
    {
        if ($this->max_balance > 0 && ($this->balance + $amount) > $this->max_balance) {
            throw new \Exception('مبلغ واریزی از حد مجاز بیشتر است');
        }

        $transaction = $this->transactions()->create([
            'type' => 'credit',
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => now()
        ]);

        $this->updateBalance();
        return $transaction;
    }

    public function withdraw($amount, $description = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('موجودی ناکافی');
        }

        if (($this->balance - $amount) < $this->min_balance) {
            throw new \Exception('موجودی از حداقل مجاز کمتر می‌شود');
        }

        $transaction = $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => now()
        ]);

        $this->updateBalance();
        return $transaction;
    }

    public function needsReplenishment()
    {
        return $this->balance <= $this->min_balance;
    }

    public function needsWithdrawal()
    {
        return $this->max_balance > 0 && $this->balance >= $this->max_balance;
    }
}