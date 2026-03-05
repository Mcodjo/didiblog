<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'source',
        'actif',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }
}
