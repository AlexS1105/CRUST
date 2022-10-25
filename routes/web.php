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

Route::get('/auth', MinecraftAuthController::class)
    ->name('minecraft.auth');

Route::get('/perks', [PerkController::class, 'all'])
    ->name('perks.list');

Route::middleware('auth')
    ->group(function () {
        Route::get('/discord-invite', function () {
            return redirect(config('services.discord.invite'));
        })->name('discord.invite');

        Route::get('/discord-verify', function () {
            return auth()->user()->verified ? to_route('characters.index') : view('discord.index');
        })->name('discord.verify');

        Route::middleware('verified')
            ->group(function () {
                Route::controller(CharacterController::class)
                    ->name('characters.')
                    ->group(function () {
                        Route::get('/', 'index')
                            ->name('index');

                        Route::get('/characters', 'all')
                            ->name('all');

                        Route::prefix('characters/{character:login}/')
                            ->group(function () {
                                Route::delete('force', 'forceDestroy')
                                    ->name('force_destroy');

                                Route::patch('restore', 'restore')
                                    ->name('restore');
                            });
                    });

                Route::controller(CharsheetController::class)
                    ->name('characters.')
                    ->prefix('characters/{character:login}/')
                    ->group(function () {
                        Route::name('charsheet.')
                            ->group(function () {
                                Route::get('charsheet', 'edit')
                                    ->name('edit');

                                Route::patch('charsheet', 'update')
                                    ->name('update');
                            });

                        Route::name('perks.')
                            ->group(function () {
                                Route::get('perks', 'editPerks')
                                    ->name('edit');

                                Route::patch('perks', 'updatePerks')
                                    ->name('update');

                                Route::patch('perks/{perkVariant}', 'togglePerk')
                                    ->name('toggle');
                            });

                        Route::name('fates.')
                            ->group(function () {
                                Route::get('fates', 'editFates')
                                    ->name('edit');

                                Route::patch('fates', 'updateFates')
                                    ->name('update');
                            });
                    });

                Route::controller(ApplicationController::class)
                    ->name('applications.')
                    ->group(function () {
                        Route::get('/applications', 'index')
                            ->name('index');

                        Route::prefix('characters/{character:login}/')->group(function () {
                            Route::patch('send', 'send')
                                ->name('send');

                            Route::patch('cancel', 'cancel')
                                ->name('cancel');

                            Route::patch('take-for-approval', 'takeForApproval')
                                ->name('take_for_approval');

                            Route::patch('cancel-approval', 'cancelApproval')
                                ->name('cancel_approval');

                            Route::patch('request-changes', 'requestChanges')
                                ->name('request_changes');

                            Route::patch('request-approval', 'requestApproval')
                                ->name('request_approval');

                            Route::patch('approve', 'approve')
                                ->name('approve');

                            Route::patch('reapproval', 'reapproval')
                                ->name('reapproval');
                        });
                    });

                Route::controller(SkinController::class)
                    ->prefix('/characters/{character:login}/')
                    ->name('characters.skins.')
                    ->group(function () {
                        Route::get('skins', 'index')
                            ->name('index');

                        Route::get('skins/create', 'create')
                            ->name('create');

                        Route::post('skins', 'store')
                            ->name('store');

                        Route::delete('skins', 'destroy')
                            ->name('destroy');
                    });

                Route::resource('characters', CharacterController::class)
                    ->except('index')
                    ->scoped(['character' => 'login']);

                Route::get('/wikiauth', WikiController::class)
                    ->name('wiki.index');

                Route::resource('characters.vox', VoxController::class)
                    ->scoped(['character' => 'login'])
                    ->only(['index', 'create', 'store']);

                Route::controller(IdeaController::class)
                    ->name('characters.ideas.')
                    ->prefix('/characters/{character:login}/ideas/{idea}/')
                    ->group(function () {
                        Route::get('sphere', 'sphereView')
                            ->name('sphere_view');

                        Route::patch('sphere', 'sphere')
                            ->name('sphere');
                    });

                Route::resource('characters.ideas', IdeaController::class)
                    ->scoped(['character' => 'login'])
                    ->except(['show', 'index']);

                Route::controller(SphereController::class)
                    ->name('characters.spheres.')
                    ->prefix('/characters/{character:login}/spheres/{sphere}/')
                    ->group(function () {
                        Route::get('spend', 'spendView')
                            ->name('spend_view');

                        Route::patch('spend', 'spend')
                            ->name('spend');

                        Route::get('add', 'addView')
                            ->name('add_view');

                        Route::patch('add', 'add')
                            ->name('add');

                        Route::get('experience', 'experienceView')
                            ->name('experience_view');

                        Route::patch('experience', 'experience')
                            ->name('experience');
                    });

                Route::resource('characters.spheres', SphereController::class)
                    ->scoped(['character' => 'login'])
                    ->except(['show', 'index']);

                Route::resource('characters.narrative_crafts', NarrativeCraftController::class)
                    ->scoped(['character' => 'login'])
                    ->except(['show', 'index']);

                Route::controller(ExperienceController::class)
                    ->name('characters.experiences.')
                    ->prefix('/characters/{character:login}/experiences/{experience}/')
                    ->group(function () {
                        Route::get('set', 'setView')
                            ->name('set_view');

                        Route::patch('set', 'set')
                            ->name('set');
                    });

                Route::resource('characters.experiences', ExperienceController::class)
                    ->scoped(['character' => 'login'])
                    ->except(['show', 'index']);

                Route::resource('users', UserController::class)
                    ->except(['create', 'store']);

                Route::resource('users.ban', BanController::class)
                    ->only(['create', 'store', 'destroy']);

                Route::resource('users.accounts', AccountController::class)
                    ->except(['show', 'edit', 'update']);

                Route::middleware('can:settings')
                    ->group(function () {
                        Route::name('settings.')
                            ->group(function () {
                                Route::get('settings', SettingsController::class)
                                    ->name('index');

                                Route::controller(GeneralSettingsController::class)
                                    ->name('general.')
                                    ->prefix('settings/')
                                    ->group(function () {
                                        Route::get('general', 'show')
                                            ->name('show');

                                        Route::patch('general', 'update')
                                            ->name('update');
                                    });

                                Route::controller(CharsheetSettingsController::class)
                                    ->name('charsheet.')
                                    ->prefix('charsheet/')
                                    ->group(function () {
                                        Route::get('charsheet', 'show')
                                            ->name('show');

                                        Route::patch('charsheet', 'update')
                                            ->name('update');
                                    });
                            });

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

                Route::middleware('can:logs')
                    ->name('logs.')
                    ->group(function () {
                        Route::get('logs', [LogController::class, 'index'])
                            ->name('index');

                        Route::get('logs/ingame', [LogController::class, 'ingame'])
                            ->name('ingame');

                        Route::get('logs/crust', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
                            ->name('crust');
                    });
            });
    });

require __DIR__.'/auth.php';
