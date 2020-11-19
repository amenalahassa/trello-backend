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

    Route::get('/hasTeam', function (Request $request) {
        $teams = Auth::user()->teams;
        $hasteam = false;
        if (count($teams) > 0)
        {
            $hasteam = true;
        }
        return response()->json(['userHasTeam' => $hasteam], 200);
    });



});

Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::post('/register', 'AuthController@register');
