<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('traits.index') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-screen space-y-8">
    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4">
      <a class="flex max-w-fit space-x-2 items-center font-bold text-gray-600" href="{{ route('traits.create') }}">
        <div class="far fa-plus-square text-xl"></div>
        <div class="text-lg">
          {{ __('traits.create') }}
        </div>
      </a>
      @if (count($traits))
        @foreach ($traits as $trait)
          <div class="border border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 rounded-xl overflow-hidden">
            <div class="border-b bg-{{ $trait->subtrait ? 'blue' : 'green' }}-100 border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 py-2 px-3">
              <div class="flex items-center font-bold text-lg uppercase space-x-2">
                <div>
                  {{ $trait->name }}
                </div>
                <a class="fas fa-edit text-xl text-gray-600" href="{{ route('traits.edit', $trait) }}"></a>
  
                <form method="POST" action="{{ route('traits.destroy', $trait) }}">
                  @method('DELETE')
                  @csrf
    
                  <a class="fas fa-trash cursor-pointer text-xl text-gray-600" onclick="event.preventDefault();this.closest('form').submit();"></a>
                </form>
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
  </x-container>
</x-app-layout>
