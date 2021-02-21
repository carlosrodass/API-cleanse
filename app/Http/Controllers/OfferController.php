<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;

class OfferController extends Controller
{
    
    public function showOffers() 
    {
        $response = [];
        $key = MyJWT::getKey();
        $headers = getallheaders();
        $decoded = JWT::decode($headers['token'], $key, array('HS256'));

        if($decoded->id){

            $offers = DB::table('offers')
            ->get();

            for($i =0 ; $i < count($offers) ; $i++){

                $response[$i] = [
                'market' => $offers[$i]->market_name,
                'product' => $offers[$i]->offer_name,
                'price' => $offers[$i]->points
                ];
            }
        }else{
            $response = response()->json(['Failure'=>'No estas logueado']);
        }
        return $response;
    }

    public function tradeOffers(Request $request)
    {   
        /*
        *Usuario intenta adquirir oferta
        *Se comprueba que tenga los ptos necesarios

        * 1) --->los tiene 
                    : peticion al servidor
        * 2) --->No los tiene
                    : Mensaje de error

        *Si los tiene se hace una peticion al servidor con el nombre de la oferta

        */
        $response = "";
        //busqueda oferta
        $offerRequest = $request->get('offer_name');
        
        //Comprobacion de si existe la oferta y stock de la oferta
        $offersDB = DB::table('offers')
        ->where('offer_name', '=', $offerRequest)
        ->get(['stock', 'market_name']);

        if($offersDB->get('stock') >= 0){
            $response = "existe";
        }
        else{
            $response = " No existe";
        }

         
        //COMPROBACION DE STOCK

        // if("stock > 0"){
        //     //Restar el stock
        //     //response = succesful
        // }
        // else{
        //     //response = failure
        // }
        
        /**
         * la RESPONSE es enviada al cliente
         * 
         * --->comprobacion en la app [si la respuesta es SUCCES]
         * Restar los ptos correspondientes al usuario y mensaje de VENDIDO
         * 
         * --->comprobacion en la app [si la respuesta es FAILURE]
         * No se pudo realizar la compra
         */
        return $response;
        //compact('offersDB');
    }
}
