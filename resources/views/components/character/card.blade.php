<a href="{{ route('characters.show', $character->login)}}" class="bg-white rounded-3xl shadow-lg max-w-sm w-full overflow-hidden pb-4 transition duration-150 ease-in-out transform hover:-translate-y-2 hover:scale-105">
  <div class = "relative">
    <div class="absolute top-0 right-0 m-4 text-lg">
      <x-character.status :status="$character->status"/>
    </div>
    <img
      class="object-cover object-top h-96 w-full"
      src="{{ Storage::url($character->reference).'?='.$character->updated_at }}"
      alt="Character Reference"
    >
  </div>
  <div class="px-4 py-2 text-2xl font-bold text-center">
    {{ $character->name }}
  </div>
  @can('seeMainInfo', $character)
    <div class="px-4 line-clamp-2 text-center markdown prose max-w-none">{!! $character->description !!}</div>
  @endcan
</a>
