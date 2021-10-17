<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-600">
            <div class="flex-grow-0">
                <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                    {{ $character->name }}
                </h2>
                <div class="font-thin text-base mt-2">
                    Player: <span class="select-all">{{ $character->user->name }}</span>
                </div>
                <div class="font-thin text-base">
                    Login: <span class="select-all">{{ $character->login }}</span>
                </div>
            </div>
            <div class="flex flex-wrap flex-shrink-0">
                <x-application.actions :character="$character"/>
            </div>
            <div>
                <div class="flex items-center gap-4 font-bold text-xl">
                    Status: <x-character.status :status="$character->status"/>
                </div>
                @if ($character->registrar)
                    <div class="font-thin text-base text-right mt-2">
                        Registrar: {{ $character->registrar->name }}
                    </div>
                @endif
            </div>
        </div>
    </x-slot>
    
    <x-container>
        <div class="grid grid-cols-2 grid-rows-3 gap-8">
            <div class="bg-white rounded-xl max-w-md ml-auto shadow-lg row-span-3 place-self-start overflow-hidden">
                <img
                    class="object-cover"
                    src="{{ asset($character->reference).'?='.$character->updated_at }}"
                    alt="Character Reference"
                >
            </div>
            <div class="bg-white p-4 rounded-xl shadow-lg place-self-start text-justify">
                <h1 class="font-bold text-xl mb-2">
                    Description
                </h1>

                {{ $character->description }}
            </div>
        </div>
    </x-container>
</x-app-layout>
