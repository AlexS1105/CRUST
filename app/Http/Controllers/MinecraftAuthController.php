<?php

namespace App\Http\Controllers;

use App\Services\MinecraftService;
use Illuminate\Http\Request;

class MinecraftAuthController extends Controller
{
    public function __invoke(MinecraftService $minecraftService, Request $request)
    {
        return $minecraftService->auth($request);
    }
}
