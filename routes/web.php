<?php

use Illuminate\Support\Facades\Route;


Route::get('/user/{username}/', 'App\Http\Controllers\UserController@findUser');
Route::get('/container/{street_name}/', 'App\Http\Controllers\ContainerController@findContainer');
