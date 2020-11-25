<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/hasTeam', 'AboutUserController@ifUerHasTeam');

    Route::prefix('/save')->group(function (){
        Route::post('/team', 'AboutUserController@saveTeam');
        Route::post('/member', 'AboutUserController@saveMember');
    });

    Route::prefix('/user')->group(function () {
        Route::get('/info', 'AboutUserController@show');
    });

    Route::prefix('/ressources')->group(function () {
        Route::get('/category', function () {
            return response()->json(array_map('getObjectFromArray', array_keys(\App\Models\Team::Category) ,  array_values(\App\Models\Team::Category)), 200);
        });
    });


});

Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::post('/register', 'AuthController@register');
