<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CharacterStatus;

class Character extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => CharacterStatus::class,
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function registrar() {
        return $this->belongsTo(User::class, 'registrar_id');
    }
}
