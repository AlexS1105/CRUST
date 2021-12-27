<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $connection = 'mongodb2';

    protected $attributes = [
        'special_stats' => [
            'skill_points'  => 36,
            'vox_points'    => 0
        ],
        'skills' => [
            'fitness'       => 0,
            'perception'    => 0,
            'agility'       => 0,
            'coordination'  => 0,
            'ingenuity'     => 0,
            'tech'          => 0,
            'magic'         => 0,
            'charisma'      => 0,
            'composure'     => 0
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
