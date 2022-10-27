<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ideas.to_sphere') }}
        </h2>
    </x-slot>

    <x-container>
        <form class="space-y-8" method="POST"
              action="{{ route('characters.ideas.sphere', ['character' => $character, 'idea' => $idea]) }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.select required :name="'sphere'" :values="$character->spheres->pluck('id')"
                               :labels="$character->spheres->pluck('name')" :value="old('sphere')"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
</x-app-layout>
