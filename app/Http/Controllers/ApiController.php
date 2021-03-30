<?php

namespace App\Http\Controllers;

use App\Models\Anounces;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Boolean;
use PhpParser\Node\Expr\FuncCall;

class ApiController extends Controller
{

    protected $data;
    public $HttpstatusCode = 200;
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */


  


     public function create(Request $request){

        
        if ($request->isJson())
        {
                            
            $data = $request->all();

            $dataToBeSaved = $data['data'][0];
            
            $userExists = User::where("id", $dataToBeSaved['user_id'])->exists();
            
            if (!$userExists){

                $anuncio = false;

                return response()->json(['status'=>'Not created. Bad user credentials', $anuncio], 400);

            }else{

                $anuncio = Anounces::create($dataToBeSaved);

                return response()->json(['status'=>'Created.', $anuncio], 201);

            }           

        }else{
            return response()->json(['error' => 'No valid JSON'], 406);
        }

     }

	public function getAll($limit = 1000)
	{
        

        if( is_array($limit) ){

            $limit = (integer)$limit[0] ;
            $offSet = isset($limits[1]) ? (integer)$limits[1] : 0;
            
        }else{

            $limits = explode(' ', $limit);
            $limit = (integer)$limits[0] ;
            $limit = ($limit == 0) ? $limit = 10 : $limit;
            $offSet = isset($limits[1]) ? (integer)$limits[1] : 0;

        }
        
        $data = DB::table('anounces')
                ->offset($offSet)
                ->limit($limit)
                ->get();

        
            
         $numAdds = count($data);

        if ($numAdds == 0){

            
            return response()->json(['status'=> 'No data found.', 'results' => $numAdds ], 204);

        }
        $data[0]->user = [];

        foreach($data as $anuncio){
            
            $user = User::find($anuncio->user_id);
            if($user){
             
                $data[0]->user = [
                    'userName' => $user->name,
                    'userSurname' => $user->surname,
                    'userEmail' => $user->email,
                ];   

                unset($data[0]->user_id);
                
            }
        }
        
        return response()->json(['status'=>'ok', 'results' => $numAdds ,'data'=>$data], $this->HttpstatusCode);

	}



    public function getOne(){

        $data = Anounces::all()->first();
        if(!$data){

            $data = false;
            return response()->json(['status'=>'204'], 204);   
                
        }
         
        return response()->json(['status'=>'ok','data'=>$data], $this->HttpstatusCode);

    }



    public function getTitle(){

        $data = DB::table('anounces')->pluck('titulo');

        if(!$data){

            $data = false;
            return response()->json(['status'=>'204','data'=>$data], 204);   
                
        }

        return response()->json(['status'=>'ok','data'=> $data], $this->HttpstatusCode);

    }


    public function getAllWithImages($limit_ = false){

        $dataAnounce = [];
        //$dataImages = [];
        $data = [];     

        dd($limit_);
       /* $dataAnounce = DB::table('anounces')
                        ->select([ 'id as reference', 'type_rent', 'price', 'min_time_ocupation', 'payment_period', 'meter2', 'num_roomms_for_rent', 'num_rooms',
                        'num_baths', 'deposit', 'phone' ,'available_date', 'titulo', 'descripcion', 'num_people_in', 'people_in_job', 'people_in_sex as lookinf forb',
                        'people_in_tabaco', 'people_in_pet', 'lookfor_who_job', 'lookfor_who_sex as looking for', 'lookfor_who_tabaco', 'lookfor_who_pet',
                        'cauntry_rent', 'province_rent', 'city_rent', 'street_rent as type', 'adress_rent', 'num_street_rent', 'flat_street_rent',
                        'cp_rent as ZIP code', 'funiture', 'ascensor', 'calefaction', 'balcon', 'terraza', 'gas', 'swiming', 'internet', 'washing_machine',
                        'fridge', 'kitchen', 'near_bus', 'near_underground', 'near_tren', 'near_school', 'near_airport', 'observations']);
        if ($limit_) $dataAnounce = $dataAnounce->limit($limit_);
        $dataAnounce = $dataAnounce->get();         

        
                    
                        
        foreach ( $dataAnounce as  $anounce ){
           
            $dataImages =  DB::table('images')
                    ->where('anounces_id', '=', $anounce->reference)
                    ->select(['imageName', 'created_at', 'updated_at'])
                    ->get(); 

            $anounce->imageUrl = $_SERVER['HTTP_HOST'];       

            $anounce->images = $dataImages;        
                  
        }    */       

        if (!$limit_){

            $dataAnounce = Anounces::paginate(10);

        }else{

            $dataAnounce = Anounces::limit($limit_)->paginate(10);

        }

        
        foreach ( $dataAnounce as  $anounce ){

            $anounce->imagen; 
            $url = $_SERVER['HTTP_HOST'] . '/public/' . $anounce->user_id . '/' ;
            $anounce->image_url = $url;
            unset ($anounce->user_id);
        }     

        if (!$dataAnounce){

            $data = false;

            return response()->json(['status'=>'204','data'=>$data], 204);
            
        }  
             
        
        return response()->json(['status'=>'200', 'anuncios'=>$dataAnounce], $this->HttpstatusCode);

    }


    public function getBy($arga = false, $argb = false, $argc = false){

        

        if ($arga && !$argb && !$argc){
           
            $dataAnounce = Anounces::find((integer)$arga);
            
            $url = $_SERVER['SERVER_NAME'] . '/public';

            
            if (!$dataAnounce){

                $data = false;
                return response()->json(['status'=>'204','data'=>$data], 204);
                
            } 
             
            $dataAnounce->imagen;     
            
            return response()->json(['status'=>'200', 'url'=>$url ,'anuncio'=>$dataAnounce], $this->HttpstatusCode);
            
        }

        if ($arga && $argb && !$argc){
            
           $url = $_SERVER['SERVER_NAME'] . '/public';
 
            if (!empty($arga)){
             
                if($arga == 'funiture' ){
                    if($argb == 'yes') {
                        $argb = true;
                    }else{
                        $argb = false;
                    }
                }
                
           
                $dataAnounce = Anounces::where($arga, '=', $argb)->paginate(10);

                
                if (count($dataAnounce) == 0){

                    $data = false;
                    return response()->json(['status'=>'No data found','data'=>$data], 204);
                    
                }  
                
                foreach ($dataAnounce as $anounce){
                   $anounce->imagen; 
                   $anounce->url = $url . '/public/' .$anounce->user_id . '/';
                }               
                
            }
                           
    
            return response()->json(['status'=>'200', 'url'=>$url ,'anuncio'=> $dataAnounce], $this->HttpstatusCode);
            
        }

        if ($arga && $argb && $argc){

            $url = $_SERVER['SERVER_NAME'];

            if ($arga == 'price'){
                
                $dataAnounce = Anounces::whereBetween('price', [(float)$argb, (float)$argc])->get();

                foreach ($dataAnounce as $anounce){
                   $anounce->imagen; 
                   $anounce->url = $url . '/public/' .$anounce->user_id . '/';
                   unset($anounce->user_id);
                }               
                
            }
            
            

            
            if (!$dataAnounce){

                $data = false;
                return response()->json(['status'=>'204','data'=>$data], 204);
                
            }  
                
    
            return response()->json(['status'=>'200', 'url'=>$url ,'anuncio'=>$dataAnounce], $this->HttpstatusCode);
            
        }


    }


}
