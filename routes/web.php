<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\UserOfferController;


Route::post('register',[UserController::class, 'store']);

//Rutas usuario
Route::get('/user/{username}/', 'App\Http\Controllers\UserController@findUser');


//Rutas contenedores
Route::get('/container', 'App\Http\Controllers\ContainerController@index');
Route::get('/container/{street_name}/', 'App\Http\Controllers\ContainerController@findContainerByName');


//Rutas Ofertas
Route::get('/offer', 'App\Http\Controllers\OfferController@index');