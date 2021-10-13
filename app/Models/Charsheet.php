<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $connection = 'mongodb2';

    public function character() {
        return $this->hasOne(Character::class, 'character', 'login');
    }
}
