<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetSettingsRequest;
use App\Settings\CharsheetSettings;

class CharsheetSettingsController extends Controller
{
    function show()
    {
        return view('settings.charsheet', [
            'settings' => app(CharsheetSettings::class)
        ]);
    }

    function update(CharsheetSettingsRequest $request)
    {
        app(CharsheetSettings::class)->update($request->validated());
        return back();
    }
}
