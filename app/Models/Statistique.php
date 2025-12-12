<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'valeur',
        'icone',
        'description',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'actif' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre');
    }
}
