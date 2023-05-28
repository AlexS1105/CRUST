@extends('layouts.base')

@section('body')
    <div class="p-6 space-y-4 bg-white dark:bg-gray-600">
        @if ($skills->isNotEmpty())
            @foreach ($skills as $skill)
                <x-skill :skill="$skill" />
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                {{ __('skills.empty') }}
            </p>
        @endif
    </div>
@endsection
