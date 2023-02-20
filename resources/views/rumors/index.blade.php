@extends('layouts.app')

@section('header', __('rumors.index'))

@section('content')
    <x-container>
        <x-card>
            <x-tip class="text-center mb-4" text="rumors.cooldown" />

            <div class="space-y-2">
                @foreach($rumors as $rumor)
                    <x-rumor :rumor="$rumor" self="{{ ! auth()->user()->can('see-index', Rumor::class) }}" />
                @endforeach

                @if($rumors->isEmpty())
                    <p class="text-xl font-semibold text-gray-500 text-center">
                        {{ __('rumors.empty') }}
                    </p>
                @endif
            </div>

            {{ $rumors->links() }}
        </x-card>
    </x-container>
@endsection
