<?php

namespace App\Models;

use App\Enums\FateType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
