@props(['text', 'method' => 'POST', 'action', 'bladeMethod' => false, 'color', 'colorHover', 'colorRing', 'confirmationText' => "", 'icon', 'tooltip' => "0"])

<form class="m-2" method="{{ $method }}" action="{{ $action }}" {{ $tooltip ? "title=".$text : "" }}>
  @csrf
  @if($bladeMethod)
    @method($bladeMethod)
  @endif

  <button class="px-4 py-2 bg-{{ $color }} hover:bg-{{ $colorHover }} focus:outline-none focus:border-{{ $colorRing }} focus:ring ring-{{ $colorRing }} rounded-full shadow" type="submit" 
  onclick="{{ $confirmationText }}">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>
    @if (!$tooltip)
      <div class="font-bold inline-block ml-1">
        {{ $text }}
      </div>
    @endif
  </button>
</form>
