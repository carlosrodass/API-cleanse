<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\UserOfferController;

// //Found container without verification
// Route::post('container', 'App\Http\Controllers\ContainerController@findContainerByName');

// //Register and login Users route
// Route::post('register', 'App\Http\Controllers\UserController@register');
// Route::post('login', 'App\Http\Controllers\UserController@authenticate');

// //Token Verification
// Route::group(['middleware' => ['jwt.verify']], function() {

//     //User routes
//     Route::post('user','App\Http\Controllers\UserController@getAuthenticatedUser');

//     //Offers routes
//     Route::get('offer', 'App\Http\Controllers\OfferController@index');
//     Route::post('offertrade', 'App\Http\Controllers\OfferController@tradeOffers');


//     //Container routes
//     Route::post('containertrade', 'App\Http\Controllers\ContainerController@amounttrash');

// });


/*
*Grupo de rutas de usuarios , Registro/Login/Reset_password/show_profile/update_profile y verificacion del token
*/


Route::post('register',[UserController::class, 'store']);

Route::post('login',[UserController::class, 'signIn']);

Route::put('reset',[UserController::class, 'resetPass']);

Route::group(['prefix' => 'users', 'middleware' => ['jwt.verify']], function (){

	Route::get('/profile',[UserController::class, 'show']);

	Route::put('/update/{id}',[UserController::class, 'update']);

});

/*
*Grupo de rutas de ofertas , comprar_ofertas/ver_ofertas y middleware
*/
Route::group(['prefix' => 'offers', 'middleware' => ['jwt.verify']], function (){

	Route::post('/trade',[OfferController::class, 'trade']);

	Route::get('/all',[OfferController::class, 'show']);

});


/*
*Grupo de rutas de contenedores , ver_contenedores/trade y middleware
*/
Route::group(['prefix' => 'containers', 'middleware' => ['jwt.verify']], function (){

	Route::post('/trade',[ContainerController::class, 'trade']);

	Route::post('/show',[ContainerController::class, 'findContainerByName']);

	Route::get('/all',[ContainerController::class, 'show']);

});

Route::group(['prefix' => 'buyed', 'middleware' => ['jwt.verify']], function (){

	Route::get('/show',[UserOfferController::class, 'show']);

});
