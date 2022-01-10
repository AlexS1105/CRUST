<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
  </head>
  <body class="font-sans antialiased bg-white">
    <div class="z-10 p-2 fixed top-0 w-full bg-white border-b">
      <div class="p-1 mb-2 space-x-2">
        <a href="{{ route('traits.list', ['subtrait' => !$subtrait]) }}" class="bg-blue-200 px-2 rounded-full {{ $subtrait ? '' : 'opacity-50' }}">
          {{ __('traits.subtrait') }}
        </a>
      </div>
      <x-search-field :search="$search" :route="route('traits.list')"/>
    </div>

    <div class="mt-24"></div>

    <div class="p-6 space-y-4">
      @if (count($traits))
        @foreach ($traits as $trait)
          <div class="border border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 rounded-xl overflow-hidden">
            <div class="border-b bg-{{ $trait->subtrait ? 'blue' : 'green' }}-100 border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 py-2 px-3">
              <div class="flex items-center font-bold text-lg uppercase space-x-2">
                {{ $trait->name }}
              </div>
              @if($trait->subtrait)
                <div class="text-sm">
                  {{ __('traits.subtrait') }}
                </div>
              @endif
            </div>

            <div class="bg-{{ $trait->subtrait ? 'blue' : 'green' }}-50 px-2 py-0.5 italic border-b border-{{ $trait->subtrait ? 'blue' : 'green' }}-200">
              {{ __('traits.races') }}: {{ $trait->races }}
            </div>
            <div class="prose markdown p-2 min-w-full">{!! $trait->description !!}</div>
          </div>
        @endforeach
      @else
        <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
          {{ __('traits.empty') }}
        </p>
      @endif
      {{ $traits->links() }}
    </div>
  </body>
</html>
