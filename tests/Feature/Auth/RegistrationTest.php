<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_discord_register_data_fetch()
    {
        Http::fake([
            config('services.discord.api').'/oauth2/token' => Http::response([
                'access_token' => 'TestAccessToken',
            ]),
            config('services.discord.api').'/users/@me' => Http::response([
                'id' => '1234567890',
                'username' => 'Test',
                'discriminator' => '1234',
            ]),
        ]);

        $response = $this->withViewErrors([])->get(route('register') . '?code=TestAuthCode');

        Http::assertSent(function ($request) {
            return $request->url() == config('services.discord.api').'/oauth2/token'
                && $request['code'] == 'TestAuthCode';
        });
        Http::assertSent(function ($request) {
            return $request->url() == config('services.discord.api').'/users/@me'
                && $request->hasHeader('Authorization', 'Bearer TestAccessToken');
        });

        $response->assertStatus(200);
        $response->assertSeeInOrder([
            'Test',
            'Test#1234',
            '1234567890',
        ]);
    }

    public function test_error_on_user_already_registered()
    {
        $user = User::factory()->create();
        Http::fake([
            config('services.discord.api').'/oauth2/token' => Http::response([
                'access_token' => 'TestAccessToken',
            ]),
            config('services.discord.api').'/users/@me' => Http::response([
                'id' => $user->discord_id,
                'username' => $user->login,
                'discriminator' => \Str::after($user->discord_tag, '#'),
            ]),
        ]);

        $response = $this->withViewErrors([])->get(route('register') . '?code=TestAuthCode');

        Http::assertSent(function ($request) {
            return $request->url() == config('services.discord.api').'/oauth2/token'
                && $request['code'] == 'TestAuthCode';
        });
        Http::assertSent(function ($request) {
            return $request->url() == config('services.discord.api').'/users/@me'
                && $request->hasHeader('Authorization', 'Bearer TestAccessToken');
        });

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['discord']);
    }

    public function test_discord_error_redirect()
    {
        Http::fake([
            config('services.discord.api').'/oauth2/token' => Http::response(400),
        ]);

        $response = $this->withViewErrors([])->get(route('register'));

        Http::assertSent(function ($request) {
            return $request->url() == config('services.discord.api').'/oauth2/token';
        });

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['discord']);
    }
}
