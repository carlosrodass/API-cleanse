<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOffer;
use App\Models\User;

class UserOfferController extends Controller
{

    /**
     * Mostrando ofertas compradas y cantidad de puntos de cada compra
     * @param 
     * @return JsonResponse
    */
    public function show(){

        $auth = auth()->user();

        $user = User::where('id','=', $auth->id)->first();

            $response = [];

            foreach ($user->offer as $oneOffer){
                
                $response[] = [
                    'Market'=> $oneOffer->offer_name,
                    'Points'=>$oneOffer->points
                ];
            }
            return response($response, 200);
  

        return response()->json(['Market' => 'No market' , 'Points' => 'No points'], 200);   
    }


    


    
}


    


