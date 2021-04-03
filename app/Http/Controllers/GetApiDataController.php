<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
//use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
class GetApiDataController extends Controller
{

    public function getAll(){

       

        $url = 'http://localhost/alquilados/public/api/v1/auth/anuncios/';


        $response = Http::withHeaders([

            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTVjMzE2MWQ3MDI3NDRjYmI1YWIxNjQzOTZkMWRjY2IzMGI3OWMzNTA4NjQ1NDE3MGNjZjQ2OWRmOTMzYjA1YTY5MjllZjRiNjg5MmNlN2QiLCJpYXQiOjE2MTcwODA0MjAsIm5iZiI6MTYxNzA4MDQyMCwiZXhwIjoxNjMyOTc4MDIwLCJzdWIiOiI3NyIsInNjb3BlcyI6W119.mhyM0W1uqFgXDtwlTzczz1abOYQXja1Wuz8og34RWv6ErdTohbbP0FziuIo5FojcLeyrpbhPNV2JGXEcr8YF_QEuuP-oN8chFrhUhvhBUUydpuV4demtO3nTFdc1NXqEYMtMbX3DeHZgzZ92imlAHB2R622MFGgxS-8zv25joDmDCkw1Ws_qbYzxJFkCdmAEHHflaA77Pl2YdNWVmwlBsPNMfaAfJr7K2Q8_33Wl5UXNJEoOvHbMfsqEYzJItKwmaoHIbSCyeweLEoT4ejA2y-5uC1glrJ87pKPJKubdJNxJmncgbAK1oAx9pb-NS5jzvSE74cMbJ6WaQRISpLwg781Retbgq-TrUMRfsIczXPWmLuvXyUJyXlfCSkkZufoVN6_JoKBBpq3dJEUrHNqpTirxzdc6voIx0plhduxd5cP8Ltt1chU1snhoGXCDcEtbA1ouGRwfZ4hfkSLUtiK3p9keRriBlZXbcFhzI-pdpxpqeKLZceEcELxpstYxHdF0m9CQ0fsLTonMT_a7ZooZIas4MuFV7GZihcpjEqbs_xTyUC0OYiWFQZ8ssWSLQ5T_h1hyjju7_QswdJNg4ANRyLvBwgPhQYbce_60qdS4BI_Lp3vej_lBavxLVoAVcl9xru5nDpc-wuEgy1DJtZMmoAz8RsRC8o2EFQyIoPsuabE',
            
        ])->get( $url );

        $response->json();
        
       return $response;
    }
    
    public function create(Request $request){

      

        $url = 'http://localhost/alquilados/public/api/v1/auth/create/';

        

        $response = Http::attach(

            'attachment', file_get_contents('../public/anounces/22/605fd8a9821b9-1.jpg'), 'imagen_api.jpg',[
            'Content-Type' => ['application/json', 'image/jpeg'],
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTVjMzE2MWQ3MDI3NDRjYmI1YWIxNjQzOTZkMWRjY2IzMGI3OWMzNTA4NjQ1NDE3MGNjZjQ2OWRmOTMzYjA1YTY5MjllZjRiNjg5MmNlN2QiLCJpYXQiOjE2MTcwODA0MjAsIm5iZiI6MTYxNzA4MDQyMCwiZXhwIjoxNjMyOTc4MDIwLCJzdWIiOiI3NyIsInNjb3BlcyI6W119.mhyM0W1uqFgXDtwlTzczz1abOYQXja1Wuz8og34RWv6ErdTohbbP0FziuIo5FojcLeyrpbhPNV2JGXEcr8YF_QEuuP-oN8chFrhUhvhBUUydpuV4demtO3nTFdc1NXqEYMtMbX3DeHZgzZ92imlAHB2R622MFGgxS-8zv25joDmDCkw1Ws_qbYzxJFkCdmAEHHflaA77Pl2YdNWVmwlBsPNMfaAfJr7K2Q8_33Wl5UXNJEoOvHbMfsqEYzJItKwmaoHIbSCyeweLEoT4ejA2y-5uC1glrJ87pKPJKubdJNxJmncgbAK1oAx9pb-NS5jzvSE74cMbJ6WaQRISpLwg781Retbgq-TrUMRfsIczXPWmLuvXyUJyXlfCSkkZufoVN6_JoKBBpq3dJEUrHNqpTirxzdc6voIx0plhduxd5cP8Ltt1chU1snhoGXCDcEtbA1ouGRwfZ4hfkSLUtiK3p9keRriBlZXbcFhzI-pdpxpqeKLZceEcELxpstYxHdF0m9CQ0fsLTonMT_a7ZooZIas4MuFV7GZihcpjEqbs_xTyUC0OYiWFQZ8ssWSLQ5T_h1hyjju7_QswdJNg4ANRyLvBwgPhQYbce_60qdS4BI_Lp3vej_lBavxLVoAVcl9xru5nDpc-wuEgy1DJtZMmoAz8RsRC8o2EFQyIoPsuabE'
            ]
        )
       // ->withHeaders(['Content-Type' => ['application/json', 'image/jpeg'],
       //                'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNTVjMzE2MWQ3MDI3NDRjYmI1YWIxNjQzOTZkMWRjY2IzMGI3OWMzNTA4NjQ1NDE3MGNjZjQ2OWRmOTMzYjA1YTY5MjllZjRiNjg5MmNlN2QiLCJpYXQiOjE2MTcwODA0MjAsIm5iZiI6MTYxNzA4MDQyMCwiZXhwIjoxNjMyOTc4MDIwLCJzdWIiOiI3NyIsInNjb3BlcyI6W119.mhyM0W1uqFgXDtwlTzczz1abOYQXja1Wuz8og34RWv6ErdTohbbP0FziuIo5FojcLeyrpbhPNV2JGXEcr8YF_QEuuP-oN8chFrhUhvhBUUydpuV4demtO3nTFdc1NXqEYMtMbX3DeHZgzZ92imlAHB2R622MFGgxS-8zv25joDmDCkw1Ws_qbYzxJFkCdmAEHHflaA77Pl2YdNWVmwlBsPNMfaAfJr7K2Q8_33Wl5UXNJEoOvHbMfsqEYzJItKwmaoHIbSCyeweLEoT4ejA2y-5uC1glrJ87pKPJKubdJNxJmncgbAK1oAx9pb-NS5jzvSE74cMbJ6WaQRISpLwg781Retbgq-TrUMRfsIczXPWmLuvXyUJyXlfCSkkZufoVN6_JoKBBpq3dJEUrHNqpTirxzdc6voIx0plhduxd5cP8Ltt1chU1snhoGXCDcEtbA1ouGRwfZ4hfkSLUtiK3p9keRriBlZXbcFhzI-pdpxpqeKLZceEcELxpstYxHdF0m9CQ0fsLTonMT_a7ZooZIas4MuFV7GZihcpjEqbs_xTyUC0OYiWFQZ8ssWSLQ5T_h1hyjju7_QswdJNg4ANRyLvBwgPhQYbce_60qdS4BI_Lp3vej_lBavxLVoAVcl9xru5nDpc-wuEgy1DJtZMmoAz8RsRC8o2EFQyIoPsuabE'],
        // )
        ->post( $url );

        

        //$client = new Client();
        //$request = new Request('GET', $url);
        //$response = $client->request('POST', $url);
        
         dd(['getdatapi',$response]);
        dd('getDataApi');
       //return $response;
    }

}
