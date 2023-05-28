@props(['active', 'disabled' => false])

@php
    $classes = ($active ?? false)
          ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 text-lg font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 dark:border-indigo-600 transition duration-150 ease-in-out'
          : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-lg font-medium leading-5 text-gray-500 dark:text-gray-300 hover:text-gray-700 hover:border-gray-300 dark:hover:border-gray-500 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';

    if($disabled) {
      $classes = $classes.' pointer-events-none';
    }
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
