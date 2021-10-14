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
                <form class="m-2" method="POST" action="{{ route('characters.destroy', $character->login) }}">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 bg-red-100 hover:bg-red-200 focus:outline-none focus:border-red-300 focus:ring ring-red-300 rounded-full shadow" type="submit" onclick="return confirm('Are you sure?')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <div class="font-bold inline-block ml-1">
                            Delete
                        </div>
                    </button>
                </form>
                <form class="m-2" method="GET" action="{{ route('characters.edit', $character->login) }}">
                    @csrf
                    <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 focus:outline-none focus:border-gray-300 focus:ring ring-gray-300 rounded-full shadow" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <div class="font-bold inline-block ml-1">
                            Edit
                        </div>
                    </button>
                </form>
                @if ($character->status == \App\Enums\CharacterStatus::Blank())
                    <form class="m-2" method="POST" action="{{ route('application.send', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Send
                            </div>
                        </button>
                    </form>
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Pending())
                    <form class="m-2" method="POST" action="{{ route('application.cancel', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:border-gray-400 focus:ring ring-gray-400 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Cancel
                            </div>
                        </button>
                    </form>
                    <form class="m-2" method="POST" action="{{ route('application.takeForApproval', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-blue-200 hover:bg-blue-300 focus:outline-none focus:border-blue-400 focus:ring ring-blue-400 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Take For Approval
                            </div>
                        </button>
                    </form>
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Approval())
                    <form class="m-2" method="POST" action="{{ route('application.cancelApproval', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-yellow-200 hover:bg-yellow-300 focus:outline-none focus:border-yellow-400 focus:ring ring-yellow-400 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Cancel Approval
                            </div>
                        </button>
                    </form>
                    <form class="m-2" method="POST" action="{{ route('application.approve', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-green-200 hover:bg-green-300 focus:outline-none focus:border-green-400 focus:ring ring-green-400 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Approve
                            </div>
                        </button>
                    </form>
                @endif

                @if ($character->status == \App\Enums\CharacterStatus::Approved())
                    <form class="m-2" method="POST" action="{{ route('application.reapproval', $character->login) }}">
                        @csrf
                        <button class="px-4 py-2 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:border-yellow-300 focus:ring ring-yellow-300 rounded-full shadow" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="font-bold inline-block ml-1">
                                Send For Reapproval
                            </div>
                        </button>
                    </form>
                @endif
            </div>
            <div>
                <div class="flex items-center gap-4 font-bold text-xl">
                    Status: <x-character-status :status="$character->status"/>
                </div>
                @if ($character->registrar)
                    <div class="font-thin text-base text-right mt-2">
                        Registrar: {{ $character->registrar->name }}
                    </div>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto space-y-8">
        <div class="grid grid-cols-2 grid-rows-3 gap-4">
            <div class="bg-white rounded-xl max-w-md mx-auto shadow-lg row-span-3 place-self-start ">
                <img
                    class="object-cover"
                    src="{{ $character->getReference(); }}"
                    alt="Character Reference"
                >
            </div>
            <div class="bg-white p-4 rounded-xl shadow-lg place-self-center">
                <h1 class="font-bold text-xl mb-2">
                    Description
                </h1>

                {{ $character->description }}
            </div>
        </div>
    </div>
</x-app-layout>
