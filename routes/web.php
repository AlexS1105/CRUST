<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdvantageController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharsheetController;
use App\Http\Controllers\CharsheetSettingsController;
use App\Http\Controllers\DiscordController;
use App\Http\Controllers\EstitenceController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MinecraftAuthController;
use App\Http\Controllers\PerkController;
use App\Http\Controllers\RumorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\TalentController;
use App\Http\Controllers\TechniqueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WikiController;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

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

Route::get('/skills', [SkillController::class, 'all'])
    ->name('skills.list');

Route::get('/talents', [TalentController::class, 'all'])
    ->name('talents.list');

Route::get('/techniques', [TechniqueController::class, 'all'])
    ->name('techniques.list');

Route::middleware('auth')
    ->group(function () {
        Route::controller(DiscordController::class)
            ->name('discord.')
            ->group(function () {
                Route::get('/discord-invite', 'invite')->name('invite');
                Route::get('/discord-verify', 'verify')->name('verify');
            });

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
                            });

                        Route::name('stats.')
                            ->group(function () {
                                Route::get('stats', 'editStats')
                                    ->name('edit');

                                Route::patch('stats', 'updateStats')
                                    ->name('update');
                            });

                        Route::name('skills.')
                            ->group(function () {
                                Route::get('skills', 'editSkills')
                                    ->name('edit');

                                Route::patch('skills', 'updateSkills')
                                    ->name('update');
                            });

                        Route::name('talents.')
                            ->group(function () {
                                Route::get('talents', 'editTalents')
                                    ->name('edit');

                                Route::patch('talents', 'updateTalents')
                                    ->name('update');
                            });

                        Route::name('techniques.')
                            ->group(function () {
                                Route::get('techniques', 'editTechniques')
                                    ->name('edit');

                                Route::patch('techniques', 'updateTechniques')
                                    ->name('update');
                            });

                        Route::name('tides.')
                            ->group(function () {
                                Route::get('tides', 'editTides')
                                    ->name('edit');

                                Route::patch('tides', 'updateTides')
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

                Route::resource('characters.estitence', EstitenceController::class)
                    ->scoped(['character' => 'login'])
                    ->only(['index', 'create', 'store']);

                Route::resource('characters.experience', ExperienceController::class)
                    ->scoped(['character' => 'login'])
                    ->only(['index', 'create', 'store']);

                Route::get('/rumors', [RumorController::class, 'index'])
                    ->name('rumors.index');

                Route::get('/characters/{character:login}/rumors', [RumorController::class, 'character'])
                    ->name('rumors.character');

                Route::controller(CharacterController::class)
                    ->prefix('/characters/{character:login}/')
                    ->name('characters.title.')
                    ->group(function () {
                        Route::get('title', 'editTitle')
                            ->name('edit');

                        Route::put('title', 'updateTitle')
                            ->name('update');
                    });

                Route::resource('characters.rumors', RumorController::class)
                    ->shallow()
                    ->scoped(['character' => 'login'])
                    ->except(['index', 'show']);

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

                        Route::resource('settings/skills', SkillController::class)
                            ->except(['show']);

                        Route::resource('settings/skills/{skill}/advantages', AdvantageController::class)
                            ->except(['index', 'show'])
                            ->shallow();

                        Route::resource('settings/talents', TalentController::class)
                            ->except(['show']);

                        Route::resource('settings/techniques', TechniqueController::class)
                            ->except(['show']);
                    });

                Route::middleware('can:logs')
                    ->name('logs.')
                    ->group(function () {
                        Route::get('logs', [LogController::class, 'index'])
                            ->name('index');

                        Route::get('logs/crust', [LogViewerController::class, 'index'])
                            ->name('crust');
                    });
            });
    });

require __DIR__.'/auth.php';
