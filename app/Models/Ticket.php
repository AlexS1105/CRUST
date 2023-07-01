<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property int $character_id
 * @property string $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read Character $character
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCharacterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function link()
    {
        $guildId = config('services.discord.tickets.guild_id');

        return "https://discord.com/channels/{$guildId}/{$this->id}/";
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($ticket) {
            info('Ticket created', [
                'character' => $ticket->character->login,
            ]);
        });

        static::deleted(function ($ticket) {
            info('Ticket deleted', [
                'character' => $ticket->character->login,
            ]);
        });
    }
}
