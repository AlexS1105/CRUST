<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $guarded = [];

    static public function getCost($curValue, $inc)
    {
        $costPerPoint = 2;
        $costSum = 0;

        for ($i = $curValue; $i < $curValue + $inc; $i++) { 
            $costSum += $i >= 5 ? $costPerPoint * 2 : $costPerPoint;
        }

        return $costSum;
    }

    public function increaseFromSphere(Sphere $sphere, $data)
    {
        $this->level += $data['value'];
        $this->save();

        $sphere->value -= $this->getCost($this->value, $data['value']);
        $sphere->save();
    }

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}
