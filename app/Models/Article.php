<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'slug',
        'extrait',
        'contenu',
        'image_url',
        'auteur',
        'temps_lecture',
        'categorie_id',
        'actif',
        'featured',
        'vues',
    ];

    protected $casts = [
        'actif' => 'boolean',
        'featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->titre);
            }
        });
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('status', 'approved');
    }

    public function scopeActive($query)
    {
        return $query->where('actif', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('titre', 'like', "%{$search}%")
              ->orWhere('extrait', 'like', "%{$search}%")
              ->orWhere('contenu', 'like', "%{$search}%");
        });
    }

    public function incrementViews()
    {
        $this->increment('vues');
    }
}
