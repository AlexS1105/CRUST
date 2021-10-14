<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Characters') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto grid grid-cols-3 gap-8 justify-items-center">
        @foreach($characters as $character)
            <x-character.card :character="$character"/>
        @endforeach
        
        <x-character.new :href="route('characters.create')"/>
    </div>
</x-app-layout>
