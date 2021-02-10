<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{

    //Mostrando Contenedores segun la calle introducida y devolviendo el numero de la calle y el nombre 
    public function findContainerByName(Request $request) 
    {	
		$location = $request->get('street_name');
         $var = DB::table('containers')
        ->where('street_name', '=', $location)
        ->get(['street_number', 'street_name']);    

        return $var;
    }

    public function amounttrash(Request $request)
    {
    	$response = "";
    	$quantity = $request->get('amount');

    	if(isset($quantity)){
    		//segun la cantidad introducida devuelve un numero de puntos
			
			if($quantity >= 1 && $quantity <= 10){
				$response = 5;
			}
			if($quantity >= 11 && $quantity <= 20){
				$response = 10;
			}
			if($quantity >= 21 && $quantity <= 30){
				$response = 10;
			}
			if($quantity >= 31 && $quantity <= 40){
				$response = 10;
			}

    	}else

    	$response = "No has introducida basura";
    	
    	return $response;

    }

	

    
}
