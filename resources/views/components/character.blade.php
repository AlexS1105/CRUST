<a href="#" class="bg-white rounded-3xl shadow-lg max-w-sm overflow-hidden pb-4">
  <div class = "relative">
    <div class="absolute top-0 right-0 m-4 px-3 py-1 text-lg text-white bg-{{ App\Enums\CharacterStatus::getColor($character->status) }} rounded-full font-bold">
      {{ __($character->status->description) }}
    </div>
    <img
      class="object-cover h-auto w-auto"
      src="{{ $character->getReference(); }}"
      alt="Character Reference"
    >
  </div>
  <div class="px-4 py-2 text-2xl font-bold">
    {{ $character->name }}
  </div>
  <div class="px-4 line-clamp-4">
  {{ $character->description }}
  </div>
</a>
