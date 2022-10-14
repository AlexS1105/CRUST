<?php

namespace App\Models;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, HasRoles, CanResetPassword;

    public $sortable = [
        'login',
        'discord_tag',
        'created_at',
    ];

    protected $fillable = [
        'login',
        'discord_tag',
        'discord_id',
        'discord_private_channel_id',
        'password',
        'discord_notify',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'discord_notify' => 'boolean',
        'discord_id' => 'string',
        'discord_private_channel_id' => 'string',
    ];

    protected $with = ['ban'];

    public function owns(Character $character)
    {
        return $this->id === $character->user->id;
    }

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

    public function issuedVox()
    {
        return $this->hasMany(VoxLog::class, 'issued_by');
    }

    public function routeNotificationForDiscord()
    {
        return $this->discord_private_channel_id;
    }

    public function isBanned(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ban != null && now()->lessThan($this->ban->expires)
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (User $user) {
            $user->characters->map(function ($character) {
                if ($character->charsheet) {
                    $character->charsheet->delete();
                }
            });
        });

        static::created(function ($user) {
            info('User created', [
                'auth_user' => auth()->user() !== null ? auth()->user()->login : 'null',
            ]);
        });

        static::updated(function ($user) {
            info('User updated', [
                'auth_user' => auth()->user() !== null ? auth()->user()->login : 'null',
                'user' => $user->login,
            ]);
        });

        static::deleted(function ($user) {
            info('User deleted', [
                'auth_user' => auth()->user() !== null ? auth()->user()->login : 'null',
                'user' => $user->login,
            ]);
        });
    }
}
