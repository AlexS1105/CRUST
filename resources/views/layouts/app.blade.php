@extends('layouts.base')

@section('body')
    <header class="bg-white dark:bg-gray-800 shadow">
        @include('layouts.navigation')

        @hasSection('header')
            @sectionMissing('title')
                @section('title')
                    @yield('header')
                @endsection
            @endif

            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-400 leading-tight">
                    @yield('header')
                </h2>
            </div>
        @endif
    </header>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
@endsection
