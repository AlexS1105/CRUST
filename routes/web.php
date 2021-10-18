<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth')->group(function() {
    Route::get('/', [CharacterController::class, 'index'])->name('characters.index');

    Route::delete('/characters/{character:login}/force', [CharacterController::class, 'forceDestroy'])
        ->name('characters.forceDestroy')
        ->middleware('can:forceDelete,character');

    Route::patch('/characters/{character:login}/restore', [CharacterController::class, 'restore'])
        ->name('characters.restore')
        ->middleware('can:restore,character');

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

    Route::patch('/characters/{character:login}/approve', [ApplicationController::class, 'approve'])
        ->name('applications.approve')
        ->middleware('can:approve,character');

    Route::patch('/characters/{character:login}/reapproval', [ApplicationController::class, 'reapproval'])
        ->name('applications.reapproval')
        ->middleware('can:reapproval,character');

    Route::resource('users', UserController::class)
        ->except(['create', 'store']);

    Route::get('settings', SettingsController::class)
        ->name('settings.index')
        ->middleware('can:settings');

    Route::get('settings/general', [GeneralSettingsController::class, 'show'])
        ->name('settings.general.show')
        ->middleware('can:settings');

    Route::patch('settings/general', [GeneralSettingsController::class, 'update'])
        ->name('settings.general.update')
        ->middleware('can:settings');
});

require __DIR__.'/auth.php';
