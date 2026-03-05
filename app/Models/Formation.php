<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'slug',
        'description',
        'contenu',
        'image_url',
        'prix',
        'prix_barre',
        'badge',
        'couleur_badge',
        'note',
        'niveau',
        'duree',
        'lien_achat',
        'actif',
        'ordre',
    ];

    protected $casts = [
        'prix' => 'decimal:2',
        'prix_barre' => 'decimal:2',
        'note' => 'decimal:1',
        'actif' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($formation) {
            if (empty($formation->slug)) {
                $formation->slug = Str::slug($formation->nom);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('ordre');
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->prix_barre && $this->prix_barre > $this->prix) {
            return round((($this->prix_barre - $this->prix) / $this->prix_barre) * 100);
        }
        return 0;
    }
}
