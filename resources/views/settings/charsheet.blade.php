@extends('layouts.app')

@section('header', __('settings.index'))

@section('content')
    <x-container class="max-w-3xl">
        <form method="POST" action="{{ route('settings.charsheet.update') }}">
            @csrf
            @method('PATCH')

            <x-form.card>
                <x-form.input name="max_perks" type="number" min="0" max="100"
                              :value="old('max_perks', $settings->max_perks)"/>
                <x-form.input name="perk_points" type="number" min="0" max="100"
                              :value="old('perk_points', $settings->perk_points)"/>
                <x-form.input name="additional_perk_points" type="number" min="0" max="100"
                              :value="old('additional_perk_points', $settings->additional_perk_points)"/>
                <x-form.input name="skill_points" type="number" min="0" max="100"
                              :value="old('skill_points', $settings->skill_points)"/>
                <x-form.input name="additional_skill_points" type="number" min="0" max="100"
                              :value="old('additional_skill_points', $settings->additional_skill_points)"/>
                <x-form.input name="talent_points" type="number" min="0" max="100"
                              :value="old('talent_points', $settings->talent_points)"/>
                <x-form.input name="additional_talent_points" type="number" min="0" max="100"
                              :value="old('additional_talent_points', $settings->additional_talent_points)"/>

                <x-form.input name="min_estitence" type="number" min="0"
                              :value="old('min_estitence', $settings->min_estitence)"/>
                <x-form.input name="max_estitence" type="number" min="0"
                              :value="old('max_estitence', $settings->max_estitence)"/>
                <x-form.input name="safe_estitence" type="number" min="0"
                              :value="old('safe_estitence', $settings->safe_estitence)"/>
                <x-form.input name="default_estitence" type="number" min="0"
                              :value="old('default_estitence', $settings->default_estitence)"/>
                <x-form.input name="additional_estitence" type="number" min="0"
                              :value="old('additional_estitence', $settings->additional_estitence)"/>

                <x-button-submit/>
            </x-form.card>
        </form>
    </x-container>
@endsection
