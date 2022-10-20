<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('characters.create') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <x-character.stages/>

        <form class="space-y-8" method="POST" action="{{ route('characters.store') }}" enctype="multipart/form-data">
            @csrf

            <x-form.card>
                <x-slot name="header">
                    {{ __('characters.cards.main_info') }}
                </x-slot>

                <x-form.input name="name" maxlength="100" required placeholder="{{ __('characters.placeholder.name') }}"
                              onchange="updateLoginField(this)"/>
                <x-tip>
                    {{ __('tips.character.name') }}
                </x-tip>
                <x-form.select required :name="'gender'" :values="App\Enums\CharacterGender::cases()"
                               :labels="array_map(function($status) { return $status->localized(); }, App\Enums\CharacterGender::cases())"
                               :value="old('gender')"/>
                <x-tip>
                    {{ __('tips.character.gender') }}
                </x-tip>
                <x-form.input name="race" maxlength="100" required
                              placeholder="{{ __('characters.placeholder.race') }}"/>
                <x-tip>
                    {{ __('tips.character.race') }}
                </x-tip>
                <x-form.input name="age" maxlength="100" required placeholder="{{ __('characters.placeholder.age') }}"/>
                <x-tip>
                    {{ __('tips.character.age') }}
                </x-tip>
                <x-form.textarea name="description" maxlength="512" required onfocus="preview(this)"
                                 placeholder="{{ __('characters.placeholder.description') }}" wrap="off"/>
                <x-tip>
                    {{ __('tips.character.description') }}
                </x-tip>
                <x-form.checkbox name="info_hidden" value="{{ old('info_hidden', true) }}"/>
                <x-tip>
                    {{ __('tips.character.info_hidden') }}
                </x-tip>
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('characters.cards.visuals') }}
                </x-slot>

                <x-form.input name="reference" type="file" accept="image/*"/>
                <x-tip>
                    {{ __('tips.character.reference') }}
                </x-tip>
                <x-form.textarea name="appearance" maxlength="10000" required onfocus="preview(this)"
                                 placeholder="{{ __('characters.placeholder.appearance') }}" wrap="off"/>
                <x-tip>
                    {{ __('tips.character.appearance') }}
                </x-tip>
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('characters.cards.biography') }}
                </x-slot>

                <x-form.textarea name="personality" onfocus="preview(this)"
                                 placeholder="{{ __('characters.placeholder.personality') }}" wrap="off"/>
                <x-tip>
                    {{ __('tips.character.personality') }}
                </x-tip>
                <x-form.textarea name="background" onfocus="preview(this)"
                                 placeholder="{{ __('characters.placeholder.background') }}" wrap="off"/>
                <x-tip>
                    {{ __('tips.character.background') }}
                </x-tip>
                <x-form.checkbox name="bio_hidden" value="{{ old('bio_hidden', true) }}"/>
                <x-tip>
                    {{ __('tips.character.bio_hidden') }}
                </x-tip>
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('characters.cards.additional_info') }}
                </x-slot>

                <x-form.textarea name="player_only_info" onfocus="preview(this)"
                                 placeholder="{{ __('characters.placeholder.player_only_info') }}" wrap="off"/>
                <x-tip>
                    {{ __('tips.character.player_only_info') }}
                </x-tip>
            </x-form.card>

            <x-form.card>
                <x-slot name="header">
                    {{ __('characters.cards.registration_info') }}
                </x-slot>

                <x-form.input name="login" required maxlength="16" pattern="[A-Za-z0-9-_]+"
                              placeholder="{{ __('characters.placeholder.login') }}"/>
                <x-tip>
                    {{ __('tips.character.login') }}
                </x-tip>
            </x-form.card>

            <x-button>
                {{ __('ui.submit') }}
            </x-button>
        </form>
        <script>
            var previewText = @json(__('label.preview'))
        </script>
    </x-container>
</x-app-layout>
