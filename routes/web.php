<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AllCharactersController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharsheetController;
use App\Http\Controllers\CharsheetSettingsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\MinecraftAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth', MinecraftAuthController::class)->name('minecraft.auth');

Route::middleware('auth')->group(function() {
    Route::get('/discord-invite', function() {
        return redirect(config('services.discord.invite'));
    })->name('discord.invite');

    Route::get('/discord-verify', function() {
        return view('discord.index');
    })->name('discord.verify');

    Route::middleware('verified')->group(function() {
        Route::get('/', [CharacterController::class, 'index'])
            ->name('characters.index');

        Route::get('/characters', AllCharactersController::class)->name('characters.all');

        Route::get('/wikiauth', WikiController::class)->name('wiki.index');

        Route::delete('/characters/{character:login}/force', [CharacterController::class, 'forceDestroy'])
            ->name('characters.forceDestroy')
            ->middleware('can:forceDelete,character');

        Route::patch('/characters/{character:login}/restore', [CharacterController::class, 'restore'])
            ->name('characters.restore')
            ->middleware('can:restore,character');

        Route::get('/characters/{character:login}/charsheet', [CharsheetController::class, 'edit'])
            ->name('characters.charsheet.edit')
            ->middleware('can:update,character');

        Route::patch('/characters/{character:login}/charsheet', [CharsheetController::class, 'update'])
            ->name('characters.charsheet.update')
            ->middleware('can:update,character');

        Route::resource('characters', CharacterController::class)
            ->except('index')
            ->scoped([
                'character' => 'login'
            ]);

        Route::get('/applications', [ApplicationController::class, 'index'])
            ->middleware('can:viewApplications,App\Models\Character')
            ->name('applications.index');

        Route::patch('/characters/{character:login}/send', [ApplicationController::class, 'send'])
            ->name('applications.send')
            ->middleware('can:send,character');

        Route::patch('/characters/{character:login}/cancel', [ApplicationController::class, 'cancel'])
            ->name('applications.cancel')
            ->middleware('can:cancel,character');

        Route::patch('/characters/{character:login}/takeForApproval', [ApplicationController::class, 'takeForApproval'])
            ->name('applications.takeForApproval')
            ->middleware('can:takeForApproval,character');

        Route::patch('/characters/{character:login}/cancelApproval', [ApplicationController::class, 'cancelApproval'])
            ->name('applications.cancelApproval')
            ->middleware('can:cancelApproval,character');

        Route::patch('/characters/{character:login}/requestChanges', [ApplicationController::class, 'requestChanges'])
            ->name('applications.requestChanges')
            ->middleware('can:requestChanges,character');

        Route::patch('/characters/{character:login}/requestApproval', [ApplicationController::class, 'requestApproval'])
            ->name('applications.requestApproval')
            ->middleware('can:requestApproval,character');

        Route::patch('/characters/{character:login}/approve', [ApplicationController::class, 'approve'])
            ->name('applications.approve')
            ->middleware('can:approve,character');

        Route::patch('/characters/{character:login}/reapproval', [ApplicationController::class, 'reapproval'])
            ->name('applications.reapproval')
            ->middleware('can:reapproval,character');

        Route::resource('users', UserController::class)
            ->except(['create', 'store']);

        Route::resource('users.ban', BanController::class)
            ->only(['create', 'store', 'destroy'])
            ->shallow();

        Route::resource('users.accounts', AccountController::class)
            ->except(['show', 'edit', 'update'])
            ->shallow();

        Route::get('settings', SettingsController::class)
            ->name('settings.index')
            ->middleware('can:settings');

        Route::get('settings/general', [GeneralSettingsController::class, 'show'])
            ->name('settings.general.show')
            ->middleware('can:settings');

        Route::patch('settings/general', [GeneralSettingsController::class, 'update'])
            ->name('settings.general.update')
            ->middleware('can:settings');

        Route::get('settings/charsheet', [CharsheetSettingsController::class, 'show'])
            ->name('settings.charsheet.show')
            ->middleware('can:settings');

        Route::patch('settings/general', [CharsheetSettingsController::class, 'update'])
            ->name('settings.charsheet.update')
            ->middleware('can:settings');
    });
});

require __DIR__.'/auth.php';
