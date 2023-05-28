<a href="{{ route('characters.show', $character->login)}}"
   class="bg-white dark:bg-gray-600 dark:text-gray-200 rounded-3xl shadow-lg max-w-sm w-full overflow-hidden pb-4 transition duration-150 ease-in-out transform hover:-translate-y-2 hover:scale-105">
    <div class="relative">
        <div class="absolute top-0 right-0 m-4 text-lg">
            <x-character.status :status="$character->status"/>
        </div>
        <img
            class="object-cover object-top h-96 w-full dark:bg-white"
            src="{{ $character->getResizedReference(400) }}"
            alt="Character Reference"
        >
    </div>
    <div class="px-4 py-2 text-2xl font-bold text-center">
        {{ $character->name }}
    </div>
    @can('see-main-info', $character)
        <div class="dark:text-gray-300 px-4 line-clamp-2 text-center markdown prose dark:prose-invert max-w-none">{!! $character->description !!}</div>
    @endcan
</a>
