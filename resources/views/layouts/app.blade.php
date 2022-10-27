@extends('layouts.base')

@section('body')
    <header>
        @include('layouts.navigation')

        @hasSection('header')
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    @yield('header')
                </h2>
            </div>
        @endif
    </header>

    <main>
        @yield('content')
    </main>
@endsection
