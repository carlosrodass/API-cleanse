<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContainerController extends Controller
{


    public function index(){
        
        return  Card::all();
    }


    //Método mostrando Contenedores segun la calle introducida y devolviendo el numero de la calle y el nombre 
    public function findContainerByName($streename) 
    {
        $var = DB::table('containers')
        ->where('street_name', '=', $streename)
        ->get(['street_number', 'street_name']);

        return $var;
    }

    
}
