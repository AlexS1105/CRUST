<?php

use App\Http\Controllers\DiscordController;
use Illuminate\Support\Facades\Route;

Route::patch('/unverify-user', [DiscordController::class, 'unverifyUser'])
    ->middleware('auth.apikey')
    ->name('discord.unverify');

// MediaWiki OAuth2.0 endpoints

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/login', AuthController::class);
