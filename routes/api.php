<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Found container without verification
Route::post('container', 'App\Http\Controllers\ContainerController@findContainerByName');

//Register and login Users route
Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('login', 'App\Http\Controllers\UserController@authenticate');

//Token Verification 
Route::group(['middleware' => ['jwt.verify']], function() {

    //User routes
    Route::post('user','App\Http\Controllers\UserController@getAuthenticatedUser');

    //Offers routes
    Route::get('offer', 'App\Http\Controllers\OfferController@index');
    Route::post('offertrade', 'App\Http\Controllers\OfferController@tradeOffers');


    //Container routes
    Route::post('containertrade', 'App\Http\Controllers\ContainerController@amounttrash');

});
