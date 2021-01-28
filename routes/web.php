<?php

use Illuminate\Support\Facades\Route;

//Rutas usuario
Route::get('/user/{username}/', 'App\Http\Controllers\UserController@findUser');


//Rutas contenedores
Route::get('/container', 'App\Http\Controllers\ContainerController@index');
Route::get('/container/{street_name}/', 'App\Http\Controllers\ContainerController@findContainerByName');


//Rutas Ofertas
Route::get('/offer', 'App\Http\Controllers\OfferController@index');