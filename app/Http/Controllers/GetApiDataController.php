<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7;
use Illuminate\Support\Facades\Auth;
//use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use CURLFile;

class GetApiDataController extends Controller

{

    public function getAll()
    {



        $url = 'http://localhost/alquilados/public/api/v1/auth/anuncios/';


        $response = Http::withHeaders([

            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTVjMzE2MWQ3MDI3NDRjYmI1YWIxNjQzOTZkMWRjY2IzMGI3OWMzNTA4NjQ1NDE3MGNjZjQ2OWRmOTMzYjA1YTY5MjllZjRiNjg5MmNlN2QiLCJpYXQiOjE2MTcwODA0MjAsIm5iZiI6MTYxNzA4MDQyMCwiZXhwIjoxNjMyOTc4MDIwLCJzdWIiOiI3NyIsInNjb3BlcyI6W119.mhyM0W1uqFgXDtwlTzczz1abOYQXja1Wuz8og34RWv6ErdTohbbP0FziuIo5FojcLeyrpbhPNV2JGXEcr8YF_QEuuP-oN8chFrhUhvhBUUydpuV4demtO3nTFdc1NXqEYMtMbX3DeHZgzZ92imlAHB2R622MFGgxS-8zv25joDmDCkw1Ws_qbYzxJFkCdmAEHHflaA77Pl2YdNWVmwlBsPNMfaAfJr7K2Q8_33Wl5UXNJEoOvHbMfsqEYzJItKwmaoHIbSCyeweLEoT4ejA2y-5uC1glrJ87pKPJKubdJNxJmncgbAK1oAx9pb-NS5jzvSE74cMbJ6WaQRISpLwg781Retbgq-TrUMRfsIczXPWmLuvXyUJyXlfCSkkZufoVN6_JoKBBpq3dJEUrHNqpTirxzdc6voIx0plhduxd5cP8Ltt1chU1snhoGXCDcEtbA1ouGRwfZ4hfkSLUtiK3p9keRriBlZXbcFhzI-pdpxpqeKLZceEcELxpstYxHdF0m9CQ0fsLTonMT_a7ZooZIas4MuFV7GZihcpjEqbs_xTyUC0OYiWFQZ8ssWSLQ5T_h1hyjju7_QswdJNg4ANRyLvBwgPhQYbce_60qdS4BI_Lp3vej_lBavxLVoAVcl9xru5nDpc-wuEgy1DJtZMmoAz8RsRC8o2EFQyIoPsuabE',

        ])->get($url);


        return response()->json(['message' => 'Data found',  'data' => $response->json()], 200);
    }




