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
        $response = "";
        //Usuario compra oferta
        //App envia id oferta
        //busqueda oferta
        $offerRequest = $request->get('market_name', 'offer_name');
        $offersDB = DB::table('offers')->get();
        //Comprobacion de si existe la oferta y stock de la oferta
        if(isset($offersDB))
        {
            
            return $response = "existe";
        }
        //Comprobacion de ptos con los ptos de usuario
        //si posee ptos necesarios restar cantidad de stock
        //devolver numero de ptos restados al usuario ss
    }
}
