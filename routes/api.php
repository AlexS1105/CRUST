<?php

use App\Http\Controllers\DiscordController;
use Illuminate\Support\Facades\Route;

Route::patch('/unverify-user', [DiscordController::class, 'unverifyUser'])
    ->middleware('auth.apikey')
    ->name('discord.unverify');
