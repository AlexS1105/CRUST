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
        'estitence' => 0,
    ];

    public function bodyStats(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Arr::only($this->stats, Arr::map(CharacterStat::getBodyStats(), fn ($stat) => $stat->value));
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
                return Arr::only($this->stats, Arr::map(CharacterStat::getEssenceStats(), fn ($stat) => $stat->value));
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
}
