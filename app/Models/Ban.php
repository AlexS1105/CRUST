<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $guarded = [];

    protected $casts = [
        'expires' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function by()
    {
        return $this->belongsTo(User::class, 'banned_by');
    }
}
