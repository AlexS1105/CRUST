<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharsheetSettingsRequest;
use App\Settings\CharsheetSettings;

class CharsheetSettingsController extends Controller
{
    public function show(CharsheetSettings $settings)
    {
        return view('settings.charsheet', compact('settings'));
    }

    public function update(CharsheetSettingsRequest $request, CharsheetSettings $settings)
    {
        $settings->update($request->validated());

        return back();
    }
}
