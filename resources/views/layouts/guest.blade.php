@extends('layouts.base')

@section('body')
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-600">
            <a href="/">
                <x-application-logo class="w-80 h-80 fill-current text-gray-500"/>
            </a>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-700 shadow-md overflow-hidden sm:rounded-lg">
                @yield('content')
            </div>
        </div>
    </div>
@endsection
