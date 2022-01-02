<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('perks.index') }}
    </h2>
  </x-slot>
  
  <x-container class="max-w-screen space-y-8">
    <div class="bg-white rounded-xl max-w-3xl mx-auto shadow-lg place-self-start p-6 space-y-4">
      @foreach ($perks as $perk)
        <div class="border border-gray-400 rounded-xl overflow-hidden">
          <div class="flex justify-between border-b bg-gray-100 border-gray-400">
            <div class="font-bold text-lg py-2 px-3 uppercase">
              {{ $perk->name }}
            </div>
            <div class="p-2 text-center font-bold text-lg border-gray-400 border-l">
              {{ $perk->cost }}
            </div>
          </div>

          <div class="divide-y divide-dashed">
            @foreach ($perk->variants as $perkVariant)
              <div class="p-2">
                <div class="prose markdown">{!! $perkVariant->description !!}</div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach

      {{ $perks->links() }}
    </div>
  </x-container>
</x-app-layout>
