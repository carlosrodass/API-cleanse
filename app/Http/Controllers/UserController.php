<?php

namespace App\Http\Controllers;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;


class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     *User register
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        User::create($request->validated());
        return response()->json(['Success' => 'Registered user'],201);
    }

    /**
     * User login
     * @param Request $request
     * @return JsonResponse|string
     */
    public function SignIn(Request $request): JsonResponse
    {

        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Incorrect credentials'],401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        return response()->json(['Token' => $token],200);
    }

    /**
     *reset forgotten password
     * @param Request $request
     * @return JsonResponse|string
     */
    public function resetPass(Request $request)
    {

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

        // $request->validate(['email' => 'required|email']);

        // if($credentials){

        //     $user = DB::table('users')->where('email',$credentials->email)->get();

        //     if($user) {

        //         $password = Hash::make($credentials->new_password);
        //         // $user->password = Hash::make($password);
        //         $user->password = $password;

        //         try{
        //             $user->save();
        //             return response()->json(['Contraseña:' => $password]);
        //         } catch(Exception $e){
        //             return response()->json(['error: ' => $e]);
        //         }

        //     }else{
        //         return response()->json(['Error' => 'No estas registrado']);
        //         }
        // }
        // return response()->json(['Error' => 'Faltan datos']);
    }
     /**
     * Show user profile
     * @param
     * @return JsonResponse|string
     */
    public function show()
    {
         try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                    return response()->json(['User not found'], 404);
            }
            } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                    return response()->json(['Expired Token'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                    return response()->json(['Invalid Token'], $e->getStatusCode());
            } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                    return response()->json(['Token not found'], $e->getStatusCode());
            }
        return response($user , 200);

    }
     /**
     * update profile
     * @param
     * @return JsonResponse|string
     */
    public function update(CreateUserRequest $request){

        auth()->user()->update($request->validated());

        return Response()->json(['Success'=> 'Profile updated'], 200);

    }

    public function logOut(){
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                "status" => "success",
                "message"=> "User successfully logged out"
            ], 200);
        } catch (JWTException $e) {
            return response()->json([
            "status" => "error",
            "message" => "Failed to logout, please try again"
            ], 500);
        }

    }
}


