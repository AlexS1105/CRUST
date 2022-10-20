<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('sphere.experience') }}
        </h2>
    </x-slot>

    <x-container class="max-w-3xl mx-auto">
        <form class="space-y-8" method="POST"
              action="{{ route('characters.spheres.experience', ['character' => $character, 'sphere' => $sphere]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.select required :name="'experience'" :values="$character->experiences->pluck('id')"
                               :labels="$character->experiences->pluck('name')" :value="old('experience')"/>
                <x-form.input name="value" required type="number" min="1" max="10" :value="old('value', 1)"/>

                <x-button>
                    {{ __('ui.submit') }}
                </x-button>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
