@props([
    'text',
    'method' => 'POST',
    'action',
    'bladeMethod' => false,
    'color',
    'colorHover',
    'colorRing',
    'confirmationText' => "",
    'icon',
    'icons' => false,
])

<form class="m-2" method="{{ $method }}" action="{{ $action }}" title="{{ $text }}">
    @csrf
    @if($bladeMethod)
        @method($bladeMethod)
    @endif

    <button
        class="flex gap-2 px-4 py-2 {{ $color }} hover:{{ $colorHover }} focus:outline-none focus:{{ $colorRing }} focus:ring {{ $colorRing }} rounded-full shadow"
        type="submit"
        onclick="{{ $confirmationText }}">
        @isset($icon)
            <div class="{{ $icon }}"></div>
        @endif

        @if(! $icons)
            <div class="font-bold text-sm inline-block ml-1 hidden sm:block">
                {{ $text }}
            </div>
        @endunless
    </button>
</form>
