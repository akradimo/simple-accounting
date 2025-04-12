<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PersonCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'person_categories';

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
        'order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationships
    public function persons()
    {
        return $this->hasMany(Person::class, 'category_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('name');
    }

    // Methods
    public function canDelete()
    {
        return !$this->persons()->exists();
    }
}