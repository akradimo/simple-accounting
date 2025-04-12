<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommonDescription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'type',
        'group',
        'is_active',
        'usage_count',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'usage_count' => 'integer'
    ];

    // روابط
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('usage_count', 'desc');
    }

    // متدها
    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function toggleStatus()
    {
        $this->update(['is_active' => !$this->is_active]);
    }
}