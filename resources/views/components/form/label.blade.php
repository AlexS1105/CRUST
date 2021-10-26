@props(['name', 'label' => ''])

<label class="block mb-2 uppercase font-bold text-xs text-gray-700"
  for="{{ $name }}"
>
  {!! ucwords(__('label.'.$name)) !!}
</label>
