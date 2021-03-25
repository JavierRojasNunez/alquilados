<?php

if (isset($argv))
{    
    $csv = $argv[1];
    $json = $argv[2];
}
else
{
    $csv = 'ventas.csv';
    $json = 'categorias.json';
}

$ventas = [];

if (($fp = fopen($csv, 'r')) === FALSE)
{
    echo 'Problemas con el archivo CSV.';
    die;
}

$indexs = [];

while ($data = fgetcsv($fp, 10000, ';'))
{
    $replaceMix = ['€', '.'];
    $data = str_replace($replaceMix, '', $data);
    $data = str_replace(',', '.', $data);
    $ventas[] = array_map('utf8_encode',$data);
    $indexs = $ventas[0];      
}
    
unset($ventas[0]);

$ventas = array_values($ventas);

$result = array_map(

    function ($v) use ($indexs) {

        $result=[];

        for ($i=0; $i<count($v); $i++) {

            $result[$indexs[$i]]=$v[$i];

        }

        return $result;

    }, $ventas

);


if (!file_exists($json))
{
    echo 'Problemas con el archivo JSON.';
    die;
}    

$categories = file_get_contents($json);

if (!$categories){
    echo 'Problemas al leer el JSON';
    die;
}


$categories = preg_replace('/€/', 'x', $categories);

$categories = json_decode($categories, true);

$totals = [];

