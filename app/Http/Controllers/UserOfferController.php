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
    public function show($id){

        $offersBuyed = UserOffer::where('user_id','=', $id)->get();

        if($offersBuyed){
           
            $response = [];
            foreach ($offersBuyed as $offers){
                $response[] = [
                    'Market'=> $offers->offer_id,
                    'Points'=>$offers->points
                ];
            }
            return response($response);
        }

        return response()->json(['No offers buyed']);   
    }
}


