<div {{ $attributes->merge(['class' => 'border border-'.($trait->subtrait ? 'blue' : 'green').'-300 rounded-xl overflow-hidden']) }}>
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
  @if($trait->pivot->note)
    <div class="bg-{{ $trait->subtrait ? 'blue' : 'green' }}-50 px-2 py-0.5 italic border-t border-{{ $trait->subtrait ? 'blue' : 'green' }}-200">
      {{ $trait->pivot->note }}
    </div>
  @endif
</div>
