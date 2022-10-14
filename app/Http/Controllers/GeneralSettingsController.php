<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralSettingsRequest;
use App\Settings\GeneralSettings;

class GeneralSettingsController extends Controller
{
    public function show()
    {
        return view('settings.general', [
            'settings' => app(GeneralSettings::class),
        ]);
    }

    public function update(GeneralSettingsRequest $request)
    {
        app(GeneralSettings::class)->update($request->validated());
        return back();
    }
}
