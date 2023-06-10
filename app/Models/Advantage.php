<?php

namespace App\Models;

use App\Enums\CharacterTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'level',
        'is_penalty',
        'titled',
    ];

    public function visibleFor(Character $character, int $bonus)
    {
        return ($bonus <= $this->level && $this->is_penalty
                || $bonus >= $this->level && !$this->is_penalty)
            && ($this->titled && $character->title != CharacterTitle::None
                || !$this->titled);
    }
}
