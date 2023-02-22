<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetSettingsRequest;
use App\Services\SettingsService;
use App\Settings\CharsheetSettings;

class CharsheetSettingsController extends Controller
{
    public function show(CharsheetSettings $settings)
    {
        return view('settings.charsheet', compact('settings'));
    }

    public function update(CharsheetSettingsRequest $request, CharsheetSettings $settings, SettingsService $service)
    {
        $service->update($settings, $request);

        return back();
    }
}
