<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return "https://discord.com/channels/$guildId/$this->id/";
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function($ticket) {
            info('Ticket created', [
                'user' => auth()->user()->login,
                'character' => $ticket->character->login
            ]);
        });

        static::deleted(function($ticket) {
            info('Ticket deleted', [
                'user' => auth()->user()->login,
                'character' => $ticket->character->login
            ]);
        });
    }
}
