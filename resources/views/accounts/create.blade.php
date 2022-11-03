@extends('layouts.app')

@section('header', __('accounts.index'))

@section('content')
    <x-container>
        <x-form.base action="{{ route('users.accounts.store', $user) }}" method="POST">
            <x-form.card>
                <x-form.input name="login" required maxlength="16"/>

                <x-button-submit/>
            </x-form.card>
        </x-form.base>
    </x-container>
@endsection
