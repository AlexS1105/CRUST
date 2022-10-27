<div class="py-12 max-w-7xl mx-auto grid lg:grid-cols-3 md:grid-cols-2 gap-8 justify-items-center">
    @foreach($characters as $character)
        <x-character.card :character="$character"/>
    @endforeach

    {{ $slot }}
</div>
