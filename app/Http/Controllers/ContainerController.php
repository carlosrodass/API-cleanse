<?php

namespace App\Http\Controllers;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{

    //Mostrando Contenedores segun la calle introducida y devolviendo el numero de la calle y el nombre
    public function findContainerByName(Request $request)
    {

        $data = $request->getContent();
        $data = json_decode($data);

        $response = [];
        $key = MyJWT::getKey();
        $headers = getallheaders();
        $decoded = JWT::decode($headers['token'], $key, array('HS256'));

        if($decoded->id){
            if($data){

                $location = DB::table('containers')
                ->where('street_name', $data->street_name)
                ->get();

                if($location){
                    for($i=0; $i< count($location); $i++){

                        $response[$i] = [
                        'calle' => $location[$i]->street_name,
                        'Numero' =>$location[$i]->street_number
                        ];
                    }
                }else{
                    $response = response()->json(['Failure' => 'No hay contenedores en esta calle']);
                }
            }else{
                $response = response()->json(['Failure'=>'No hay datos de busqueda']);
            }
        }else{
            $response = response()->json(['Failure'=>'No estas logueado']);
        }
        return $response;
    }

    public function tradeTrash(Request $request)
    {
    	$quantity = $request->getContent();
        $quantity = json_decode($quantity);

        $response = [];
        $key = MyJWT::getKey();
        $headers = getallheaders();
        $decoded = JWT::decode($headers['token'], $key, array('HS256'));

        if($decoded->id){

            if($quantity){
                //segun la cantidad introducida devuelve un numero de puntos

                ///AQUI HAY UN ERROR/ EL PARAMETRO QUE RECIBO ES UN STRING(QUANTITY) ENTONCES NO SE PUEDE COMPARAR, ARREGLAR!

                if($quantity >= 1 && $quantity <= 10){
                    // $response = 5;
                    $response = response()->json(['Success'=> 5]);
                }
                if($quantity >= 11 && $quantity <= 20){
                    $response = response()->json(['Success'=> 10]);
                }
                if($quantity >= 21 && $quantity <= 30){
                    $response = response()->json(['Success'=> 15]);
                }
                if($quantity >= 31 && $quantity <= 40){
                    $response = response()->json(['Success'=> 20]);
                }

            }else{
                $response = response()->json(['Failure'=>'No has introducido basura']);
            }
        }else{
            $response = response()->json(['Failure'=>'No estas logueado']);
        }


    	return $response;

    }




}
