@extends('layouts.base')

@section('body')
    <div class="p-6 space-y-4 bg-white">
        @if ($techniques->isNotEmpty())
            @foreach ($techniques as $technique)
                <x-technique-card :technique="$technique" :accordion="false" />
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                {{ __('techniques.empty') }}
            </p>
        @endif
    </div>
@endsection
