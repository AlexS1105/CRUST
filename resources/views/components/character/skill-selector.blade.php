@php use App\Enums\CharacterStat; @endphp
<div class="grid grid-cols-1 lg:grid-cols-2 gap-2 dark:text-gray-100">
    @foreach($skills as $stat => $skillGroup)
        @php
            $statEnum = App\Enums\CharacterStat::from($stat);
        @endphp
        <div class="bg-{{ $statEnum->color() }}-100 dark:bg-{{ $statEnum->color() }}-400 rounded-xl p-2">
            <div
                class="uppercase bg-{{ $statEnum->color() }}-300 dark:bg-{{ $statEnum->color() }}-500 text-center rounded-full font-bold">
                <div class="dark:drop-shadow-xs">
                    {{ $statEnum->localized() }}
                </div>
            </div>

            <div class="p-1 space-y-1">
                @foreach($skillGroup as $skill)
                    <div
                        class="bg-{{ $statEnum->color() }}-200 dark:bg-{{ $statEnum->color() }}-500 rounded-lg p-2 sm:flex justify-between items-center gap-2">
                        <div class="text-lg dark:drop-shadow-xs {{ $skill->proficiency ? 'font-bold' : '' }}">
                            {{ $skill->name }}
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="text-center">
                                <div class="text-xs dark:drop-shadow-xs">
                                    {{ __('skills.cost') }}
                                </div>
                                <div class="text-xl font-bold dark:drop-shadow-xs" id="skill-{{ $skill->id }}">
                                    0
                                </div>
                            </div>
                            <select class="rounded-lg dark:bg-gray-700"
                                    name="skills[{{ $skill->id }}][level]"
                                    data-skill-id="{{ $skill->id }}"
                                    oninput="updateSkills()"
                            >
                                @for($i = 0; $i < 4; $i++)
                                    <option value="{{ $i }}"
                                        @selected(old('skills.' . $skill->id . '.level', $character->skills->find($skill->id)?->pivot->level) == $i)>
                                        {{ __('skills.level.' . $i) }}
                                    </option>
                                @endfor
                            </select>

                            @can('update-charsheet-gm', $character)
                                <select class="rounded-lg dark:bg-gray-700"
                                        name="skills[{{ $skill->id }}][stat]">
                                    <option value="" @selected(old('skills.' . $skill->id . '.stat', $character->skills->find($skill->id)?->pivot->stat ?? $skill->stat) == null)>
                                        {{ __('skills.default') }}
                                    </option>
                                    @foreach(CharacterStat::cases() as $stat)
                                        @continue($stat == $skill->stat)

                                        <option value="{{ $stat }}"
                                            @selected(old('skills.' . $skill->id . '.stat', $character->skills->find($skill->id)?->pivot->stat) == $stat)>
                                            {{ __('stat.' . $stat->value) }}
                                        </option>
                                    @endforeach
                                </select>
                            @endcan
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<x-tip text="character.skills"/>
<x-form.error name="skills"/>

<div class="font-bold text-lg text-right flex justify-end dark:text-gray-300">
    <div class="mr-2">
        {{ __('charsheet.points.skills') }}
    </div>
    <div class="mr-2" id="skills-cost">
        0
    </div>
    /
    <div class="ml-2" id="skill-points">
        {{ old('skill_points', $character->skill_points) }}
    </div>
</div>

@can('update-charsheet-gm', $character)
    <x-form.input name="skill_points"
                  type="number"
                  required
                  min="0"
                  max="1000"
                  onchange="updateSkillPoints()"
                  :value="old('skill_points', $character->skill_points)"
    />

    <x-form.error name="skill_points"/>
@endcan


@push('scripts')
    <script>
        let maxSkills = @json($character->skill_points)
    </script>
@endpush
