<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number',
        'date',
        'project_id',
        'description',
        'currency',
        'person_id',
        'amount',
        'is_active',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
        'status' => 'boolean'
    ];

    // روابط
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function items()
    {
        return $this->hasMany(ReceiptItem::class);
    }

    public function payments()
    {
        return $this->hasMany(ReceiptPayment::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // اسکوپ‌ها
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePaid($query)
    {
        return $query->where('status', true);
    }

    public function scopeUnpaid($query)
    {
        return $query->where('status', false);
    }

    // متدها
    public function getTotalPaidAmount()
    {
        return $this->payments()->sum('amount');
    }

    public function getRemainingAmount()
    {
        return $this->amount - $this->getTotalPaidAmount();
    }

    public function isPaid()
    {
        return $this->getTotalPaidAmount() >= $this->amount;
    }

    public function markAsPaid()
    {
        $this->status = true;
        $this->save();
    }

    public function markAsUnpaid()
    {
        $this->status = false;
        $this->save();
    }

    // This automatically updates status when payments change
    public function updatePaymentStatus()
    {
        $this->status = $this->isPaid();
        $this->save();
    }
}