<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'discord_tag',
        'discord_id',
        'discord_private_channel_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $sortable = [
        'name',
        'created_at'
    ];

    public function characters() {
        return $this->hasMany(Character::class);
    }

    public function registrationCharacters() {
        return $this->hasMany(Character::class, 'registrar_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function(User $user) {
            $user->characters->map(function($character) {
                if ($character->charsheet) {
                    $character->charsheet->delete();
                }
            });
        });
    }

    public function routeNotificationForDiscord()
    {
        return $this->discord_private_channel_id;
    }
}
