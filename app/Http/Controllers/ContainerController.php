<?php

namespace App\Http\Controllers;

use App\Models\UserContainer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Container;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Services\ContainerServices;

class ContainerController extends Controller
{

      /**
     *Buscando todos los contenedores 
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
        return response($response); //Array de json con contenedores
        // ->json(['Containers',$response]);
    }

     /**
     *Buscando contenedores por nombre de calle
     * @param $street_name
     * @return JsonResponse|string
     */
    public function findContainerByName(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'street_name' => 'required',
        ]);

        $locations = Container::where('street_name', $request->street_name)->get();
        foreach ($locations as $containers){
            $response[] = [
                'Street'=> $containers->street_name,
                'Number'=>$containers->street_number
            ];
        }
       return response($response); // Array de json con contendores
    //    ->json(['Success' => $response]);
    }


    /**
     *Intercambio entre contenedores y usuario, basura por puntos
     * @param Request $request
     * @param $userId
     * @param $ContainerId
     * @return JsonResponse|string
     */
    public function trade(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trash' => 'required|max:2',
            'container_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error', 'No has introducido nada']);
        }

        $auth = auth()->user(); //Cogiendo el usuario autenticado actualmente

        $points = (new ContainerServices())->getPoints($request);

        DB::table('users')->where('id', $auth->id)->increment('points', $points);

        

        $userContainer = UserContainer::create([
            'user_id' =>$auth->id,
            'container_id' => $request->container_id,
            'points'=> $points,
            'trash_kilograms' => $request->trash
        ]);
        return response($points);
    }

}
