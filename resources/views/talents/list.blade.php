@extends('layouts.base')

@section('body')
    <div class="p-6 space-y-4 bg-white">
        @if ($talents->isNotEmpty())
            @foreach ($talents as $talent)
                <x-talent-card :talent="$talent" :accordion="false" />
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                {{ __('talents.empty') }}
            </p>
        @endif
    </div>
@endsection
