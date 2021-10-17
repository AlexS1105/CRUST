<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CharacterController;
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

    Route::get('/character/create', [CharacterController::class, 'create'])
        ->name('characters.create')
        ->middleware('can:create,App\Models\Character');

    Route::post('/character', [CharacterController::class, 'store'])
        ->name('characters.store')
        ->middleware('can:create,App\Models\Character');

    Route::get('/character/{character:login}', [CharacterController::class, 'show'])
        ->name('characters.show')
        ->middleware('can:view,character');

    Route::get('/character/{character:login}/edit', [CharacterController::class, 'edit'])
        ->name('characters.edit')
        ->middleware('can:edit,character');

    Route::patch('/character/{character:login}', [CharacterController::class, 'update'])
        ->name('characters.update')
        ->middleware('can:edit,character');

    Route::delete('/character/{character:login}', [CharacterController::class, 'destroy'])
        ->name('characters.destroy')
        ->middleware('can:delete,character');

    Route::get('/applications', [ApplicationController::class, 'index'])
        ->middleware('can:viewApplications,App\Models\Character')
        ->name('applications.index');

    Route::post('/character/{character:login}/send', [ApplicationController::class, 'send'])
        ->name('applications.send')
        ->middleware('can:send,character');

    Route::post('/character/{character:login}/cancel', [ApplicationController::class, 'cancel'])
        ->name('applications.cancel')
        ->middleware('can:cancel,character');

    Route::post('/character/{character:login}/takeForApproval', [ApplicationController::class, 'takeForApproval'])
        ->name('applications.takeForApproval')
        ->middleware('can:takeForApproval,character');

    Route::post('/character/{character:login}/cancelApproval', [ApplicationController::class, 'cancelApproval'])
        ->name('applications.cancelApproval')
        ->middleware('can:cancelApproval,character');

    Route::post('/character/{character:login}/approve', [ApplicationController::class, 'approve'])
        ->name('applications.approve')
        ->middleware('can:approve,character');

    Route::post('/character/{character:login}/reapproval', [ApplicationController::class, 'reapproval'])
        ->name('applications.reapproval')
        ->middleware('can:reapproval,character');

    Route::resource('users', UserController::class)
        ->except(['create', 'store']);
});

require __DIR__.'/auth.php';
