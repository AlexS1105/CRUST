<?php

namespace App\Http\Controllers;

use App\Jobs\RevokeOldTokens;
use Illuminate\Http\Request;

class WikiController extends Controller
{
    public function __invoke(Request $request)
    {
        RevokeOldTokens::dispatch(auth()->user()->id);

        return redirect()->away(
            auth()->user()->tokens->where('client_id', config('services.wiki.client_id'))->first() !== null ?
                config('services.wiki.url') : config('services.wiki.oauth2')
        );
    }
}
