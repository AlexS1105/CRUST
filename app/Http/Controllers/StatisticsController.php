<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;

class StatisticsController extends Controller
{
    public function summary(StatisticsService $service)
    {
        $summary = $service->summary();

        return view('statistics.summary', compact('summary'));
    }
}
