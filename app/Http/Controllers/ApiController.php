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

        $data = [];
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



    public function getOne($id = false){

        
        if(!$id){

            return response()->json(['error'=>'Parameter passed 0 expects 1 integer'], 406); 
        }

        $data = Anounces::find((integer)$id);
            
        if($data == NULL){
            
            return response()->json(['status'=>'Not data found'], 200);   
                
        }
        
        $data->user;
        $data->imagen;
        $data->imageUrl = $_SERVER['HTTP_HOST'] . '/public/anounces/' . $data->user->id . '/';
        $data->currency = '€';
        unset($data->user->id);
        return response()->json(['status'=>'Data found','data'=>$data], $this->HttpstatusCode);

    }



    public function getTitle(){

        $data = DB::table('anounces')->pluck('titulo');

        if(!$data){

            $data = false;
            return response()->json(['status'=>'204','data'=>$data], 204);   
                
        }

        return response()->json(['status'=>'Data found','data'=> $data], $this->HttpstatusCode);

    }


    //sepuede pasar dos parametros separados por espacio para tenet primero limite y segundo offset
   // vamos a poner dos variablesa recibir por la funcion
    public function getResumeWithImages($limit_ = 1000, $id_ = false){

        $limit_ = ($limit_ > 5000) ? 5000 : $limit_;

        $offSet = false;
        $limits = explode(' ', $limit_);

           if( $limits[0] == 'id' && $id_ ){

            $limit = false;
            $offSet = false;

            
        }else{

           
            if ((isset($limits[0] ) && !is_numeric($limits[0])) ||  ( isset($limits[1]) && !is_numeric($limits[1]) ) ){
                return response()->json(['error'=>'Parameters must to be integers'], 406);
            }
            
            $limit = (integer)$limits[0] ;
            
            $limit = ($limit == 0) ? $limit = 10 : (integer)$limit;
            
            $offSet = isset($limits[1]) ? (integer)$limits[1] : 0;

        }


        $dataAnounce = [];
        //$dataImages = [];
        $data = [];     

        
        $dataAnounce = DB::table('anounces')
                        ->select([ 'id as reference', 'user_id', 'type_rent', 'price',  'payment_period', 'meter2', 'num_rooms',
                        'cauntry_rent', 'province_rent', 'phone', 'city_rent', 'street_rent as type_street', 'adress_rent', 'num_street_rent', 'flat_street_rent',
                        'cp_rent as ZIP code', 'observations']);
                                              
        if ($id_) $dataAnounce->where('id', '=', $id_);
                
        if ($limit) $dataAnounce->orderBy('id', 'desc');

        if ($offSet) $dataAnounce->offset($offSet);

        if ($limit) $dataAnounce = $dataAnounce->limit($limit);
        
         $dataAnounce = $dataAnounce->get();         

        
                    
                        
                  

        $totalResults = count($dataAnounce);


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

        if ($totalResults == 0){
            

            return response()->json(['status'=>'No data found'], $this->HttpstatusCode);
            
        }  
             
        foreach ( $dataAnounce as  $anounce ){
                // dd($anounce->user_id);
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
        return response()->json(['status'=>'200', 'totalResults'=>$totalResults , 'anuncios'=>$dataAnounce], $this->HttpstatusCode);

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
