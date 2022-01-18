<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $connection = 'mongodb2';

    protected $attributes = [
        'skills' => [
            'fitness'       => 3,
            'perception'    => 3,
            'agility'       => 3,
            'coordination'  => 3,
            'ingenuity'     => 3,
            'tech'          => 1,
            'magic'         => 1,
            'charisma'      => 3,
            'composure'     => 3
        ],
        'crafts' => [
            'arc' => 0,
            'mys' => 0,
            'enc' => 0,
            'alc' => 0,
            'eng' => 0,
            'mnf' => 0,
            'inf' => 0,
            'chm' => 0,
            'smt' => 0
        ],
    ];

    public function hasAnyCrafts()
    {
        return array_sum($this->crafts) > 0;
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'character', 'login');
    }
}
