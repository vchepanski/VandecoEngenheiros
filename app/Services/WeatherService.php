<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
public function getCurrentWeather($city = 'Palmeira')
{
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
        'q'     => $city,
        'appid' => env('OPENWEATHER_KEY'),
        'units' => 'metric',
        'lang'  => 'pt_br',
    ]);

    if ($response->successful()) {
        $json = $response->json();

        return [
            'city'        => $json['name'] ?? '',
            'temperature' => $json['main']['temp'] ?? '',
            'description' => $json['weather'][0]['description'] ?? '',
            'humidity'    => $json['main']['humidity'] ?? '',
            'wind_speed'  => $json['wind']['speed'] ?? '',
        ];
    }

    return [
        'error' => 'Erro ao buscar clima da cidade.',
    ];
}

}
