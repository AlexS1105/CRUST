<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Experience
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $level
 * @property int $character_id
 * @property int $native
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Character $character
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Experience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience query()
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereNative($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Experience whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Experience extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function increaseFromSphere(Sphere $sphere, $data)
    {
        $this->level += $data['value'];
        $this->save();

        $sphere->value -= $this->getCost($this->value, $data['value']);
        $sphere->save();
    }

    public static function getCost($curValue, $inc)
    {
        $costPerPoint = 2;
        $costSum = 0;

        for ($i = $curValue; $i < $curValue + $inc; $i++) {
            $costSum += $i >= 5 ? $costPerPoint * 2 : $costPerPoint;
        }

        return $costSum;
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
