<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NarrativeCraft extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function charsheet()
    {
        return $this->belongsTo(Character::class);
    }
}
