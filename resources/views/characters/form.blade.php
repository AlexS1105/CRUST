<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-slot name="header">
            {{ __('characters.cards.main_info') }}
        </x-slot>

        <x-form.input name="name"
                      maxlength="100"
                      required
                      placeholder="{{ __('characters.placeholder.name') }}"
                      onchange="updateLoginField(this)"
                      :value="old('name', @$character?->name)"
        />
        <x-tip text="character.name"/>

        <x-form.select required
                       :name="'gender'"
                       :values="App\Enums\CharacterGender::cases()"
                       :labels="array_map(function($status) { return $status->localized(); }, App\Enums\CharacterGender::cases())"
                       :value="old('gender', @$character?->gender)"
        />
        <x-tip text="character.gender"/>

        <x-form.input name="race"
                      maxlength="100"
                      required
                      :value="old('race', @$character?->race)"
                      placeholder="{{ __('characters.placeholder.race') }}"/>
        <x-tip text="character.race"/>

        <x-form.input name="age"
                      maxlength="100"
                      required
                      placeholder="{{ __('characters.placeholder.age') }}"
                      :value="old('age', @$character?->age)"
        />
        <x-tip text="character.age"/>

        <x-form.textarea name="description"
                         maxlength="512"
                         required
                         onfocus="preview(this)"
                         placeholder="{{ __('characters.placeholder.description') }}"
                         wrap="off"
        >
            {{ old('description', @$character?->description) }}
        </x-form.textarea>
        <x-tip text="character.description"/>

        <x-form.checkbox name="info_hidden"
                         value="{{ old('info_hidden', @$character?->info_hidden ?? true) }}"
        />
        <x-tip text="character.info_hidden"/>
    </x-form.card>

    <x-form.card>
        <x-slot name="header">
            {{ __('characters.cards.visuals') }}
        </x-slot>

        <x-form.input name="reference" type="file" accept="image/*"/>
        <x-tip text="character.reference"/>

        <x-form.textarea name="appearance"
                         maxlength="10000"
                         onfocus="preview(this)"
                         placeholder="{{ __('characters.placeholder.appearance') }}"
                         wrap="off"
        >
            {{ old('appearance', @$character?->appearance) }}
        </x-form.textarea>
        <x-tip text="character.appearance"/>
    </x-form.card>

    <x-form.card>
        <x-slot name="header">
            {{ __('characters.cards.biography') }}
        </x-slot>

        <x-form.textarea name="personality"
                         onfocus="preview(this)"
                         placeholder="{{ __('characters.placeholder.personality') }}"
                         wrap="off"
        >
            {{ old('personality', @$character?->personality) }}
        </x-form.textarea>
        <x-tip text="character.personality"/>

        <x-form.textarea name="background"
                         onfocus="preview(this)"
                         placeholder="{{ __('characters.placeholder.background') }}"
                         wrap="off"
        >
            {{ old('background', @$character?->background) }}
        </x-form.textarea>
        <x-tip text="character.background"/>

        <x-form.checkbox name="bio_hidden"
                         value="{{ old('bio_hidden', @$character?->bio_hidden ?? true) }}"
        />
        <x-tip text="character.bio_hidden"/>
    </x-form.card>

    <x-form.card>
        <x-slot name="header">
            {{ __('characters.cards.additional_info') }}
        </x-slot>

        <x-form.textarea name="player_only_info"
                         onfocus="preview(this)"
                         placeholder="{{ __('characters.placeholder.player_only_info') }}"
                         wrap="off"
        >
            {{ old('player_only_info', @$character?->player_only_info) }}
        </x-form.textarea>
        <x-tip text="character.player_only_info"/>

        @isset($character)
            @can('see-gm-only-info', $character)
                <x-form.textarea name="gm_only_info" onfocus="preview(this)" wrap="off">
                    {{ old('gm_only_info', $character->gm_only_info) }}
                </x-form.textarea>
                <x-tip text="character.gm_only_info"/>
            @endcan
        @endisset
    </x-form.card>

    @if(!isset($character) || auth()->user()->can('update-charsheet-gm', $character))
        <x-form.card>
            <x-slot name="header">
                {{ __('characters.cards.registration_info') }}
            </x-slot>

            <x-form.input name="login"
                          required
                          maxlength="16"
                          pattern="[A-Za-z0-9-_]+"
                          placeholder="{{ __('characters.placeholder.login') }}"
                          :value="old('login', @$character?->login)"
            />
            <x-tip>
                {{ __('tips.character.login') }}
            </x-tip>
        </x-form.card>
    @endif

    <x-button-submit/>
</x-form.base>

@push('scripts')
    <script>
        var previewText = @json(__('label.preview'))
    </script>
@endpush
