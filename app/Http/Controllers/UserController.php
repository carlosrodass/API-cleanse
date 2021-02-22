<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Helpers\MyJWT;
use Exception;
use \Firebase\JWT\JWT;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

    // use Tymon\JWTAuth\Exceptions\JWTException;
    // use JWTAuth;

class UserController extends Controller
{

    /**
     *Registro de usuario
     * @param Request $request
     * @return JsonResponse
     */
    public function signUp(Request $request): JsonResponse
    {
        $response = "";

        $data = $request->getContent();
        $data = json_decode($data);

        if($data){
            $user = new User();
            $user->username = $data->username;
            $user->email = $data->email;
            $user->password = Hash::make($data->password);
            try{
                $user->save();
                $response = response()->json(['Success' => 'Usuario registrado']);

            }catch(Exception $e){
                $fail=$e->getMessage();
                $response = response()->json(['Error' => $fail]);
            }

        }else{
            $response = response()->json(['Empty' => 'No has introducido datos']);
        }


        return $response;
    }

    /**
     *Login de usuario
     * @param Request $request
     * @return JsonResponse|string
     */
    public function SignIn(Request $request)
    {
        $response = "";
        $data = $request->getContent();

        $data = json_decode($data);

        //Si hay datos
        if($data){
            //Comprobando que no exista un usuario con el mismo nombre
            $userEmail = $data->email;
            //Buscando si existe email en la base de datos
            $user = User::where('email', $userEmail)->get()->first();
            //Si el usuario existe
            if($user){

                //Comprobando la contraseña del usuario sea igual que la introducida
                if(Hash::check($data->password,$user->password)){

                    $payload = MyJWT::generatePayload($user);
                    $key = MyJWT::getKey();
                    //Encodificando los datos del usuario para enviarlos
                    $jwt = JWT::encode($payload, $key);

                    try{
                        $user->save();
                        $response = response()->json(['token' => $jwt], 200);

                    } catch(Exception $e){
                        $response=$e->getMessage();
                    }
                }else{
                    $response = response()->json(['error' => 'Credenciales incorrectas'], 400);
                }

            //Si el usuario NO existe
            }else{
                $response = response()->json(['error' => 'Usuario no existe']);
            }
        //Si NO hay datos
        }else{
            // $response = "No hay datos introducidos";
            $response = response()->json(['error' => 'Introduce los datos']);
        }
        return $response;
    }

    /**
     *Recuperar contraseña de usuario
     * @param Request $request
     * @return JsonResponse|string
     */
    public function resetPass(Request $request){

        $response="";

        //Recogiendo los datos escritos por el usuario
        $data = $request->getContent();
        // Decodificar el json
        $data = json_decode($data);


        if($data){
             //Buscando usuario por email
            $user = DB::table('users')->where('email',$data->email)->get()->first();
            //Si existe el usuario
            if($user) {

                //$password= "";
                //Generar nueva contraseña
                $password = Str::random(15);
                //Reseteando contraseña
                $user->password = Hash::make($password);
                $user->password = $password;

                try{
                    //Guardando contraseña
                    $user->save();
                    $response = response()->json(['New password' => $password]);
                } catch(Exception $e){
                    $response=$e->getMessage();
                    }

                }else{
                    $response = response()->json(['Error' => 'Usuario no encontrado']);
                }

        }else{
            $response = response()->json(['Error' => 'No hay datos']);
        }


        return $response;

    }


    //Perfil de usuario
    public function show()
    {

        //$response = [];
        $key = MyJWT::getKey();
        $headers = getallheaders();
        $decoded = JWT::decode($headers['token'], $key, array('HS256'));

        //Si el usuario esta logueado
        if($decoded->id){
            $user = DB::table('users')->where('id',$decoded->id)->get()->first();

            $response = [
                'username' =>$user->username,
                'points' =>$user->points
            ];

        }
        else{
            $response = response()->json(['Failure' => 'No estas logueado']);
        }

        return $response;
    }

    //Actualizar perfil de usuario
    public function updateProfile(Request $request){

    }
}





    // //Loguin de usuario
    // public function authenticate(Request $request)
    // {
    // //Credenciales que debe introducir el usuario para loguin
    // $credentials = $request->only('email', 'password');
    // try {
    //     if (!$token = JWTAuth::attempt($credentials)) {
    //         return response()->json(['error' => 'invalid_credentials'], 400);
    //     }
    // } catch (JWTException $e) {
    //     return response()->json(['error' => 'could_not_create_token'], 500);
    // }
    // //Respuesta (token) si el acceso ha sido success
    // return response()->json(compact('token'));
    // }



    // //Registro de usuario
    // public function signUp(Request $request)
    // {
    //     $response = "";
    //     $data = $request->getContent();
    //     $data = json_decode($data);

    //     if($data){

    //     }else{

    //     }

    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6|confirmed',

    //     ]);

    //     if($validator->fails()){
    //             return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     $user = User::create([
    //         'username' => $request->get('username'),
    //         'email' => $request->get('email'),
    //         'password' => Hash::make($request->get('password')),
    //         // 'points' => $request->get('points')
    //     ]);

    //     $token = JWTAuth::fromUser($user);

    //     return response()->json(compact('user','token'),201);
    // }



        // try {
        //     if (!$user = JWTAuth::parseToken()->authenticate()) {
        //             return response()->json(['user_not_found'], 404);
        //     }
        //     } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
        //             return response()->json(['token_expired'], $e->getStatusCode());
        //     } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
        //             return response()->json(['token_invalid'], $e->getStatusCode());
        //     } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
        //             return response()->json(['token_absent'], $e->getStatusCode());
        //     }
        // //Devolviendo informacion del usuario
        // return response()->json(compact('user'));
