<?php

namespace App\Http\Controllers;

use App\Models\UserContainer;
use Illuminate\Http\Request;
use App\Models\Container;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\ContainerServices;

class ContainerController extends Controller
{

      /**
     *Buscando contenedores por nombre de calle
     * @param
     * @return JsonResponse|string
     */
    public function show(){

        $response = [];
        foreach (Container::all() as $containers){
            $response[] = [
                'Street'=> $containers->street_name,
                'Number'=>$containers->street_number
            ];
        }
        return response()->json(['Containers',$response], 200);
    }

     /**
     *Buscando contenedores por nombre de calle
     * @param $street_name
     * @return JsonResponse|string
     */
    public function findContainerByName($street_name)
    {
        $locations = Container::where('street_name', $street_name)->get();
        foreach ($locations as $containers){
            $response[] = [
                'Street'=> $containers->street_name,
                'Number'=>$containers->street_number
            ];
        }
       return response()->json(['Success' => $response]);
    }


    /**
     *Intercambio entre contenedores y usuario, basura por puntos
     * @param Request $request
     * @return JsonResponse|string
     */
    public function trade(Request $request, $userId, $ContainerId)
    {
        $validator = Validator::make($request->all(), [
            'trash' => 'required|max:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error', 'no es numero']);
        }

        $points = (new ContainerServices())->getPoints($request);

        $userContainer = UserContainer::create([
            'user_id' => $userId,
            'container_id' => $ContainerId,
            'points'=> $points,
            'trash_kilograms' => $request->trash
        ]);
        return response()->json(['Points', $points]);
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
