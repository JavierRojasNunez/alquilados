<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7;
//use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use CURLFile;
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
    
    public function create(){

      

        $url = 'http://localhost/alquilados/public/api/v1/create/';
        

        $response1 = Http::attach(

            'attachment', file_get_contents('../public/anounces/22/605fd8a9821b9-1.jpg'), 'imagen_api.jpg',
            [
            'Content-Type' =>  'image/jpeg',
            'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZTI5NDY4YWY0ZTllNDg3OTYzYjI2ZGRkMWY1NzU0NzE2OTZmNTIzMGI5MmViNjUxYTNlNGE3Zjc3ZGQ0NjA0MjcwNzEzNTYzZGY3ZDE5OWEiLCJpYXQiOjE2MTc0MTg2NjEsIm5iZiI6MTYxNzQxODY2MSwiZXhwIjoxNjI1MjgxMDYxLCJzdWIiOiI4MyIsInNjb3BlcyI6W119.E5Dj72wj_Y1CCVHwBwMMcUIcfJSvh1xKEoni5P2WgJullyzDFz1ZlzAnDStnvuWyT6Qb9VQ0A9w7kkAdM7e9T0NR_Qu1YrWm_oMzEYyTEMqIpVhbSAgoo6X9OPpz37DOJK3Sld4TJxntVs2WM7sKTkz2NsBT9XloXv9ENpX30ieHHfR17a2kLTLuda8Td0_jU07Kaqq91KpUFBnC0r_Wl6FFplyomi0CYYZFKeoS6P4739bk2FkYWn44JJq_DXnclilb8s6XNO3GQdGrSsC6tdm_eI-Zz4CNA5BrgrY8NHuZfoSoZnzMNYSMmuymiyYiSBfQDLRDRM2VoTCI5AQnR08mtiM13NfaNsQp4_3N6VTZcCh93UespC8_fXsMZ9lVUz_I9hDvSW7taxmx5oLFcxal2M0QsKsEB8Aofa_m9Vtu9SOGboWrzK1K8flf1kTBd-uzxRUU_To2A0aKWuvmlgVml96yXQIb7H2SL7ZMUT01TQr0WLuUeza3ibrJ44JBOISlKhRsDwDc6No1SIP7E2rGvYRHZuXZRMfY2R7vqK5lbjUkZ3ueb-DrAZMPbsQhlyXfeMzca5L_VfVju0yYSpdoSistQp_-x2EuM8GYMYBSKccqnW7BjgtStpdeEgQKKRVRexoEjzINUQRRXkfrBJyDdX8OHcHD1H-cEXlrM9Q'
            ]
        );

        $client = new \GuzzleHttp\Client(['base_uri' => 'http://localhost/alquilados/public/api/v1/']);
        //$body = Psr7\Utils::tryFopen('../public/anounces/22/605fd8a9821b9-1.jpg', 'r');
        //$response = $client->request('POST', 'create', ['body' => $body]);
        /*$response = $client->post( 'create', [
            'multipart' => [

                [
                    'name'     => 'file',
                    'contents' => Psr7\Utils::tryFopen('../public/anounces/22/605fd8a9821b9-1.jpg', 'r'),
                    'headers'  => [

                    'Content-Type' =>  'image/jpeg'
                ]
                ],
                
                
            ]
        ]);*/


        $response = Http::post('http://localhost/alquilados/public/api/v1/create', [

            'title' => Psr7\Utils::tryFopen('../public/anounces/22/605fd8a9821b9-1.jpg', 'r'),

            'body' => 'This is test from ItSolutionStuff.com as body',

        ]);

        $jsonData = $response->json();
echo json_encode($jsonData);
dd($response->successful());
    
    dd($response);


        $body = $response;
         dd(['getdatapi',$body]);
        //dd('getDataApi');
       //return $response;
    }

}
