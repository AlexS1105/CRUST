@props(['name', 'label' => ''])

<label {{ $attributes->merge([ 'class' => 'block uppercase text-xs text-gray-700']) }}
  for="{{ $name }}"
>
  {!! ucwords(__('label.'.$name)) !!}
</label>
