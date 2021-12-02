<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, HasRoles, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'login',
        'discord_tag',
        'discord_id',
        'discord_private_channel_id',
        'password',
        'discord_notify'
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

    public $sortable = [
        'login',
        'discord_tag',
        'created_at'
    ];

    protected $casts = [
        'discord_notify' => 'boolean',
        'discord_id' => 'string',
        'discord_private_channel_id' => 'string'
    ];

    protected $with = ['ban'];

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function registrationCharacters()
    {
        return $this->hasMany(Character::class, 'registrar_id');
    }

    public function ban()
    {
        return $this->hasOne(Ban::class);
    }

    public function issuedBans()
    {
        return $this->hasMany(Ban::class, 'banned_by');
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    protected static function boot()
    {
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
