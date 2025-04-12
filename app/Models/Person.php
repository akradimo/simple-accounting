<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'people';

    protected $fillable = [
        'code',
        'type',
        'title',
        'first_name',
        'last_name',
        'display_name',
        'company_name',
        'national_code',
        'economic_code',
        'registration_number',
        'mobile',
        'phone',
        'email',
        'website',
        'country',
        'state',
        'city',
        'address',
        'postal_code',
        'category_id',
        'is_customer',
        'is_supplier',
        'is_employee',
        'is_shareholder',
        'is_active',
        'credit_limit',
        'opening_balance',
        'description',
        'image'
    ];

    protected $casts = [
        'is_customer' => 'boolean',
        'is_supplier' => 'boolean',
        'is_employee' => 'boolean',
        'is_shareholder' => 'boolean',
        'is_active' => 'boolean',
        'credit_limit' => 'decimal:0',
        'opening_balance' => 'decimal:0',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($person) {
            if ($person->image) {
                Storage::disk('public')->delete($person->image);
            }
            $person->bankAccounts()->delete();
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(PersonCategory::class, 'category_id');
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Accessors & Mutators
    public function getFullNameAttribute()
    {
        if ($this->type === 'individual') {
            return trim($this->title . ' ' . $this->first_name . ' ' . $this->last_name);
        }
        return $this->company_name;
    }

    public function getDisplayNameAttribute($value)
    {
        return $value ?: $this->full_name;
    }

    public function getBalanceAttribute()
    {
        return $this->opening_balance + $this->transactions()->sum('amount');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeCustomers($query)
    {
        return $query->where('is_customer', true);
    }

    public function scopeSuppliers($query)
    {
        return $query->where('is_supplier', true);
    }

    public function scopeEmployees($query)
    {
        return $query->where('is_employee', true);
    }

    public function scopeShareholders($query)
    {
        return $query->where('is_shareholder', true);
    }

    // Methods
    public function hasTransactions()
    {
        return $this->transactions()->exists();
    }

    public function updateBalance()
    {
        $this->balance = $this->opening_balance + $this->transactions()->sum('amount');
        $this->save();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }
}