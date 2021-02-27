<?php


namespace App\Http\Services;


use Illuminate\Http\Request;

class ContainerServices
{
    public function getPoints(Request $request){


        $quantitySTR = $request->trash; //STR
        $quantity = (int)$quantitySTR; // INT
        $str = "";

        $points = 0;

        if($quantity >= 1 && $quantity <= 10){
            $points = 5;
            $str = (string) $points; //STR

        }
        if($quantity >= 11 && $quantity <= 20){
            $points = 15;
            $str = (string) $points;//STR

        }
        if($quantity >= 21 && $quantity <= 30){
            $points = 25;
            $str = (string) $points;//STR

        }
        if($quantity >= 31 && $quantity <= 40){
            $points = 35;
            $str = (string) $points;//STR

        }

        return $str;
    }
}




        // switch ($quantity) {
        //     case $quantity < 0 && $quantity >= 10 :
        //         $points = 5;
        //         $str = (string) $points;
        //         return response()->json(['Points', $str]);
        //         break;
        //     case $quantity < 11 && $quantity > 20:
        //         $points = 15;
        //         $str = (string) $points;
        //         return response()->json(['Points', $str]);
        //         break;
        //     case $quantity < 21 && $quantity > 30:
        //         $points = 20;
        //         $str = (string) $points;
        //         return response()->json(['Points', $str]);
        //         break;
        // }

