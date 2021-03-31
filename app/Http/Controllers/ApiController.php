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

	public function getAll()
	{
        

    
        //voy por aqui optimizar busqueda con join o usando elocuent

       /*$data = Anounces::get()->each(function($data){

            $data->user;
            $data->imagen;
            $data->imageUrl = $_SERVER['HTTP_HOST'] . '/public/anounces/'. $data->user->id . '/';
            
        });*/
       



        
        
       /* $data = DB::table('anounces')
                ->offset($offSet)
                ->limit($limit)
                ->get();*/

        
        $data = Anounces::paginate(10);
        $data->load('user');
        $data->load('imagen');  
        
        $numAdds = count($data);

        if ($numAdds == 0){

            
            return response()->json(['status'=> 'No data found.', 'results' => $numAdds ], 204);

        }
       

        /*foreach($data as $anuncio){
            
            $user = User::where('id', '=', $anuncio->user_id)->first();

            if($user){
             
                $anuncio->userData[] = [
                    'userName' => $user->name,
                    'userSurname' => $user->surname,
                    'userEmail' => $user->email,
                ];   

                unset($anuncio->user_id);
                
            }
        }*/
        
        return response()->json(['status'=>'ok', 'results' => $numAdds ,'collection'=>$data], $this->HttpstatusCode);

	}



    public function getOne($id){

        
        $data = Anounces::find($id);
        $data->user;
        unset($data->user->id);
        $data->imagen;

        
        
        if($data == NULL){

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


    public function getResumeWithImages($limit_ = 100){

        $limit_ = ($limit_ > 5000) ? 5000 : $limit_;

           if( is_array($limit_) ){

            $limit = isset($limits[0]) ? (integer)$limits[0] : 10;
            $offSet = isset($limits[1]) ? (integer)$limits[1] : 0;
            
        }else{

            $limits = explode(' ', $limit_);
            $limit = (integer)$limits[0] ;
            $limit = ($limit == 0) ? $limit = 10 : $limit;
            $offSet = isset($limits[1]) ? (integer)$limits[1] : 0;

        }


        $dataAnounce = [];
        //$dataImages = [];
        $data = [];     

        
        $dataAnounce = DB::table('anounces')
                        ->select([ 'id as reference', 'user_id', 'type_rent', 'price',  'payment_period', 'meter2', 'num_rooms',
                        'cauntry_rent', 'province_rent', 'phone', 'city_rent', 'street_rent as type_street', 'adress_rent', 'num_street_rent', 'flat_street_rent',
                        'cp_rent as ZIP code', 'observations']);
        $dataAnounce->orderBy('id', 'desc');
        $dataAnounce->offset($offSet);
        if ($limit_) $dataAnounce = $dataAnounce->limit($limit_);
        $dataAnounce = $dataAnounce->get();         

        
                    
                        
        foreach ( $dataAnounce as  $anounce ){
           
            $dataImages =  DB::table('images')
                    ->where('anounces_id', '=', $anounce->reference)
                    ->select(['imageName', 'created_at', 'updated_at'])
                    ->get(); 
            
            $dataUser =  DB::table('users')
                    ->where('id', '=', $anounce->user_id)
                    ->select(['name', 'surname', 'email'])
                    ->get(); 

                  
                    
            $anounce->imageUrl = $_SERVER['HTTP_HOST'] . '/anounces/' . $anounce->user_id . '/' ;       
            unset($anounce->user_id);
            $anounce->currency = '€';
            $anounce->userData = $dataUser;
            $anounce->images = $dataImages;        
                  
        }           

       /* if (!$limit_){

            $dataAnounce = Anounces::paginate(10);

        }else{

            $dataAnounce = Anounces::limit($limit_)->paginate(10);

        }

        
        foreach ( $dataAnounce as  $anounce ){

            $anounce->imagen; 
            $imageUrl = $_SERVER['HTTP_HOST'] . '/public/' . $anounce->user_id . '/' ;
            $anounce->image_url = $imageUrl;
            unset ($anounce->user_id);
        } */    

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