for ( $i = 0; $i < count($result); $i++ ){
    
    foreach( $result[$i] as $key => $value){

        foreach( $categories as $key2 => $categorie ){
            
            foreach( $categorie as $key3 => $categori ){

                //detectar que ha dos operaciones              
                if (preg_match_all('/.{1}\d+.{1}/', $categori, $matches) > 1){

                    if ($key == 'CATEGORY' && $value == $key3)
                    {        

                    if (substr($categori, -1) == '%'){

                        if($matches[0][0][0] == '+'){

                            $value_1 = str_replace(['+', '-', 'x', ], '', $matches[0][0]);
 
                            $TotalesParcial =   (float)$result[$i]['COST'] + (float)$value_1;

                        }else if(($matches[0][0][0] == '-')){

                            $value_1 = str_replace(['+', '-', 'x', ], '', $matches[0][0]);
 
                            $TotalesParcial =   (float)$result[$i]['COST'] - (float)$value_1;

                        }

                        if($matches[0][1][0] == '+'){

                            $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                            $total_2_operations = ((float)$TotalesParcial / 100) * (float)$valuePercent;

                            $total_2_operations = ($TotalesParcial + $total_2_operations) * (float)$result[$i]['QUANTITY'] ;

                            $total_2_operations = $total_2_operations - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                            $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                        }else if(($matches[0][1][0] == '-')){

                            $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                            $total_2_operations = ((float)$TotalesParcial / 100) * (float)$valuePercent;

                            $total_2_operations = ($TotalesParcial - $total_2_operations)  * (float)$result[$i]['QUANTITY'];

                            $total_2_operations = $total_2_operations - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                            $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                        }

                        


                    }
                    else
                    {

                        $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][0]);

                        $TotalesParcial = ((float)$result[$i]['COST'] / 100) * (float)$valuePercent;

                         if ($matches[0][0][0] == '+')
                         {

                            $TotalesParcial =  $TotalesParcial + (float)$result[$i]['COST'];

                         }
                         else if($matches[0][0][0] == '-')
                         {

                            $TotalesParcial =  $TotalesParcial - (float)$result[$i]['COST'];

                         }

                         if ($matches[0][1][0] == '+')
                         {
                            $value_2 = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                            $total_2_operations = ($TotalesParcial + (float)$value_2) * (float)$result[$i]['QUANTITY'];

                            $total_2_operations = $total_2_operations -  ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                            $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];
                             
                         }
                         else if ($matches[0][1][0] == '-')
                         {

                            $value_2 = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                            $total_2_operations = ($TotalesParcial - (float)$value_2) * (float)$result[$i]['QUANTITY'];

                            $total_2_operations = $total_2_operations -  ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                            $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                         }

                    }


                    }
                    else if($key == 'CATEGORY'   && !array_key_exists($value, $categorie)) 
                    {

                        if($key3 == '*' ){

                            if (substr($categori, -1) == '%'){

                                if($matches[0][0][0] == '+'){

                                    $value_1 = str_replace(['+', '-', 'x', ], '', $matches[0][0]);
        
                                    $TotalesParcial =   (float)$result[$i]['COST'] + (float)$value_1;

                                }else if(($matches[0][0][0] == '-')){

                                    $value_1 = str_replace(['+', '-', 'x', ], '', $matches[0][0]);
        
                                    $TotalesParcial =   (float)$result[$i]['COST'] - (float)$value_1;

                                }

                                if($matches[0][1][0] == '+'){

                                    $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                                    $total_2_operations = ((float)$TotalesParcial / 100) * (float)$valuePercent;

                                    $total_2_operations = ($TotalesParcial + $total_2_operations) * (float)$result[$i]['QUANTITY'] ;

                                    $total_2_operations = $total_2_operations - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                    $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                                }else if(($matches[0][1][0] == '-')){

                                    $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                                    $total_2_operations = ((float)$TotalesParcial / 100) * (float)$valuePercent;

                                    $total_2_operations = ($TotalesParcial - $total_2_operations)  * (float)$result[$i]['QUANTITY'];

                                    $total_2_operations = $total_2_operations - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                    $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                                }

                                


                            }
                            else
                            {

                                $valuePercent = str_replace(['+', '-', 'x', '%'], '', $matches[0][0]);

                                $TotalesParcial = ((float)$result[$i]['COST'] / 100) * (float)$valuePercent;

                                if ($matches[0][0][0] == '+')
                                {

                                    $TotalesParcial =  $TotalesParcial + (float)$result[$i]['COST'];

                                }
                                else if($matches[0][0][0] == '-')
                                {

                                    $TotalesParcial =  $TotalesParcial - (float)$result[$i]['COST'];

                                }

                                if ($matches[0][1][0] == '+')
                                {
                                    $value_2 = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                                    $total_2_operations = ($TotalesParcial + (float)$value_2) * (float)$result[$i]['QUANTITY'];

                                    $total_2_operations = $total_2_operations -  ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                    $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];
                                    
                                }
                                else if ($matches[0][1][0] == '-')
                                {

                                    $value_2 = str_replace(['+', '-', 'x', '%'], '', $matches[0][1]);

                                    $total_2_operations = ($TotalesParcial - (float)$value_2) * (float)$result[$i]['QUANTITY'];

                                    $total_2_operations = $total_2_operations -  ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                    $totals[] = [$result[$i]['CATEGORY'] => $total_2_operations];

                                }

                            }
                                    
                        }                          
                    }

                }
                else
                {

                if ($key == 'CATEGORY' && $value == $key3)
                {

                    $categori = str_replace('€', '', $categori);

                    if ( strpos($categori, '%')){

                       $operador = (string)$categori[0];

                       if($operador == '+'){

                        $categori = str_replace(['+', '%'], '', $categori);

                        $totalPartial =(( (float)$categori * ((float)$result[$i]['COST'] / 100)) + (float)$result[$i]['COST'])* $result[$i]['QUANTITY'];

                        $total = $totalPartial - (((float)$result[$i]['COST']) * $result[$i]['QUANTITY']);

                        $totals[] = [$key3 => $total];


                    }elseif($operador == '-'){

                        $categori = str_replace(['+', '%'], '', $categori);

                        $totalPartial =(( (float)$categori * ((float)$result[$i]['COST'] / 100)) - (float)$result[$i]['COST'])* $result[$i]['QUANTITY'];

                        $total = $totalPartial - (((float)$result[$i]['COST']) * $result[$i]['QUANTITY']);

                        $totals[] = [$key3 => $total];

                    }
                       
                    }
                    else
                    {
                        $operador = (string)$categori[0];
                        
                        if($operador == '+'){

                            $categori = str_replace(['+', '-', '%'], '', $categori);

                            $totalPartial = (float)$categori + (float)$result[$i]['COST']  ;

                            $total = (float)$totalPartial * (float)$result[$i]['QUANTITY'] ;

                            $totalCoste = $total - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY'])  ;


                            $totals[] = [$key3 => $totalCoste];
                        }
                        else if ($operador == '-') {

                            $categori = str_replace(['+', '-', '%'], '', $categori);

                            $totalPartial = (((float)$categori - (float)$result[$i]['COST']))  ;

                            $total = (float)$totalPartial * (float)$result[$i]['QUANTITY'] ;

                            $totalCoste = $total -  ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY'])  ;

                            $totals[] = [$key3 => $totalCoste];
                        }
                    }


                }
                else if($key == 'CATEGORY' && !array_key_exists($value, $categorie)) 
                {
                    if($key3 == '*' )
                    {
                        
                        $operador = (string)$categori[0];

                        if(preg_match_all('/%/', $categori)){
                            
                             $categori = str_replace(['+', '-', '%'], '', $categori);

                            if($operador == '+'){

                                $totalPartial = ((float)$result[$i]['COST'] / 100) * $categori;

                                $totalPartial = ( $totalPartial + (float)$result[$i]['COST'] ) * (float)$result[$i]['QUANTITY'];

                                $total =  $totalPartial - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                $totals[] = [$result[$i]['CATEGORY']=> $total];

                            }elseif($operador =='-'){

                                $totalPartial = ((float)$result[$i]['COST'] / 100) * $categori;

                                $totalPartial = (  (float)$result[$i]['COST'] - $totalPartial ) * (float)$result[$i]['QUANTITY'];

                                $total =  $totalPartial - ((float)$result[$i]['COST'] * (float)$result[$i]['QUANTITY']);

                                $totals[] = [$result[$i]['CATEGORY']=> $total];

                            }

                        }
                        else
                        {
                            $categori = str_replace(['+', '-', '%'], '', $categori);

                            if($operador == '+'){

                                $totalPartial = ((float)$result[$i]['COST'] + (float)$categori) *  (float)$result[$i]['QUANTITY'];

                                $total =  (float)$result[$i]['COST']  * (float)$result[$i]['QUANTITY'];

                                $total =  $totalPartial - $total;

                                $totals[] = [$result[$i]['CATEGORY']=> $total];

                            }elseif($operador =='-'){
                               
                                $totalPartial = ((float)$result[$i]['COST'] - $categori) *  (float)$result[$i]['QUANTITY'];

                                $total =  (float)$result[$i]['COST']  * (float)$result[$i]['QUANTITY'];

                                $total =  $totalPartial - $total;
                                
                                $totals[] = [$result[$i]['CATEGORY']=> $total];

                            }
                        }
                    }                          
                }
            }
        }
            

        }
    }
}


$acum = [];
for($i = 0; $i< count($totals); $i++){

    foreach($totals[$i] as $key => $value){

    if (  in_array(  $key, array_keys($acum) )  ) {

        $acum[ $key ] += (float)$value;

    } else {

        $acum[ $key ] =  (float)$value;

    }
        
    }

}


foreach($acum as $key => $value){
    echo $key . ': ' . number_format( (float)$value, 2,'.', '' ) . '<br>';        
}



