<div class="py-12 max-w-7xl mx-auto grid grid-cols-3 gap-8 justify-items-center">
    @foreach($characters as $character)
        <x-character.card :character="$character"/>
    @endforeach

    {{ $slot }}
</div>
