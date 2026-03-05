<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'company',
        'photo',
        'content',
        'featured',
        'active',
        'ordre',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'active'   => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre')->orderBy('created_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
