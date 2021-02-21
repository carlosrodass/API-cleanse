<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ContainerController;

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
*Grupo de rutas de usuarios , Registro/Login/Reset_password/show_profile/update_profile
*/
Route::prefix('users')->group(function (){

	Route::post('/register',[UserController::class, 'signUp']);

	Route::post('/login',[UserController::class, 'signIn']);

	Route::put('/reset',[UserController::class, 'resetPass']);

	Route::get('/profile',[UserController::class, 'show']);

	Route::post('/update',[UserController::class, 'updateProfile']);

});


/*
*Grupo de rutas de ofertas , comprar_ofertas/ver_ofertas
*/
Route::prefix('offers')->group(function (){

	Route::post('/buy',[OfferController::class, 'tradeOffers']);

	Route::get('/all',[OfferController::class, 'showOffers']);

	// Route::post('/update',[UserController::class, 'updateProfile']);

});


/*
*Grupo de rutas de ofertas , comprar_ofertas/ver_ofertas
*/
Route::prefix('containers')->group(function (){

	Route::post('/trade',[ContainerController::class, 'tradeTrash']);

	Route::post('/show',[ContainerController::class, 'findContainerByName']);

	// Route::post('/update',[UserController::class, 'updateProfile']);

});
