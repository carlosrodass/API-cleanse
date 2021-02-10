<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    // public function index(){
        
    //     return Offer::class;
    // }

    public function index() 
    {
        $var = DB::table('offers')
        ->get();
        
        return $var;

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

        if($offersDB){
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
