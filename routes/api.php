<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



// Route::get('/users/{username}/', 'App\Http\Controllers\UserController@find');

//Rutas usuario
Route::get('/user/{username}/', 'App\Http\Controllers\UserController@findUser');


//Rutas contenedores
Route::get('/container', 'App\Http\Controllers\ContainerController@index');
Route::get('/container/{street_name}/', 'App\Http\Controllers\ContainerController@findContainerByName');


//Rutas Ofertas
Route::get('/offer', 'App\Http\Controllers\OfferController@index');