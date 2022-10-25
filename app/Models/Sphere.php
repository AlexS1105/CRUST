<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sphere
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $value
 * @property int $character_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Character $character
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Idea> $ideas
 * @property-read int|null $ideas_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sphere whereValue($value)
 *
 * @mixin \Eloquent
 */
class Sphere extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }
}
