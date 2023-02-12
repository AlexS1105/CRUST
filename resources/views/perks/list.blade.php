@extends('layouts.base')

@section('body')
<div class="z-10 p-2 fixed top-0 w-full bg-white border-b">
    <x-search-field :search="$search" :route="route('perks.list')"/>
</div>

    <div class="mt-12"></div>

    <div class="p-6 space-y-4">
        @if (count($perks))
            @foreach ($perks as $perk)
                <div class="border border-gray-400 rounded-xl overflow-hidden">
                    <div class="flex justify-between border-b bg-gray-100 border-gray-400">
                        <div class="flex font-bold text-lg">
                            <div class="p-2 border-r border-gray-400">
                                {{ $perk->cost }}
                            </div>
                            <div class="p-2 uppercase">
                                {{ $perk->name }}
                            </div>
                        </div>
                    </div>
                    <div class="divide-y divide-dashed">
                        @if (isset($perk->description))
                            <x-markdown class="p-2 min-w-full bg-gray-50">{!! $perk->description !!}</x-markdown>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <p class="pt-4 text-xl font-semibold text-gray-500 text-center">
                {{ __('perks.empty') }}
            </p>
        @endif

        {{ $perks->appends(request()->query())->links() }}
    </div>
@endsection
