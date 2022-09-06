<?php

namespace App\Services;

use App\Models\Character;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class DiscordService
{
    public function getUserData($code, $redirect)
    {
        $accessData = Cache::remember('accessData'.$code, 604800, function() use($code, $redirect) {
            return $this->getAccessToken($code, $redirect);
        });

        $token = $accessData['access_token'];

        $userData = Cache::remember('userData'.$token, 604800, function() use($token) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$token
            ])->get('https://discordapp.com/api/users/@me');
            $response->throw();

            return json_decode($response->body(), true);
        });

        $userData['accessData'] = $accessData;

        return $userData;
    }

    public function getAccessToken($code, $redirect)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
        ])->asForm()->post(config('services.discord.api').'/oauth2/token', [
            'client_id' => config('services.discord.clientid'),
            'client_secret' => config('services.discord.secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect
        ]);
        $response->throw();

        $data = json_decode($response->body(), true);

        return $data;
    }

    public function createRegistrationTicket(Character $character)
    {
        if ($character->ticket) {
            throw new Exception('Character ticket already exists');
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token')
        ])->post(config('services.discord.tickets.api_url').'/ticket', [
            'guild_id' => config('services.discord.tickets.guild_id'),
            'user_id' => $character->user->discord_id,
            'registrar_id' => $character->registrar->discord_id,
            'category_id' => config('services.discord.tickets.category_id'),
            'topic' => "Регистрация $character->name"
        ]);
        $response->throw();

        if ($response->ok()) {
            $ticket = json_decode($response->body(), true);

            $character->ticket()->create([
                'id' => $ticket['id'],
                'character_id' => $character->id,
                'category_id' => config('services.discord.tickets.category_id')
            ]);
        }
    }

    public function deleteRegistrationTicket(Character $character)
    {
        if (!$character->ticket) {
            throw new Exception('Character has no ticket');
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token')
        ])->delete(config('services.discord.tickets.api_url').'/ticket', [
            'ticket_id' => strval($character->ticket->id)
        ]);
        $response->throw();

        if ($response->ok()) {
            $character->ticket->delete();
        }
    }

    public function verifyUser(User $user)
    {
        if ($user->verified) {
            return;
        }

        $response = Http::withHeaders([
            'Authenticate' => config('services.discord.token')
        ])->get(config('services.discord.tickets.api_url').'/has-user', [
            'id' => $user->discord_id
        ]);
        $response->throw();

        if ($response->ok()) {
            $found = json_decode($response->body(), true);
            if ($found) {
                $user->verified = true;
                $user->save();
            }
        }
    }
}
