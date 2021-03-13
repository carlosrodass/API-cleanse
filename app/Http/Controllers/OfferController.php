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
                'id' =>$offer->id,
                'Offer'=> $offer->offer_name,
                'Market'=>$offer->market_name,
                'Points'=>$offer->points,
                'Stock'=>$offer->stock
            ];
        }
        return response($response); // Array de ofertas
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
            'offer_name' => 'required', ///Nombre del producto de la oferta
            'market_name' => 'required', ///Supermercado que tiene la oferta
            'points' => 'required', /// Ptos que posee el usuario
            'offer_id' => 'required' ///Codigo de la oferta

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
  
        if(!$offers){
            return response()->json(['error', 'No existe la oferta']);
        }else{

            $auth = auth()->user();//Cogiendo el usuario autenticado actualmente

            Offer::where('offer_name', $request->offer_name)-> decrement('stock', 1);

            $offer = Offer::find($request->offer_id);

            $user = DB::table('users')->where('id', $auth->id)->decrement('points', $offer->points);

            UserOffer::create([
                'offer_id' =>  $request->offer_id,
                'user_id' => $auth->id,
                'points'=> $offer->points,
            ]);
            return response()->json(['Success', 'Compra realizada']);
        }
    }
}

