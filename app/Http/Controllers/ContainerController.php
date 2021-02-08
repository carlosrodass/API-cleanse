<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{

    //Método mostrando Contenedores segun la calle introducida y devolviendo el numero de la calle y el nombre 
    public function findContainerByName($streename) 
    {
         $var = DB::table('containers')
        ->where('street_name', '=', $streename)
        ->get(['street_number', 'street_name']);    

        return $var;
    }

    public function amounttrash(Request $request)
    {
    	$response = "";

    	$quantity = $request->only('amount');

    	if(isset($quantity)){
    		//segun la cantidad introducida devuelve un numero de puntos

    		// if($quantity >= 0 && $quantity <= 5)
    		// {
    		// 	$response = "toma 5 puntos";
    		// }
    		// else if($quantity >= 6 && $quantity <=10)
    		// {
    		// 	$response = "toma 10 puntos";
    		// }
    		$response = "toma 10 puntos";
    		
    	}else

    	$response = "No has introducida basura";

    	return $response;

    }

    
}
