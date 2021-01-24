<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //Método mostrando usuario por su nombre de usuario y devolviendo nombreusuario, email y puntos 
    public function findUser($username) 
    {
        $var = DB::table('users')
        ->where('username', '=', $username)
        ->get(['username', 'email', 'points', 'image']);
        
        return $var;

    }
}
