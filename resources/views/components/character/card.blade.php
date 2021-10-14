<a href="{{ route('characters.show', $character->login)}}" class="bg-white rounded-3xl shadow-lg max-w-sm overflow-hidden pb-4 transition duration-150 ease-in-out transform hover:-translate-y-2 hover:scale-105">
  <div class = "relative">
    <div class="absolute top-0 right-0 m-4 text-lg">
      <x-character.status :status="$character->status"/>
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
