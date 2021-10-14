<?php

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
});

require __DIR__.'/auth.php';
