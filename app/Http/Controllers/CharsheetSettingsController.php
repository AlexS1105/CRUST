<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetSettingsRequest;
use App\Settings\CharsheetSettings;

class CharsheetSettingsController extends Controller
{
    public function show()
    {
        return view('settings.charsheet', [
            'settings' => app(CharsheetSettings::class),
        ]);
    }

    public function update(CharsheetSettingsRequest $request)
    {
        app(CharsheetSettings::class)->update($request->validated());
        return back();
    }
}
