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
            auth()->user()->tokens->where('client_id', env('WIKI_CLIENT_ID'))->first() !== null ?
                env('WIKI_URL') : env('WIKI_OAUTH2_URL')
        );
    }
}
