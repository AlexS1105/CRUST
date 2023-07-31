<x-form.base action="{{ $action }}" :method="$method">
    <x-form.card>
        <x-form.input name="name"
                      required
                      maxlength="256"
                      :value="old('name', @$skill?->name)"
        />

        <x-form.input name="description"
                      maxlength="1024"
                      :value="old('description', @$skill?->description)"
        />

        <x-form.select required
                       :name="'stat'"
                       :values="App\Enums\CharacterStat::cases()"
                       :labels="array_map(function($stat) { return $stat->localized(); }, App\Enums\CharacterStat::cases())"
                       :value="old('stat', @$skill?->stat)"
        />

        <x-form.checkbox name="proficiency"
                         value="{{ old('proficiency', @$skill?->proficiency ?? false) }}"
        />

        <x-button-submit/>
    </x-form.card>
</x-form.base>
