<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CharacterStatus;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class Character extends Model
{
    use HasFactory, HybridRelations;

    protected $guarded = [];

    protected $casts = [
        'status' => CharacterStatus::class,
    ];

    public function getReference() {
        return asset('storage/characters/references/' . 
        (Storage::exists("public/characters/references/" . $this->login . ".png")
        ? $this->login : '_default') . '.png');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function registrar() {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function charsheet() {
        return $this->hasOne(Charsheet::class, 'character', 'login');
    }
}
