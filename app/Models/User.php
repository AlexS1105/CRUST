<?php

namespace App\Models;

use App\Enums\CharacterStatus;
use App\Traits\Searchable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $login
 * @property string $discord_tag
 * @property string $discord_id
 * @property string $discord_private_channel_id
 * @property string $password
 * @property bool $discord_notify
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $verified
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Account> $accounts
 * @property-read int|null $accounts_count
 * @property-read Ban|null $ban
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Character> $characters
 * @property-read int|null $characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\App\Models\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Ban> $issuedBans
 * @property-read int|null $issued_bans_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<EstitenceLog> $issuedEstitence
 * @property-read int|null $issued_estitence_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|array<\Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<Character> $registrationCharacters
 * @property-read int|null $registration_characters_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|array<\Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User search($search, $field = 'name')
 * @method static \Illuminate\Database\Eloquent\Builder|User sortable($defaultParameters = null)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordPrivateChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDiscordTag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLogin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereVerified($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rumor> $rumors
 * @property-read int|null $rumors_count
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sortable, HasRoles, CanResetPassword, Searchable;

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

    public function owns(Character $character)
    {
        return $this->is($character->user);
    }

    public function registers(Character $character)
    {
        return $this->is($character->registrar) && $character->status !== CharacterStatus::Approved;
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

    public function issuedEstitence()
    {
        return $this->hasMany(EstitenceLog::class, 'issued_by');
    }

    public function rumors()
    {
        return $this->hasMany(Rumor::class);
    }

    public function routeNotificationForDiscord()
    {
        return $this->discord_private_channel_id;
    }

    public function isBanned(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->ban !== null && now()->lessThan($this->ban->expires)
        );
    }

    public function canRumor(): Attribute
    {
        return Attribute::make(
            get: function () {
                $lastWeek = now()->subWeek();
                $createdRumors = $this->rumors()->where('created_at', '>=', $lastWeek)->count();

                if ($createdRumors < 5) {
                    return true;
                }

                $receivedRumors = $this->characters()
                    ->withCount([
                        'rumors' => function ($query) use ($lastWeek) {
                            $query->where('created_at', '>=', $lastWeek);
                        },
                    ])
                    ->get()
                    ->sum('rumors_count');

                return $createdRumors - $receivedRumors < 5;
            },
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
