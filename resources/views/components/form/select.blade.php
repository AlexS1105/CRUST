<x-form.field>
    <x-form.label name="{{ $name }}"/>

    <select name="{{ $name }}" id="{{ $name }}" class="form-select block w-full mt-1" @disabled($disabled)>
        @foreach ($values as $_value)
            <option
                {{ $value === $_value ? 'selected' : '' }} value="{{$_value}}">{{ isset($labels) ? $labels[$loop->index] : $_value }}</option>
        @endforeach
    </select>

    <x-form.error name="{{ $name }}"/>
</x-form.field>
