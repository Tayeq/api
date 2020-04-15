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

Route::middleware('auth:api')->group(function () {
    Route::get('/characters', 'Api\CharactersController@all')->name('characters.all');

    Route::get('/characters/{name}', 'Api\CharactersController@get')->name('characters.get');

    Route::post('/characters/refresh', 'Api\CharactersController@refresh')->name('characters.refresh');

    Route::fallback(function(){
        return response()->json(['message' => 'Not Found.'], 404);
    })->name('api.fallback.404');
});


