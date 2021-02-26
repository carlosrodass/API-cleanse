<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Offer;

use App\Http\Helpers\MyJWT;
use \Firebase\JWT\JWT;



class OfferController extends Controller
{
    /**
     * Showing all offers
     * @param 
     * @return JsonResponse|string
     */
    public function show()
    {   
        $response = [];
        foreach (Offer::all() as $offer) {
            $response[] = [
                'Offer'=> $offer->offer_name,
                'Market'=>$offer->market_name
            ];      
        }
        return response()->json($response);
    }

     /**
     * Buying offers
     * @param Request $request
     * @return JsonResponse|string
     */
    public function trade(Request $request)
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
        $validator = Validator::make($request->all(), [
            'offer_name' => 'required',
            'market_name' => 'required',
            'points' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error', 'Faltan datos']);
        } 

        $offers = Offer::where('offer_name', $request->offer_name)
        ->where('market_name',$request->market_name)
        ->where('points', '<' ,$request->points)
        ->get();

        print($offers);
        


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
        // return $response;
        //compact('offersDB');
    }
}