    public function create(Request $request, $url, $img)
    {

        //return response()->json(['error' => 'No valid JSON'], 406);

        $url_ = base64_decode($url);
        $image = base64_decode($img);
        $imageContent = Psr7\Utils::tryFopen($image, 'r');
        $data = $request->get('data');
        $data = json_encode($data);

        $url_ = 'http://localhost/alquilados/public/api/v1/';
        //$imagePortatil = '../public/anounces/22/6044d31587896-5.jpg';
        //$image = '../public/anounces/22/605fd8a9821b9-1.jpg';



        $client = new \GuzzleHttp\Client(['base_uri' => $url_]);
        $response = $client->post('create', [
            'multipart' => [

                [
                    'name'     => 'image1',
                    'contents' => $imageContent,
                    'headers'  => [

                        'Content-Type' =>  'image/jpeg',
                        'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjEwNmMxYTc2ODNkNGQ1YzE1ZjFlNmJlZTcwYjRjMjcyZmVjZTViMmNjZGE0MzQ5ZjgzNDQ1Mjg5ZWNlMDcyNzA4YTUxZGQxODU5NWZiOTAiLCJpYXQiOjE2MTc1NTIxOTEsIm5iZiI6MTYxNzU1MjE5MSwiZXhwIjoxNjI1NDE0NTkwLCJzdWIiOiI4MyIsInNjb3BlcyI6W119.RIBeCBR8y8eTwymlCLL4K3NKDjj6dOpm-E_gnmBbAVLCromDMV5rTMwA0CFg-F-JSNDk3iBZljejbxhoQAfiUJAoGzcu17_aHrcnA6S1wBsUi65eOnDbAkDNsAVyvtOO_3oFRddU6J7zJ4jH8MfLYnz0_7E05fBPh58jEipqr5NXkELfFMEjynnZExLo1nWObOTwmSzTInVWld_Nals3RHyv6-SWKq1_b0VER9VI-aqARObDsjO9g_zl3AacO5Ej6IN3wlQWVUwJ2R7kDtRy09dtWILjipXlSZ4gsed99Ucta88njbFvsmQcWrrfB8XGnN2GHqrwP58Glvyl6KxXrQJqQ7HPMdmufn2jrzvl5Nn0jWJc8aPKboRF2sngznVN3hgqQHuuTbybo6S1Sq_fSFYWzZPIOlQIgRaqTkF72nF0_8KahuCCkhrcq4kNf7HSbveP3OEaJ_dxWcBk7BLTvISqvAwAgh350-jge9UNm8Yjb6FfEj5DyZbmQzC2gczrMvHF0GydhGVmuo82FJK30Mm9-s-nXj7wlPdlyhqLyVMj-WHcjnzwxogXCaLEKMl4cBA9ABlHJRUdYz4aHJGKHCs8hZ1l8ysUJkVTngmHodQIG99HvYXbiTq4PCoVHXP9c-3ydh2JOIAS7TxD48bLeZn6GPk1COocL_A2L-rUN8w',
                        'Accept-Encoding' =>  'gzip, deflate, br',
                        'Connection' => 'keep-alive',
                        'Accept' => '*/*'
                    ],


                ],
                [
                    'name'     => 'json',
                    'contents' => $data,
                    'headers'  => [

                        'Content-Type' =>  'application/json',
                        'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjEwNmMxYTc2ODNkNGQ1YzE1ZjFlNmJlZTcwYjRjMjcyZmVjZTViMmNjZGE0MzQ5ZjgzNDQ1Mjg5ZWNlMDcyNzA4YTUxZGQxODU5NWZiOTAiLCJpYXQiOjE2MTc1NTIxOTEsIm5iZiI6MTYxNzU1MjE5MSwiZXhwIjoxNjI1NDE0NTkwLCJzdWIiOiI4MyIsInNjb3BlcyI6W119.RIBeCBR8y8eTwymlCLL4K3NKDjj6dOpm-E_gnmBbAVLCromDMV5rTMwA0CFg-F-JSNDk3iBZljejbxhoQAfiUJAoGzcu17_aHrcnA6S1wBsUi65eOnDbAkDNsAVyvtOO_3oFRddU6J7zJ4jH8MfLYnz0_7E05fBPh58jEipqr5NXkELfFMEjynnZExLo1nWObOTwmSzTInVWld_Nals3RHyv6-SWKq1_b0VER9VI-aqARObDsjO9g_zl3AacO5Ej6IN3wlQWVUwJ2R7kDtRy09dtWILjipXlSZ4gsed99Ucta88njbFvsmQcWrrfB8XGnN2GHqrwP58Glvyl6KxXrQJqQ7HPMdmufn2jrzvl5Nn0jWJc8aPKboRF2sngznVN3hgqQHuuTbybo6S1Sq_fSFYWzZPIOlQIgRaqTkF72nF0_8KahuCCkhrcq4kNf7HSbveP3OEaJ_dxWcBk7BLTvISqvAwAgh350-jge9UNm8Yjb6FfEj5DyZbmQzC2gczrMvHF0GydhGVmuo82FJK30Mm9-s-nXj7wlPdlyhqLyVMj-WHcjnzwxogXCaLEKMl4cBA9ABlHJRUdYz4aHJGKHCs8hZ1l8ysUJkVTngmHodQIG99HvYXbiTq4PCoVHXP9c-3ydh2JOIAS7TxD48bLeZn6GPk1COocL_A2L-rUN8w',
                        'Accept-Encoding' =>  'gzip, deflate, br',
                        'Connection' => 'keep-alive',
                        'Accept' => '*/*'
                    ],
                ],
            ],

        ]);


        $statusCode = $response->getStatusCode();
        $headers = $response->getHeaders();

        if ($statusCode == 201) {
            $data = ['message' => 'Created'];
            return response()->json(['message' => 'Created',  'statusCode' => $statusCode, 'headers' => $headers], 201);
        } else {

            $data = $request->json();
            return response()->json(['message' => 'Not created', 'data' => $data,  'statusCode' => $statusCode], 200);
        }
    }
}