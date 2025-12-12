<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'sujet',
        'type',
        'message',
        'lu',
    ];

    protected $casts = [
        'lu' => 'boolean',
    ];

    public function scopeUnread($query)
    {
        return $query->where('lu', false);
    }

    public function markAsRead()
    {
        $this->update(['lu' => true]);
    }
}
