<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-600">
            <div class="flex-shrink-0">
                <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                    {{ $character->name }}
                </h2>
                <div class="font-thin text-base">
                    {{ __('label.player') }}: <a @can('view', $character->user)
                                                     class="font-bold underline text-blue-600 visited:text-purple-600"
                                                 href="{{ route('users.show', $character->user) }}"
                        @endcan>{{ $character->user->login }}</a>
                </div>
                <div class="font-thin text-base">
                    Discord: <span class="select-all">{{ $character->user->discord_tag }}</span>
                </div>
                <div class="font-thin text-base">
                    {{ __('label.login') }}: <span class="select-all">{{ $character->login }}</span>
                </div>
            </div>
            <div class="flex flex-wrap justify-center">
                <x-application.actions :character="$character"/>
            </div>
            <div>
                <div class="flex items-center gap-4 font-bold text-xl">
                    {{ __('label.status') }}:
                    <x-character.status :status="$character->status"/>
                </div>
                @if ($character->registrar)
                    <div class="font-thin text-base text-right mt-2">
                        {{ __('label.registrar') }}: {{ $character->registrar->discord_tag }}
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <x-container class="max-w-6xl space-y-8">
        <div class="flex justify-center gap-8">
            <div class="bg-white rounded-xl max-w-md my-auto shadow-lg row-span-3 flex-none overflow-hidden">
                <img
                    class="object-cover"
                    src="{{ Storage::disk('characters')->url($character->reference) }}"
                    alt="Character Reference"
                />
            </div>
            <div class="space-y-8 my-auto">
                @can('seeMainInfo', $character)
                    <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('characters.cards.main_info') }}
                        </h1>

                        <div class="text-lg">
                            <div class="flex items-center gap-1">
                                <b>{{ __('label.gender') }}:</b>
                                {{ $character->gender->localized() }}
                                <div
                                    class="text-2xl fa {{ $character->gender->icon() }} text-{{ $character->gender->color() }}"></div>
                            </div>
                            <div>
                                <b>{{ __('label.race') }}:</b> {{ $character->race }}
                            </div>
                            <div>
                                <b>{{ __('label.age') }}:</b> {{ $character->age }}
                            </div>
                        </div>
                    </div>
                @endcan

                @can('seeMainInfo', $character)
                    <div class="bg-white p-4 rounded-xl shadow-lg mr-auto text-justify">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('label.description') }}
                        </h1>

                        <div class="prose markdown max-w-none">{!! $character->description !!}</div>
                    </div>
                @endcan

                @if ($character->appearance)
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('label.appearance') }}
                        </h1>

                        <div class="prose markdown max-w-none">{!! $character->appearance !!}</div>
                        @can('see-player-only-info', $character)
                            <a class="font-bold underline text-blue-600 visited:text-purple-600"
                               href="{{ route('characters.skins.index', $character) }}">
                                {{ __('skins.index') }}
                            </a>
                        @endcan
                    </div>
                @endif

                @can('see-player-only-info', $character)
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify max-w-max mx-auto">
                        <h1 class="font-bold text-xl mb-2 max-w-max mx-auto">
                            {{ __('label.vox') }}: {{ $character->vox }}
                        </h1>

                        <div class="space-x-2">
                            @can('voxView', $character)
                                <a class="font-bold underline text-blue-600"
                                   href="{{ route('characters.vox.index', $character) }}">
                                    {{ __('vox.index') }}
                                </a>
                            @endcan
                            @can('voxCreate', $character)
                                <a class="font-bold underline text-blue-600 visited:text-purple-600"
                                   href="{{ route('characters.vox.create', $character) }}">
                                    {{ __('vox.create') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                @endcan
            </div>
        </div>

        @if(isset($character->charsheet->skills) || $character->charsheet->hasAnyCrafts())
            <div class="flex justify-center gap-8">
                @if(isset($character->charsheet->skills) && count($character->charsheet->skills))
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('charsheet.skills') }}
                        </h1>

                        <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
                            @foreach ($character->charsheet->skills as $skill => $value)
                                <div class="text-lg font-semibold text-right">
                                    {{ __('skill.'.$skill) }}
                                </div>
                                <div class="w-full bg-gray-200 rounded-full my-auto p-0.5">
                                    <div class="bg-blue-400 rounded-full h-3" style="width: {{ $value * 10 }}%">
                                        <div
                                            class="text-sm font-medium text-white text-center leading-none {{ $value == 0 ? "hidden" : "" }}">
                                            {{ $value }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($character->charsheet->hasAnyCrafts())
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('charsheet.crafts') }}
                        </h1>

                        @if($character->charsheet->hasAnyCrafts())
                            <div class="inline-grid w-full gap-x-2" style="grid-template-columns: min-content auto">
                                @foreach ($character->charsheet->crafts as $craft => $value)
                                    @if($value)
                                        <div class="text-lg font-semibold text-right">
                                            {{ __('craft.'.$craft) }}
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full my-auto p-0.5">
                                            <div class="bg-blue-400 rounded-full h-3"
                                                 style="width: {{ $value / App\Enums\CharacterCraft::from($craft)->getMaxTier() * 100 }}%">
                                                <div
                                                    class="text-sm font-medium text-white text-center leading-none {{ $value == 0 ? "hidden" : "" }}">
                                                    {{ $value }}
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        @can('see-player-only-info', $character)
            @php
                $narrativeCraftsVisible = Auth::user()->can('update-charsheet-gm', $character) || count($character->narrativeCrafts);
                $experiencesVisible = Auth::user()->can('update-charsheet-gm', $character) || count($character->experiences);
            @endphp
            @if ($narrativeCraftsVisible || $experiencesVisible)
                <div class="flex justify-center gap-8">
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
                        @if($narrativeCraftsVisible)
                            <h1 class="font-bold text-xl mb-2">
                                {{ __('charsheet.narrative_crafts.title') }}
                            </h1>
                            <div id="narrative-craft-open" data-accordion="open">
                                @foreach($character->narrativeCrafts as $narrativeCraft)
                                    <h2 class="mt-2" id="narrative-craft-open-heading-{{$loop->iteration}}">
                                        <button type="button"
                                                class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100"
                                                data-accordion-target="#narrative-craft-open-body-{{$loop->iteration}}"
                                                aria-expanded="false"
                                                aria-controls="narrative-craft-open-body-{{$loop->iteration}}">
                                            <span>{{ $narrativeCraft->name }}</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                 fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="narrative-craft-open-body-{{$loop->iteration}}" class="hidden"
                                         aria-labelledby="narrative-craft-open-heading-{{$loop->iteration}}">
                                        <div class="p-2 font-light border border-t-0 border-gray-200">
                                            <p class="mb-2 text-gray-500">{{ $narrativeCraft->description }}</p>
                                        </div>
                                        <div class="inline-flex flex-wrap" role="group">
                                            @can('update', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.narrativeCrafts.edit', ['character' => $character, 'narrativeCraft' => $narrativeCraft]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        {{ __('crafts.edit') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('update', $character)
                                                <form method="POST"
                                                      action="{{ route('characters.narrativeCrafts.destroy', ['character' => $character, 'narrativeCraft' => $narrativeCraft]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100"
                                                        onclick="if (!confirm('{{ __('ui.confirm', ['tip' => '']) }}')) {
                              event.preventDefault();
                            }"
                                                    >
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        {{ __('crafts.delete') }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                                @can('update-charsheet-gm', $character)
                                    <form method="GET"
                                          action="{{ route('characters.narrativeCrafts.create', ['character' => $character]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="mt-2 flex items-center gap-2 w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('crafts.create') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif

                        @if ($narrativeCraftsVisible && $experiencesVisible)
                            <hr class="my-4">
                        @endif

                        @if ($experiencesVisible)
                            <h1 class="font-bold text-xl mb-2">
                                {{ __('experiences.index') }}
                            </h1>
                            <div id="experience-open" data-accordion="open">
                                @foreach($character->experiences as $experience)
                                    <h2 class="mt-2" id="experiences-open-heading-{{$loop->iteration}}">
                                        <button type="button"
                                                class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100"
                                                data-accordion-target="#experience-open-body-{{$loop->iteration}}"
                                                aria-expanded="false"
                                                aria-controls="experience-open-body-{{$loop->iteration}}">
                                            <span>{{ $experience->name }} ({{ $experience->level }})</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                 fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="experience-open-body-{{$loop->iteration}}" class="hidden"
                                         aria-labelledby="experience-open-heading-{{$loop->iteration}}">
                                        @if (isset($experience->description))
                                            <div class="p-2 font-light border border-t-0 border-gray-200">
                                                <p class="mb-2 text-gray-500">{{ $experience->description }}</p>
                                            </div>
                                        @endif
                                        <div class="inline-flex flex-wrap" role="group">
                                            @can('update', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.experiences.edit', ['character' => $character, 'experience' => $experience]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        {{ __('experiences.edit') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('update-charsheet-gm', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.experiences.setView', ['character' => $character, 'experience' => $experience]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                                        </svg>
                                                        {{ __('experiences.set') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('update', $character)
                                                <form method="POST"
                                                      action="{{ route('characters.experiences.destroy', ['character' => $character, 'experience' => $experience]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100"
                                                        onclick="if (!confirm('{{ __('ui.confirm', ['tip' => '']) }}')) {
                              event.preventDefault();
                            }"
                                                    >
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        {{ __('experiences.delete') }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach
                                @can('update-charsheet-gm', $character)
                                    <form method="GET"
                                          action="{{ route('characters.experiences.create', ['character' => $character]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="mt-2 flex items-center gap-2 w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('experiences.create') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif

                        <x-form.error name="ideas"/>
                    </div>
                </div>
            @endif
        @endcan

        @can('see-player-only-info', $character)
            @php
                $spheresVisible = Auth::user()->can('add-sphere', $character) || count($character->spheres);
                $ideasVisible = Auth::user()->can('add-idea', $character) || count($character->ideas);
            @endphp
            @if ($spheresVisible || $ideasVisible)
                <div class="flex justify-center gap-8">
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-full my-auto">
                        @if($spheresVisible)
                            <h1 class="font-bold text-xl mb-2">
                                {{ __('spheres.index') }}
                            </h1>
                            <div id="sphere-open" data-accordion="open">
                                @foreach($character->spheres as $sphere)
                                    <h2 class="mt-2" id="sphere-open-heading-{{$loop->iteration}}">
                                        <button type="button"
                                                class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100"
                                                data-accordion-target="#sphere-open-body-{{$loop->iteration}}"
                                                aria-expanded="false"
                                                aria-controls="sphere-open-body-{{$loop->iteration}}">
                                            <span>{{ $sphere->name }} ({{ $sphere->value }})</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                 fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="sphere-open-body-{{$loop->iteration}}" class="hidden"
                                         aria-labelledby="sphere-open-heading-{{$loop->iteration}}">
                                        @if (isset($sphere->description))
                                            <div class="p-2 font-light border border-t-0 border-gray-200">
                                                <p class="mb-2 text-gray-500">{{ $sphere->description }}</p>
                                            </div>
                                        @endif
                                        <div class="inline-flex flex-wrap" role="group">
                                            @can('manage-ideas', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.spheres.edit', ['character' => $character, 'sphere' => $sphere]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        {{ __('spheres.edit') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('manage-ideasGm', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.spheres.addView', ['character' => $character, 'sphere' => $sphere]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ __('spheres.add') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('manage-ideas', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.spheres.spendView', ['character' => $character, 'sphere' => $sphere]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                                        </svg>
                                                        {{ __('spheres.spend') }}
                                                    </button>
                                                </form>
                                                <form method="GET"
                                                      action="{{ route('characters.spheres.experienceView', ['character' => $character, 'sphere' => $sphere]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                                        </svg>
                                                        {{ __('spheres.to_experience') }}
                                                    </button>
                                                </form>
                                                <form method="POST"
                                                      action="{{ route('characters.spheres.destroy', ['character' => $character, 'sphere' => $sphere]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-r border-gray-200 hover:bg-gray-100"
                                                        onclick="if (!confirm('{{ __('ui.confirm', ['tip' => '']) }}')) {
                              event.preventDefault();
                            }"
                                                    >
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        {{ __('spheres.delete') }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach

                                @can('add-sphere', $character)
                                    <form method="GET"
                                          action="{{ route('characters.spheres.create', ['character' => $character]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="mt-2 flex items-center gap-2 w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('spheres.create') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <x-form.error name="spheres"/>
                        @endif

                        @if ($spheresVisible && $ideasVisible)
                            <hr class="my-4">
                        @endif

                        @if ($ideasVisible)
                            <h1 class="font-bold text-xl mb-2">
                                {{ __('ideas.index') }}
                            </h1>
                            <div id="idea-open" data-accordion="open">
                                @foreach($character->ideas as $idea)
                                    <h2 class="mt-2" id="idea-open-heading-{{$loop->iteration}}">
                                        <button type="button"
                                                class="flex items-center justify-between w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100"
                                                data-accordion-target="#idea-open-body-{{$loop->iteration}}"
                                                aria-expanded="false"
                                                aria-controls="idea-open-body-{{$loop->iteration}}">
                                            <span>{{ $idea->name }}</span>
                                            <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0"
                                                 fill="currentColor" viewBox="0 0 20 20"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                      clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="idea-open-body-{{$loop->iteration}}" class="hidden"
                                         aria-labelledby="idea-open-heading-{{$loop->iteration}}">
                                        @if (isset($idea->description))
                                            <div class="p-2 font-light border border-t-0 border-gray-200">
                                                <p class="mb-2 text-gray-500">{{ $idea->description }}</p>
                                            </div>
                                        @endif
                                        <div class="inline-flex flex-wrap" role="group">
                                            @can('manage-ideas', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.ideas.edit', ['character' => $character, 'idea' => $idea]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-l border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                        </svg>
                                                        {{ __('ideas.edit') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('ideaToSphere', $character)
                                                <form method="GET"
                                                      action="{{ route('characters.ideas.sphere', ['character' => $character, 'idea' => $idea]) }}">
                                                    @csrf
                                                    <button type="submit"
                                                            class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                        </svg>
                                                        {{ __('ideas.to_sphere') }}
                                                    </button>
                                                </form>
                                            @endcan
                                            @can('manage-ideas', $character)
                                                <form method="POST"
                                                      action="{{ route('characters.ideas.destroy', ['character' => $character, 'idea' => $idea]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="inline-flex gap-2 items-center py-2 px-4 text-sm font-medium text-gray-900 bg-white border-b border-r border-gray-200 hover:bg-gray-100"
                                                        onclick="if (!confirm('{{ __('ui.confirm', ['tip' => '']) }}')) {
                              event.preventDefault();
                            }"
                                                    >
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        {{ __('ideas.delete') }}
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                @endforeach

                                @can('add-idea', $character)
                                    <form method="GET"
                                          action="{{ route('characters.ideas.create', ['character' => $character]) }}">
                                        @csrf
                                        <button type="submit"
                                                class="mt-2 flex items-center gap-2 w-full p-2 font-medium text-left text-gray-500 border border-gray-200 hover:bg-gray-100">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ __('ideas.create') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        @endif

                        <x-form.error name="ideas"/>
                    </div>
                </div>
            @endif
        @endcan

        @if (count($character->perkVariants))
            @php
                $perks = $character->perkVariants->groupBy(function($item, $key) {
                  return $item->perk->isCombat() ? 'combat' : 'noncombat';
                });
            @endphp
            <div class="flex justify-center gap-8">
                @if ($perks->get('combat'))
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-auto my-auto">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('perks.combat') }}
                        </h1>

                        <div class="space-y-4">
                            @foreach ($perks->get('combat')->sortByDesc('active') as $perkVariant)
                                @php
                                    $perk = $perkVariant->perk
                                @endphp

                                <x-perk-card :character="$character" :perk="$perk" :perkVariant="$perkVariant"/>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($perks->get('noncombat'))
                    <div class="bg-white p-4 rounded-xl shadow-lg text-justify w-auto my-auto">
                        <h1 class="font-bold text-xl mb-2">
                            {{ __('perks.noncombat') }}
                        </h1>

                        <div class="space-y-4">
                            @foreach ($perks->get('noncombat')->sortByDesc('active') as $perkVariant)
                                @php
                                    $perk = $perkVariant->perk
                                @endphp

                                <x-perk-card :character="$character" :perk="$perk" :perkVariant="$perkVariant"/>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <x-form.error name="vox"/>

        @can('update-charsheet-gm', $character)
            <div class="flex w-full justify-center">
                <a class="text-lg bg-white text-gray-700 py-2 px-3 rounded-full font-bold shadow align-self-center hover:"
                   href="{{ route('characters.perks.edit', $character) }}"
                >
                    {{ __('charsheet.edit.perks') }}
                </a>
            </div>
        @endcan

        @can('see-player-only-info', $character)
            @if (count($character->fates))
                <div class="bg-white p-4 rounded-xl shadow-lg text-justify mx-auto w-max max-w-full">
                    <h1 class="font-bold text-xl mb-2">
                        {{ __('charsheet.fates') }}
                    </h1>

                    <div class="divide-y divide-dashed">
                        @foreach ($character->fates as $fate)
                            <div class="p-2">
                                <div class="flex text-sm font-semibold space-x-2 mb-2">
                                    @if ($fate->isDual())
                                        <div class="bg-gray-200 px-2 rounded-full">
                                            {{ __('fates.dual') }}
                                        </div>
                                    @elseif ($fate->isAmbition())
                                        <div class="bg-yellow-200 px-2 rounded-full">
                                            {{ __('fates.ambition') }}
                                        </div>
                                    @elseif ($fate->isFlaw())
                                        <div class="bg-blue-200 px-2 rounded-full">
                                            {{ __('fates.flaw') }}
                                        </div>
                                    @endif

                                    @if ($fate->isOnetime())
                                        <div class="bg-green-200 px-2 rounded-full">
                                            {{ __('fates.onetime') }}
                                        </div>
                                    @else
                                        <div class="bg-purple-200 px-2 rounded-full">
                                            {{ __('fates.continuous') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="prose markdown text-lg min-w-full">{!! $fate->text !!}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endcan

        @can('update-charsheet-gm', $character)
            <div class="flex w-full justify-center">
                <a class="text-lg bg-white text-gray-700 py-2 px-3 rounded-full font-bold shadow align-self-center hover:bg-blue-100 focus:ring-2"
                   href="{{ route('characters.fates.edit', $character) }}"
                >
                    {{ __('charsheet.edit.fates') }}
                </a>
            </div>
        @endcan

        @can('see-player-only-info', $character)
            @if ($character->player_only_info)
                <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
                    <h1 class="font-bold text-xl mb-2">
                        {{ __('label.player_only_info') }}
                    </h1>

                    <div class="prose markdown max-w-none">{!! $character->player_only_info !!}</div>
                </div>
            @endif
        @endcan

        @if ($character->gm_only_info)
            @can('seeGmOnlyInfo', $character)
                <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
                    <h1 class="font-bold text-xl mb-2">
                        {{ __('label.gm_only_info') }}
                    </h1>

                    <div class="prose markdown max-w-none">{!! $character->gm_only_info !!}</div>
                </div>
            @endcan
        @endif

        @can('seeBio', $character)
            @if ($character->personality)
                <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
                    <h1 class="font-bold text-xl mb-2">
                        {{ __('label.personality') }}
                    </h1>

                    <div class="prose markdown max-w-none">{!! $character->personality !!}</div>
                </div>
            @endif
            @if ($character->background)
                <div class="bg-white p-4 rounded-xl shadow-lg text-justify">
                    <h1 class="font-bold text-xl mb-2">
                        {{ __('label.background') }}
                    </h1>

                    <div class="prose markdown max-w-none">{!! $character->background !!}</div>
                </div>
            @endif
        @endcan
    </x-container>
</x-app-layout>
