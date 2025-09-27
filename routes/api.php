<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
//    'middleware' =>  [ 'api'] + (env('APP_DEBUG') === false ? ['corsOff']: []),
    'middleware' =>  [ 'api'],
    'prefix' => 'v1/auth',
    'namespace'=>'Api\V1'

], function ($router) {
    Route::post('logout', 'AuthController@logout')
        ->middleware('jwt-check');

    Route::post('refresh', 'AuthController@refresh')
        ->middleware('jwt-check');

    Route::any('me', 'AuthController@me')
        ->middleware('corsOff');

    Route::any('me', 'AuthController@me')
        ->middleware('corsOff');

    Route::get('tasks', 'TaskController@index')
        ->middleware('jwt-check');
});

Route::group([
    'middleware' => ['api'],
    'prefix' => 'v1',
    'namespace'=>'Api\V1'

], function ($router) {

});
