<div class="overflow-auto h-fit max-h-96 space-y-1.5 p-1">
  @php
    $characterTrait = $character->trait();
    $characterSubtrait = $character->subtrait();
  @endphp
  <input name="trait" id="trait" type="hidden" value="{{ $characterTrait ? $characterTrait->id : '' }}">
  <input name="subtrait" id="subtrait" type="hidden" value="{{ $characterSubtrait ? $characterSubtrait->id : '' }}">
  
  @foreach ($traits as $trait)
    <div
      id="trait-{{ $trait->id }}"
      class="border border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 rounded overflow-hidden opacity-50 cursor-pointer hover:shadow"
      data-id="{{ $trait->id }}"
      data-subtrait="{{ $trait->subtrait }}"
      onclick="selectTrait(this)"
    >
      <div class="border-b bg-{{ $trait->subtrait ? 'blue' : 'green' }}-100 border-{{ $trait->subtrait ? 'blue' : 'green' }}-300 px-1">
        <div class="font-bold uppercase">
          {{ $trait->name }}
        </div>
        @if($trait->subtrait)
          <div class="text-xs">
            {{ __('traits.subtrait') }}
          </div>
        @endif
      </div>

      <div class="bg-{{ $trait->subtrait ? 'blue' : 'green' }}-50 px-1 text-sm italic border-b border-{{ $trait->subtrait ? 'blue' : 'green' }}-200">
        {{ __('traits.races') }}: {{ $trait->races }}
      </div>
      <div class="prose markdown p-1 min-w-full text-sm">{!! $trait->description !!}</div>
    </div>
  @endforeach
</div>

<x-form.input name="note_trait" placeholder="{{ __('traits.placeholder.note_trait') }}" :value="old('note_trait', $characterTrait->pivot->note)" />
<x-form.input name="note_subtrait" placeholder="{{ __('traits.placeholder.note_subtrait') }}" :value="old('note_subtrait', $characterSubtrait->pivot->note)" />
<x-form.error name="traits" />
