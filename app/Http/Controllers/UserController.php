<?php

namespace App\Http\Controllers;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{

    //Loguin de usuario
    public function authenticate(Request $request)
    {
    //Credenciales que debe introducir el usuario para loguin
    $credentials = $request->only('email', 'password');
    try {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
        }
    } catch (JWTException $e) {
        return response()->json(['error' => 'could_not_create_token'], 500);
    }
    //Respuesta (token) si el acceso ha sido success
    return response()->json(compact('token'));
    }


    //Perfil de usuario
    public function getAuthenticatedUser()
    {

    try {
        if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
        }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                return response()->json(['token_absent'], $e->getStatusCode());
        }
        //Devolviendo informacion del usuario
        return response()->json(compact('user'));
    }


    //Registro de usuario
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
    		'username' => 'required|string|max:255',
    		'email' => 'required|string|email|max:255|unique:users',
    		'password' => 'required|string|min:6|confirmed',
            
        ]);

        if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            // 'points' => $request->get('points')
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user','token'),201);
    }

    //Actualizar perfil de usuario
    public function updateUserProfile(Request $request){
        
    }
}


   // //Método mostrando usuario por su nombre de usuario y devolviendo nombreusuario, email y puntos 
    // public function findUser($username) 
    // {
    //     $var = DB::table('users')
    //     ->where('username', '=', $username)
    //     ->get(['username', 'email', 'points', 'image']);
        
    //     return $var;

    // }