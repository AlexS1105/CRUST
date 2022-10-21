<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharsheetController;
use App\Http\Controllers\CharsheetSettingsController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MinecraftAuthController;
use App\Http\Controllers\NarrativeCraftController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\PerkVariantController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\SphereController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoxController;
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

Route::get('/perks', [PerkController::class, 'all'])->name('perks.list');

Route::middleware('auth')->group(function () {
    Route::get('/discord-invite', function () {
        return redirect(config('services.discord.invite'));
    })->name('discord.invite');

    Route::get('/discord-verify', function () {
        return view('discord.index');
    })->name('discord.verify');

    Route::middleware('verified')->group(function () {
        Route::get('/', [CharacterController::class, 'index'])
            ->name('characters.index');

        Route::get('/characters', [CharacterController::class, 'all'])
            ->name('characters.all');

        Route::get('/wikiauth', WikiController::class)->name('wiki.index');

        Route::delete('/characters/{character:login}/force', [CharacterController::class, 'forceDestroy'])
            ->name('characters.forceDestroy');

        Route::patch('/characters/{character:login}/restore', [CharacterController::class, 'restore'])
            ->name('characters.restore');

        Route::get('/characters/{character:login}/charsheet', [CharsheetController::class, 'edit'])
            ->name('characters.charsheet.edit');

        Route::patch('/characters/{character:login}/charsheet', [CharsheetController::class, 'update'])
            ->name('characters.charsheet.update');

        Route::get('/characters/{character:login}/perks', [CharsheetController::class, 'editPerks'])
            ->name('characters.perks.edit');

        Route::patch('/characters/{character:login}/perks', [CharsheetController::class, 'updatePerks'])
            ->name('characters.perks.update');

        Route::get('/characters/{character:login}/fates', [CharsheetController::class, 'editFates'])
            ->name('characters.fates.edit');

        Route::patch('/characters/{character:login}/fates', [CharsheetController::class, 'updateFates'])
            ->name('characters.fates.update');

        Route::patch('/characters/{character:login}/perks/{perkVariant}', [CharsheetController::class, 'togglePerk'])
            ->name('characters.perks.toggle');

        Route::resource('characters', CharacterController::class)
            ->except('index')
            ->scoped(['character' => 'login']);

        Route::get('/applications', [ApplicationController::class, 'index'])
            ->name('applications.index');

        Route::patch('/characters/{character:login}/send', [ApplicationController::class, 'send'])
            ->name('applications.send');

        Route::patch('/characters/{character:login}/cancel', [ApplicationController::class, 'cancel'])
            ->name('applications.cancel');

        Route::patch('/characters/{character:login}/takeForApproval', [ApplicationController::class, 'takeForApproval'])
            ->name('applications.takeForApproval');

        Route::patch('/characters/{character:login}/cancelApproval', [ApplicationController::class, 'cancelApproval'])
            ->name('applications.cancelApproval');

        Route::patch('/characters/{character:login}/requestChanges', [ApplicationController::class, 'requestChanges'])
            ->name('applications.requestChanges');

        Route::patch('/characters/{character:login}/requestApproval', [ApplicationController::class, 'requestApproval'])
            ->name('applications.requestApproval');

        Route::patch('/characters/{character:login}/approve', [ApplicationController::class, 'approve'])
            ->name('applications.approve');

        Route::patch('/characters/{character:login}/reapproval', [ApplicationController::class, 'reapproval'])
            ->name('applications.reapproval');

        Route::get('/characters/{character:login}/skins', [SkinController::class, 'index'])->name('characters.skins.index');
        Route::get('/characters/{character:login}/skins/create', [SkinController::class, 'create'])->name('characters.skins.create');
        Route::post('/characters/{character:login}/skins', [SkinController::class, 'store'])->name('characters.skins.store');
        Route::delete('/characters/{character:login}/skins', [SkinController::class, 'destroy'])->name('characters.skins.destroy');

        Route::resource('characters.vox', VoxController::class)
            ->scoped(['character' => 'login'])
            ->only(['index', 'create', 'store']);

        Route::get('/characters/{character:login}/ideas/{idea}/sphere', [IdeaController::class, 'sphereView'])
            ->name('characters.ideas.sphereView');

        Route::patch('/characters/{character:login}/ideas/{idea}/sphere', [IdeaController::class, 'sphere'])
            ->name('characters.ideas.sphere');

        Route::resource('characters.ideas', IdeaController::class)
            ->scoped(['character' => 'login'])
            ->except(['show', 'index']);

        Route::get('/characters/{character:login}/spheres/{sphere}/spend', [SphereController::class, 'spendView'])
            ->name('characters.spheres.spendView');

        Route::patch('/characters/{character:login}/spheres/{sphere}/spend', [SphereController::class, 'spend'])
            ->name('characters.spheres.spend');

        Route::get('/characters/{character:login}/spheres/{sphere}/add', [SphereController::class, 'addView'])
            ->name('characters.spheres.addView');

        Route::patch('/characters/{character:login}/spheres/{sphere}/add', [SphereController::class, 'add'])
            ->name('characters.spheres.add');

        Route::get(
            '/characters/{character:login}/spheres/{sphere}/experience',
            [SphereController::class, 'experienceView']
        )
            ->name('characters.spheres.experienceView');

        Route::patch(
            '/characters/{character:login}/spheres/{sphere}/experience',
            [SphereController::class, 'experience']
        )
            ->name('characters.spheres.experience');

        Route::resource('characters.spheres', SphereController::class)
            ->scoped(['character' => 'login'])
            ->except(['show', 'index']);

        Route::resource('characters.narrativeCrafts', NarrativeCraftController::class)
            ->scoped(['character' => 'login'])
            ->except(['show', 'index']);

        Route::get(
            '/characters/{character:login}/experiences/{experience}/set',
            [ExperienceController::class, 'setView']
        )
            ->name('characters.experiences.setView');

        Route::patch('/characters/{character:login}/experiences/{experience}/set', [ExperienceController::class, 'set'])
            ->name('characters.experiences.set');

        Route::resource('characters.experiences', ExperienceController::class)
            ->scoped(['character' => 'login'])
            ->except(['show', 'index']);

        Route::resource('users', UserController::class)
            ->except(['create', 'store']);

        Route::resource('users.ban', BanController::class)
            ->only(['create', 'store', 'destroy']);

        Route::resource('users.accounts', AccountController::class)
            ->except(['show', 'edit', 'update']);

        Route::middleware('can:settings')->group(function () {
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
                    'destroy' => 'perks.variants.destroy',
                ]);
        });

        Route::middleware('can:logs')->group(function () {
            Route::get('logs', [LogController::class, 'index'])
                ->name('logs.index');

            Route::get('logs/ingame', [LogController::class, 'ingame'])
                ->name('logs.ingame');

            Route::get('logs/crust', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
                ->name('logs.crust');
        });
    });
});

require __DIR__.'/auth.php';
