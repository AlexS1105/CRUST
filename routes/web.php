<?php

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

Route::get('/', function () {
    return redirect()->route('characters');
})->middleware(['auth']);

Route::get('/characters', function () {
    return view('characters', [
        'characters' => auth()->user()->characters
    ]);
})->middleware(['auth'])->name('characters');

require __DIR__.'/auth.php';
