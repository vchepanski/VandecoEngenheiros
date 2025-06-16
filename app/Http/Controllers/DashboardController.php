<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;

class DashboardController extends Controller
{
    public function index(WeatherService $weather)
    {
        $data = $weather->getCurrentWeather('Palmeira');

        return view('dashboard.index', compact('data'));
    }
}
