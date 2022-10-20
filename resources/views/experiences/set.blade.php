<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('experiences.set') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST"
              action="{{ route('characters.experiences.set', ['character' => $character, 'experience' => $experience]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="level" required type="number" min="1" max="10"
                              :value="old('level', $experience->level)"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
