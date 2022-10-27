<x-button {{ $attributes->merge(['class' => 'bg-indigo-500']) }}
          onclick="window.location.href='{{ $href }}'"
          type="button">
    <div class="fab fa-discord mx-2"></div>
    {{ $slot }}
</x-button>
