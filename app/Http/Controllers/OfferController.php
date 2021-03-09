<?php

namespace App\Http\Controllers;
use App\Models\UserOffer;
use http\Client\Curl\User;
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
                'Market'=>$offer->market_name,
                'Points'=>$offer->points,
                'Stock'=>$offer->stock
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

        //Validando que esten los datos
        $validator = Validator::make($request->all(), [
            'offer_name' => 'required',
            'market_name' => 'required',
            'points' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error', 'Faltan datos']);
        }
        //Validando que exista la oferta
        $offers = Offer::where('offer_name', $request->offer_name)
        ->where('market_name',$request->market_name)
        ->where('points', '<' ,$request->points)
        ->where('stock', '>' , 0 )
        ->get();
                // ->decrement('stock', 1);

        // print($offers);
        // die();

        if(!$offers){
            return response()->json(['error', 'No existe la oferta']);
        }else{
            $offers =  Offer::where('offer_name', $request->offer_name)->decrement('stock', 1);
            //Eliminar oferta
            print($offers);
            die();

           $user = DB::table('users')->where('id', $request->id)->decrement('points', 2);

           UserOffer::create([
                'offer_id' => 1, //??
                'user_id' => $request->id,
                'points'=> 2,//??
            ]);
            return response()->json(['Success', 'Compra realizada']);
        }
    }
}




/*
     *Usuario intenta adquirir oferta
     *Se comprueba que tenga los ptos necesarios

     * 1) --->los tiene
                 : peticion al servidor
     * 2) --->No los tiene
                 : Mensaje de error

     *Si los tiene se hace una peticion al servidor con el nombre de la oferta /supermercado

     */



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
