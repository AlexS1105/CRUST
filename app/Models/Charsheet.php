<?php

namespace App\Models;

use App\Enums\CharacterStat;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Jenssegers\Mongodb\Eloquent\Model;

class Charsheet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $connection = 'mongodb2';

    protected $attributes = [
        'stats' => [
            'strength' => 1,
            'endurance' => 1,
            'perception' => 1,
            'agility' => 1,
            'determination' => 1,
            'erudition' => 1,
            'will' => 1,
            'potential' => 1,
        ],
        'crafts' => [
            'arc' => 0,
            'mys' => 0,
            'wiz' => 0,
            'mnf' => 0,
            'eng' => 0,
            'gun' => 0,
            'chm' => 0,
            'smt' => 0,
            'bld' => 0,
            'med' => 0,
        ],
    ];

    public function hasAnyCrafts()
    {
        return array_sum($this->crafts) > 0;
    }

    public function bodyStats(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Arr::only($this->stats, CharacterStat::getBodyStats());
            }
        );
    }

    public function bodySum(): Attribute
    {
        return Attribute::make(
            get: function () {
                return CharacterStat::getSum($this->body_stats);
            }
        );
    }

    public function essenceStats(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Arr::only($this->stats, CharacterStat::getEssenceStats());
            }
        );
    }

    public function essenceSum(): Attribute
    {
        return Attribute::make(
            get: function () {
                return CharacterStat::getSum($this->essence_stats);
            }
        );
    }

    public function statsSum(): Attribute
    {
        return Attribute::make(
            get: function () {
                return CharacterStat::getSum($this->stats);
            }
        );
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'character', 'login');
    }
}
