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

    public function rules()
    {
        $character = $this->route('character');

        return [
            'stats' => ['required', new StatPool($character), new StatUpdate($character)],
            'stats.*' => ['numeric', 'min:1'],
        ];
    }
}
