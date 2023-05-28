<form method="{{ $method }}" action="{{ $href }}">
    @csrf

    @if (isset($bladeMethod))
        @method($bladeMethod)
    @endif

    <a {{ $attributes->merge(['class' => 'block px-4 py-2 text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-700 transition duration-150 ease-in-out']) }}
       onclick="event.preventDefault();
      this.closest('form').submit();"
    >
        {{ $slot }}
    </a>
</form>
