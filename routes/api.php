<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/container/{street_name}/', 'App\Http\Controllers\ContainerController@findContainerByName');

Route::post('register', 'App\Http\Controllers\UserController@register');
Route::post('login', 'App\Http\Controllers\UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user','App\Http\Controllers\UserController@getAuthenticatedUser');
    Route::get('offer', 'App\Http\Controllers\OfferController@index');


});
