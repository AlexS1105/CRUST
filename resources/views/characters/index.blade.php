@extends('layouts.app')

@section('header', __('characters.index'))

@section('content')
    <x-character.list :characters="$characters">
        @can('create', App\Models\Character::class)
            <x-character.new :href="route('characters.create')"/>
        @endcan
    </x-character.list>

    @cannot('create', App\Models\Character::class)
        @if (!count($characters))
            <x-text-bg>
                {{ __('characters.empty') }}
            </x-text-bg>
        @endif
    @endcannot
@endsection
