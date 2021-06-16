<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;


class WeatherController extends Controller
{
    protected $apiKey = '61602fdf32b83f2004c9f3f2046a1fdb';
    protected $url = 'http://api.openweathermap.org/data/2.5/weather';

    public function getWeather($lat = false, $lon = false)
    {

        $this->url = $this->url . '?lat=' . $lat . '&lon=' . $lon . '&appid=' . $this->apiKey;

        $response = Http::withHeaders([

            'Content-Type' => 'application/json',

        ])->get($this->url);

        if ($response || $response != null) {
            $response = json_decode($response);
            //devolvemops solo el nombre de la ciudad por ahora, tambien esta temperatura, humedad, sensacion termica....
            $city = $response->name;
            $response = response($response->name);
            //creamos una cookie con la city para 30 dias
            $cookieCity = cookie('city', $city, 30 * 24 * 60);
            $response->withCookie($cookieCity);

            return $response;
        } else {

            return false;
        }
    }
}