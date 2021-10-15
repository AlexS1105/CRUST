<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CharacterController;
use App\Models\Character;
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
    Route::get('/character/create', [CharacterController::class, 'create'])->name('characters.create');
    Route::post('/character', [CharacterController::class, 'store'])->name('characters.store');
    Route::get('/character/{character:login}', [CharacterController::class, 'show'])->name('characters.show');
    Route::get('/character/{character:login}/edit', [CharacterController::class, 'edit'])->name('characters.edit');
    Route::patch('/character/{character:login}', [CharacterController::class, 'update'])->name('characters.update');
    Route::delete('/character/{character:login}', [CharacterController::class, 'destroy'])->name('characters.destroy');

    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');

    Route::post('/character/{character:login}/send', [ApplicationController::class, 'send'])->name('applications.send');
    Route::post('/character/{character:login}/cancel', [ApplicationController::class, 'cancel'])->name('applications.cancel');
    Route::post('/character/{character:login}/takeForApproval', [ApplicationController::class, 'takeForApproval'])->name('applications.takeForApproval');
    Route::post('/character/{character:login}/cancelApproval', [ApplicationController::class, 'cancelApproval'])->name('applications.cancelApproval');
    Route::post('/character/{character:login}/approve', [ApplicationController::class, 'approve'])->name('applications.approve');
    Route::post('/character/{character:login}/reapproval', [ApplicationController::class, 'reapproval'])->name('applications.reapproval');
});

require __DIR__.'/auth.php';
