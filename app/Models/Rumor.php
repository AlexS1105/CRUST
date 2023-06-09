<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rumor extends Model
{
    use HasFactory;

    protected $fillable = [
        'tide',
        'text',
        'user_id',
    ];

    protected $casts = [
        'tide' => \App\Enums\Tide::class,
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActual($query)
    {
        return $query->limit(5);
    }
}
