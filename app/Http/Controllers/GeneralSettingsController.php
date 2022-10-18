<?php

namespace App\Http\Controllers;

use App\Http\Requests\GeneralSettingsRequest;
use App\Settings\GeneralSettings;

class GeneralSettingsController extends Controller
{
    public function show(GeneralSettings $settings)
    {
        return view('settings.general', compact('settings'));
    }

    public function update(GeneralSettings $settings, GeneralSettingsRequest $request)
    {
        $settings->update($request->validated());

        return back();
    }
}
