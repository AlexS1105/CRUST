<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-600">
            <div class="flex-grow-0">
                <h2 class="font-semibold leading-tight text-gray-800 text-3xl">
                    {{ $character->name }}
                </h2>
                <div class="font-thin text-base mt-2">
                    Login: <span class="select-all">{{ $character->login }}</span>
                </div>
            </div>
            <div class="flex flex-wrap flex-shrink-0">

                <x-application.button text="Delete"
                    action="{{ route('characters.destroy', $character->login) }}"
                    bladeMethod="DELETE"
                    color="red-100"
                    colorHover="red-200"
                    colorRing="red-300"
                    confirmationText="return confirm('{{ __('Are you sure?') }}')"
                    icon="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                />

                <x-application.button text="Edit"
                    method="GET"
                    action="{{ route('characters.edit', $character->login) }}"
                    color="gray-100"
                    colorHover="gray-200"
                    colorRing="gray-300"
                    icon="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                />
                @if ($character->status == \App\Enums\CharacterStatus::Blank())
                    <x-application.button text="Send To Approval"
                        action="{{ route('application.send', $character->login) }}"
                        color="blue-100"
                        colorHover="blue-200"
                        colorRing="blue-300"
                        icon="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Pending())
                    <x-application.button text="Cancel"
                        action="{{ route('application.cancel', $character->login) }}"
                        color="gray-200"
                        colorHover="gray-300"
                        colorRing="gray-400"
                        icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <x-application.button text="Take For Approval"
                        action="{{ route('application.takeForApproval', $character->login) }}"
                        color="blue-200"
                        colorHover="blue-300"
                        colorRing="blue-400"
                        icon="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"
                    />
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Approval())
                    <x-application.button text="Cancel Approval"
                        action="{{ route('application.cancelApproval', $character->login) }}"
                        color="yellow-200"
                        colorHover="yellow-300"
                        colorRing="yellow-400"
                        icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                    <x-application.button text="Approve"
                        action="{{ route('application.approve', $character->login) }}"
                        color="green-200"
                        colorHover="green-300"
                        colorRing="green-400"
                        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                    />
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Approved())
                    <x-application.button text="Send For Reapproval"
                        action="{{ route('application.reapproval', $character->login) }}"
                        color="yellow-100"
                        colorHover="yellow-200"
                        colorRing="yellow-300"
                        icon="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                @endif
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

    <div class="grid grid-cols-2 grid-rows-3 gap-8">
        <div class="bg-white rounded-xl max-w-md ml-auto shadow-lg row-span-3 place-self-start overflow-hidden">
            <img
                class="object-cover"
                src="{{ asset($character->reference).'?='.$character->updated_at }}"
                alt="Character Reference"
            >
        </div>
        <div class="bg-white p-4 rounded-xl shadow-lg place-self-center text-justify">
            <h1 class="font-bold text-xl mb-2">
                Description
            </h1>

            {{ $character->description }}
        </div>
    </div>
</x-app-layout>
