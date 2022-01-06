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
use App\Http\Controllers\PerkController;
use App\Http\Controllers\PerkListController;
use App\Http\Controllers\PerkVariantController;
use App\Http\Controllers\RaceTraitController;
use App\Http\Controllers\TraitListController;
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

Route::get('/perks', PerkListController::class)->name('perks.list');
Route::get('/traits', TraitListController::class)->name('traits.list');

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

        Route::middleware('can:settings')->group(function() {
            Route::get('settings', SettingsController::class)
                ->name('settings.index');

            Route::get('settings/general', [GeneralSettingsController::class, 'show'])
                ->name('settings.general.show');

            Route::patch('settings/general', [GeneralSettingsController::class, 'update'])
                ->name('settings.general.update');

            Route::get('settings/charsheet', [CharsheetSettingsController::class, 'show'])
                ->name('settings.charsheet.show');

            Route::patch('settings/charsheet', [CharsheetSettingsController::class, 'update'])
                ->name('settings.charsheet.update');

            Route::resource('settings/perks', PerkController::class)
                ->except(['show']);
 
            Route::resource('settings/perks/{perk}/variants', PerkVariantController::class)
                ->except(['index', 'show'])
                ->shallow()
                ->names([
                    'index' => 'perks.variants.index',
                    'store' => 'perks.variants.store',
                    'create' => 'perks.variants.create',
                    'update' => 'perks.variants.update',
                    'edit' => 'perks.variants.edit',
                    'destroy' => 'perks.variants.destroy'
                ]);

            Route::resource('settings/traits', RaceTraitController::class)
                ->except(['show']);
        });
    });
});

require __DIR__.'/auth.php';
