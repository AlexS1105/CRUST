@extends('layouts.base')

@section('body')
<div class="z-10 p-2 fixed top-0 w-full bg-white dark:bg-gray-600 border-b dark:border-gray-800">
    <x-search-field :search="$search" :route="route('perks.list')"/>
</div>

    <div class="mt-12"></div>

    <div class="p-6 space-y-4">
        @if (count($perks))
            @foreach ($perks as $perk)
                <x-perk-card :perk="$perk" :accordion="false" />
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 dark:bg-gray- text-center">
                {{ __('perks.empty') }}
            </p>
        @endif

        {{ $perks->appends(request()->query())->links() }}
    </div>
@endsection
