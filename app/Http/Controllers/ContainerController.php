<?php

namespace App\Http\Controllers;

use App\Models\UserContainer;
use Illuminate\Http\JsonResponse;
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
        return response()->json(['Containers',$response]);
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
     * @param $userId
     * @param $ContainerId
     * @return JsonResponse|string
     */
    public function trade(Request $request, $userId, $ContainerId)
    {
        $validator = Validator::make($request->all(), [
            'trash' => 'required|max:2'
        ]);

        if ($validator->fails()) {
            return response()->json(['error', 'No has introducido nada']);
        }

        $points = (new ContainerServices())->getPoints($request);

        $userContainer = UserContainer::create([
            'user_id' => $userId, //Token?
            'container_id' => $ContainerId,
            'points'=> $points,
            'trash_kilograms' => $request->trash
        ]);
        return response()->json(['Points', $points]);
    }

}
