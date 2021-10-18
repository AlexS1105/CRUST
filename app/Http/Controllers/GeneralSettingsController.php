<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;

use App\Http\Requests\GeneralSettingsRequest;

class GeneralSettingsController extends Controller
{
    function show()
    {
        return view('settings.general', [
            'settings' => app(GeneralSettings::class)
        ]);
    }

    function update(GeneralSettingsRequest $request)
    {
        app(GeneralSettings::class)->update($request->validated());
        return back();
    }
}
