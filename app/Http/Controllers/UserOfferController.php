<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserOffer;
use App\Models\User;

class UserOfferController extends Controller
{

    /**
    * Esta mal, arreglar
    */
    public function show(){

        $auth = auth()->user();

        $offersBuyed = UserOffer::where('user_id','=', $auth->id)->get();

        if($offersBuyed){
           
            $response = [];
            foreach ($offersBuyed as $offers){
                
                $response[] = [
                    'Market'=> $offers->offer_id,
                    'Points'=>$offers->points
                ];
            }
            return response($response, 200);
        }

        return response()->json(['Market' => 'No market' , 'Points' => 'No points'], 200);   
    }


    
}


    


