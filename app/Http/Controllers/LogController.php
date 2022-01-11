<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        return view('logs.index');
    }

    public function ingame()
    {
        return view('logs.ingame');
    }
}
