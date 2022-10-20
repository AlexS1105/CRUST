<?php

namespace App\Models;

use App\Enums\FateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fate
 *
 * @property int $id
 * @property int $character_id
 * @property string $text
 * @property mixed $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Fate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fate whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Fate extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'type',
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function isDual()
    {
        return FateType::all($this->type, FateType::Ambition, FateType::Flaw);
    }

    public function isOnetime()
    {
        return ! FateType::on($this->type, FateType::Continuous);
    }

    public function isAmbition()
    {
        return FateType::on($this->type, FateType::Ambition);
    }

    public function isFlaw()
    {
        return FateType::on($this->type, FateType::Flaw);
    }
}
