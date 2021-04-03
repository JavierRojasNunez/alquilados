<?php

namespace App\Http\Controllers;

use App\Models\Anounces;
use App\Models\User;
use App\Models\Imagen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    protected $data;
    public $HttpstatusCode = 200;
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

     public function create(Request $request, $id = false){

        if($request->file('file')){
           return json_encode(['uno' => 1, 'dos' => 2]);
            //return response()->json(['mesagge' => 'llegó'], 200);
        }else{
            return response()->json(['mesagge' => $request->file('file')], 406);
        }

        
        die();

        if($request && !$id){

            $numAdss = Anounces::where('user_id', Auth::id())->count();

            if ($numAdss >= 2){

            return response()->json(['mesagge' => 'You have two adss and its only two.', 'numAdss'=> $numAdss], 406);
            
            }

        }
        
        if ($request->isJson())
        {
           
        


        $userId = $request->user()->id;

        $authUserId = Auth::id();

        $userExists = User::where('id', Auth::id())->exists();

        if(trim($authUserId) != trim($userId) || !$userExists){
            return response()->json(['status'=>'Not created or updated. Bad user credentials'], 400);
        }

        $data = $request->all();

        $dataToBeSaved = isset($data['data'][0]) ? $data['data'][0] : false ;

        if(!$dataToBeSaved || empty($dataToBeSaved)  || !isset($dataToBeSaved)){
            return response()->json(['status'=>'Not created. No data sent.'], 200);
        }
                        
        $whiteListIndexs = [
            'type_rent' => '','price' => '','min_time_ocupation' => '','payment_period' => '','meter2' => '',
            'num_roomms_for_rent' => '', 'num_rooms' => '','num_baths' => '', 'deposit' => '', 'phone' => '', 'available_date' => '',
            'titulo' => '', 'descripcion' => '','num_people_in' => '','people_in_job' => '','people_in_sex' => '','people_in_tabaco' => '',
            'people_in_pet' => '', 'lookfor_who_job' => '', 'lookfor_who_sex' => '', 'lookfor_who_tabaco' => '', 'lookfor_who_pet' => '',
            'cauntry_rent' => '', 'province_rent' => '', 'city_rent' => '','street_rent' => '', 'adress_rent' => '', 'num_street_rent' => '',
            'flat_street_rent' => '', 'cp_rent' => '','funiture' => '','ascensor' => '', 'calefaction' => '','balcon' => '', 'terraza' => '','gas' => '',
            'swiming' => '','internet' => '', 'washing_machine' => '','fridge' => '','kitchen' => '','near_bus' => '','near_underground' => '',
            'near_tren' => '', 'near_school' => '', 'near_airport' => '', 'observations' => '','type' => '',              
        ];

        // eliminar indices no permitidos
        foreach($dataToBeSaved as $key => $value){

            if (!array_key_exists ( $key, $whiteListIndexs  ) ){
                                    
                unset( $dataToBeSaved[$key] );
                
            }                           
                
        }

        $valueInsert = ['user_id' =>  Auth::id()];

        $dataToBeSaved = array_merge($dataToBeSaved, $valueInsert);                        

        if (strtolower($dataToBeSaved['type']) != 'alquiler' && strtolower($dataToBeSaved['type']) != 'venta'){
            $dataToBeSaved['type'] = 'alquiler';
        }

        $verify = Validator::make($dataToBeSaved, [
            'user_id' =>['required', 'integer', 'max:255'],
            'price' => ['required', 'numeric', 'between:0,1000000000000000'],
            'payment_period' => ['required', 'string', 'max:60'],
            'meter2' => ['required', 'numeric', 'max:255'],
            'titulo' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:3500'],
            'cauntry_rent' => ['required', 'string', 'max:60'],
            'province_rent' => ['required', 'string', 'max:60'],
            'city_rent' => ['required', 'string', 'max:60'],
            'street_rent' => ['required', 'string', 'max:60'],
            'adress_rent' => ['required', 'string', 'max:60'],
            'num_street_rent' => ['required', 'integer', 'max:100'],
            'flat_street_rent' => ['required', 'string', 'max:100'], 
            'cp_rent' => ['required', 'string', 'max:100'], 
            'type' => ['required', 'string', 'max:100'],
            'num_people_in' => ['boolean', 'nullable'],'people_in_job' => ['boolean', 'nullable'],'people_in_sex' => ['boolean', 'nullable'],
            'people_in_tabaco' => ['boolean'],'people_in_pet' => ['boolean'],'lookfor_who_job' => ['boolean', 'nullable'],
            'lookfor_who_sex' => ['boolean', 'nullable'],'lookfor_who_pet' => ['boolean', 'nullable'],'funiture' => ['boolean', 'nullable'],
            'ascensor' => ['boolean', 'nullable'],'calefaction' => ['boolean', 'nullable'],'balcon' => ['boolean', 'nullable'],
            'terraza' => ['boolean', 'nullable'],'gas' => ['boolean', 'nullable'],'swiming' => ['boolean', 'nullable'],
            'internet' => ['boolean', 'nullable'],'washing_machine' => ['boolean', 'nullable'],'fridge' => ['boolean', 'nullable'],
            'kitchen' => ['boolean', 'nullable'],'near_bus' => ['boolean', 'nullable'],'near_underground' => ['boolean', 'nullable'],
            'near_tren' => ['boolean', 'nullable'],'near_school' => ['boolean', 'nullable'],'near_airport' => ['boolean', 'nullable'], 
            'observations' => ['string', 'max:3500', 'nullable'],                
            
            ]);

                        
        if ($verify->fails()) { 
            return response()->json(['error'=>$verify->errors()], 401);            
        }

        if($id){

            $anuncio = Anounces::find($id);  

            foreach($dataToBeSaved as $key => $value){
           
                $anuncio->$key =  $value;

            }
            
            $anuncio->update();

            return response()->json(['status'=>'Updated.', $anuncio], 201);

        }else{
            
            $anuncio = Anounces::create($dataToBeSaved);

        }

        return response()->json(['status'=>'Created.', $anuncio], 201);

        }else{
            return response()->json(['error' => 'No valid JSON'], 406);
        }

     }

	public function getAll()
	{

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
        $url = $_SERVER['HTTP_HOST']. '/public/anounces/';
        $urlExample =  $_SERVER['HTTP_HOST']. '/public/anounces/[user_id]/[imageName]/';
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
        
        return response()->json(['status'=>'ok', 'urlExample'=> $urlExample , 'imageUrl'=> $url , 'results' => $numAdds ,'collection'=>$data], $this->HttpstatusCode);

	}



    public function getOne($id = false){

        
        if(!$id){

            return response()->json(['error'=>'Parameter passed 0 expects exactly 1 | integer'], 406); 
        }

        $data = Anounces::find((integer)$id);
            
        if($data == NULL){
            
            return response()->json(['status'=>'Not data found'], 200);   
                
        }
        
        $data->user;

        $data->imagen;

        $data->imageUrlExample = $_SERVER['HTTP_HOST'] . '/public/anounces/' . $data->user->id . '/[imageName]';

        $data->imageUrl = $_SERVER['HTTP_HOST'] . '/public/anounces/' . $data->user->id . '/';

        $data->currency = '€';

        unset($data->user_id);

        unset($data->user->id);
        
        unset($data->id);

        for($i = 0; $i < count($data->imagen); $i++){

            unset($data->imagen[$i]->id);
            unset($data->imagen[$i]->anounces_id); 

        }
        
        return response()->json(['status'=>'Data found','data'=>$data], $this->HttpstatusCode);

    }

    public function delete(Request $request, $id_){

        
        $userId = $request->user()->id;

        $authUserId = Auth::id();

        $userExists = User::where('id', Auth::id())->exists();

        if(trim($authUserId) != trim($userId) || !$userExists || !$id_ || empty($id_)){

            return response()->json(['status'=>'Not created. Bad user credentials'], 400);

        }

        $data = Anounces::find((integer)$id_);

        if($data == null || $data->user_id != $authUserId){

            return response()->json(['status'=>'Not data found, nothing to delete'], $this->HttpstatusCode);

        }      

        foreach($data->imagen as $img){

            $imagen = Imagen::find($img->id);

            if ($imagen == null){

                return response()->json(['error'=>'Not imagen found in this data, no data deleted'], 200);

            }

            $deleted = $imagen->delete();  
            
            if ($deleted != true){

                return response()->json(['error'=>'Not imagen found in this data, no data deleted'], 200);

            }

        }
       
        $data->delete();      
       
        return response()->json(['status'=>'Deleted data','data'=>$data], $this->HttpstatusCode);

    }



    public function getBasics($id_ = false){

        $data = [];

        if ( !is_numeric($id_) && $id_  ){
            return response()->json(['error'=>'Parameters must to be integers'], 406);   
        }

        if($id_){
            $data = DB::table('anounces')
            ->select(['titulo', 'descripcion as description', 'cauntry_rent as country', 'province_rent as province', 'city_rent as city', 'phone'])
            ->where('id' , '=', (integer)$id_)
            ->get();
        }else{
           $data = DB::table('anounces')
           ->select(['titulo as title', 'descripcion as description', 'cauntry_rent as country', 'province_rent as province', 'city_rent as city', 'phone'])
           ->paginate(10); 
        }

        $numData = count($data);
        if($numData < 1){

            return response()->json(['status'=>'No data found'], 200);   
                
        }

        return response()->json(['status'=>'Data found','data'=> $data], $this->HttpstatusCode);

    }


    //sepuede pasar dos parametros separados por espacio para tene primero limite y segundo offset
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
        ->select([ 'id as reference', 'user_id', 'type_rent', 'price',  'payment_period', 
        'meter2', 'num_rooms', 'cauntry_rent', 'province_rent', 'phone', 'city_rent', 
        'street_rent as type_street', 'adress_rent', 'num_street_rent', 'flat_street_rent',
        'cp_rent as ZIP code', 'observations']);
                                              
        if ($id_) $dataAnounce->where('id', '=', $id_);
                
        if ($limit) $dataAnounce->orderBy('id', 'desc');

        if ($offSet) $dataAnounce->offset($offSet);

        if ($limit) $dataAnounce = $dataAnounce->limit($limit);
        
         $dataAnounce = $dataAnounce->get();                          

        $totalResults = count($dataAnounce);



        
       /* foreach ( $dataAnounce as  $anounce ){

            $anounce->imagen; 
            $imageUrl = $_SERVER['HTTP_HOST'] . '/public/' . $anounce->user_id . '/' ;
            $anounce->image_url = $imageUrl;
            unset ($anounce->user_id);
        }  */


        if ($totalResults < 1){
            

            return response()->json(['status'=>'No data found'], $this->HttpstatusCode);
            
        }  
        
        $url = $_SERVER['HTTP_HOST'];
        foreach ( $dataAnounce as  $anounce ){
            
                  $dataImages =  DB::table('images')
                          ->where('anounces_id', '=', $anounce->reference)
                          ->select(['user_id', 'imageName', 'created_at', 'updated_at'])
                          ->get(); 
                  
                  $dataUser =  DB::table('users')
                          ->where('id', '=', $anounce->user_id)
                          ->select(['name', 'surname', 'email'])
                          ->get(); 
      
                 foreach($dataImages as $image){
                     //dd($image);
                     $image->imageName = $url . '/alquilados/public/anounces/' . $image->user_id. '/' . $image->imageName;
                 }       
                          
                 
                  
                  $anounce->currency = '€';
                  $anounce->userData = $dataUser;
                  $anounce->images = $dataImages;      
                  unset($anounce->user_id);  
                        
              } 
        return response()->json(['status'=>'200', 'totalResults'=>$totalResults , 'anuncios'=>$dataAnounce], $this->HttpstatusCode);

    }


    public function getBy($arga, $argb, $argc = false){

        if ($arga && !$argb && !$argc){
            return response()->json(['status'=>'Parameter 1 passed  expects exactly 2.'], 406);
        }

        if (!$arga && !$argb && !$argc || is_numeric($arga)){
            return response()->json(['status'=>'Parameter 0 passed  expects exactly 2 | OR bad parameters, parameter 1 must to be string, parameter 2 must to be string or integer'], 406);
        }
        
        if ($arga && $argb && !$argc){
            
           $url = $_SERVER['SERVER_NAME'] . '/alquilados/public/anounces/';
 

           $ok = preg_match('/(^country$)|(^city$)|(^province$)|(^price$)|(^funiture$)|(^my$)/', $arga);
           if(!$ok){
            return response()->json([
                                    'status'=>'Invalid arguments',
                                    'Valid arguments 1'=>['country', 'city', 'provinces', 'price', 'my'],
                                    ], 406);
           }

             
                if($arga == 'funiture' ){

                    if($argb == 'yes') {
                        $argb = true;
                    }else{
                        $argb = false;
                    }

                }

                if($arga == 'city' ){

                    $arga = 'city_rent';
                    $argb = (string)$argb;

                }

                if($arga == 'province' ){
                    
                    $arga = 'province_rent';
                    $argb = (string)$argb;

                }              

                if($arga == 'country' ){
                    
                    $arga = 'cauntry_rent';
                    $argb = (string)$argb;

                }

                
                if($arga == 'my' ){
                    
                    $arga = 'user_id';
                    $argb = Auth::id();


                }

               

           
                $dataAnounce = Anounces::where($arga, '=', $argb)->paginate(10);

                
                if (count($dataAnounce) == 0){

                    $data = false;
                    return response()->json(['status'=>'No data found'], 200);
                    
                }  
                
                foreach ($dataAnounce as $anounce){
                   
                    $anounce->user;
                    $anounce->imagen;

                   foreach($anounce->imagen as $imagen){
                    $imagen->imageName = $url .  $anounce->user_id . '/' . $imagen->imageName;
                    unset($imagen->id, $imagen->anounces_id);
                   } 

                   unset($anounce->user->id);
                   
                }               
                
            
                           
    
            return response()->json(['status'=>'Data found','anuncio'=> $dataAnounce], $this->HttpstatusCode);
            
        }

        if ($arga && $argb && $argc){

            $url = $_SERVER['SERVER_NAME'];

            if ($arga == 'price'){
                
                $dataAnounce = Anounces::whereBetween('price', [(float)$argb, (float)$argc])->paginate(10);

                foreach ($dataAnounce as $anounce){

                   $anounce->imagen; 
                                     
                   foreach($anounce->imagen as $imagen){
                       $imagen->url = $url . '/alquilados/public/anounces/' .$anounce->user_id . '/' . $imagen->imageName;
                       unset($imagen->id);
                       unset($imagen->anounces_id);
                   }
                   unset($anounce->id);
                   unset($anounce->user_id);
                }               
                
            }
            
            

            
            if (count($dataAnounce) == 0){

                $data = false;
                return response()->json(['status'=>'No data found'], 200);
                
            }  
                
    
            return response()->json(['status'=>'Data found' ,'anuncio'=>$dataAnounce], $this->HttpstatusCode);
            
        }


    }


}
