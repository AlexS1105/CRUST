<?php

namespace App\Services;

use App\Models\Character;
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
            $curl = curl_init('https://discordapp.com/api/users/@me');

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.$token
            ]);
            
            curl_close($curl);
    
            return json_decode(curl_exec($curl), true);
        });

        $userData['accessData'] = $accessData;

        return $userData;
    }

    public function getAccessToken($code, $redirect)
    {
        $curl = curl_init(config('services.discord.api').'/oauth2/token');

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, [
            'client_id' => config('services.discord.clientid'),
            'client_secret' => config('services.discord.secret'),
            'grant_type' => 'authorization_code',
            'code' => $code,
            'redirect_uri' => $redirect
        ]);

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type' => 'application/x-www-form-urlencoded'
        ]);

        $data = json_decode(curl_exec($curl), true);

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
            'registrar_id' => '167230144371490816',
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
            'ticket_id' => $character->ticket->id
        ]);
        $response->throw();

        if ($response->ok()) {
            $character->ticket->delete();
        }
    }
}
