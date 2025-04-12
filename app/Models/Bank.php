<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bank extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'branch',
        'account_number',
        'card_number',
        'shaba',
        'balance',
        'description',
        'is_active'
    ];

    protected $casts = [
        'balance' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Relationships
    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'reference');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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

        $transaction = $this->transactions()->create([
            'type' => 'debit',
            'amount' => $amount,
            'description' => $description,
            'transaction_date' => now()
        ]);

        $this->updateBalance();
        return $transaction;
    }

    public function getTransactionHistory($startDate = null, $endDate = null)
    {
        $query = $this->transactions();

        if ($startDate) {
            $query->whereDate('transaction_date', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('transaction_date', '<=', $endDate);
        }

        return $query->orderBy('transaction_date', 'desc')->get();
    }
}