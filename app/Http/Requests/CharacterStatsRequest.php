<?php

namespace App\Http\Requests;

use App\Rules\StatPool;
use App\Rules\StatUpdate;
use Illuminate\Foundation\Http\FormRequest;

class CharacterStatsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'stats_handled' => $this->stats_handled === 'on',
            'estitence_reduce' => $this->estitence_reduce === 'on',
        ]);
    }

    public function rules()
    {
        $character = $this->route('character');
        $rules = [
            'stats' => ['required', new StatPool($character), new StatUpdate($character)],
            'stats.*' => ['numeric', 'min:1'],
        ];

        if (auth()->user()?->can('update-charsheet-gm', $character)) {
            $rules = array_merge($rules, [
                'stats_handled' => ['sometimes', 'boolean'],
                'estitence_reduce' => ['sometimes', 'boolean'],
            ]);
        }

        return $rules;
    }
}
