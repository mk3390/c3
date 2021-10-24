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
Route::group([ 'prefix' => 'auth'], function (){
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'Api\AuthController@login');
        Route::post('signup', 'Api\AuthController@signup');
    });
    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'Api\AuthController@logout');
        Route::post('getuser', 'Api\AuthController@getUser');
    });
});


Route::post('upload', 'PostConroller@uploadImages');
Route::group(['middleware' => 'auth:api'], function() {
    Route::post('block', 'BlockController@store');
    Route::post('message', 'MessageController@store');
    Route::get('message/{id}', 'MessageController@show');
    Route::get('messages/list', 'MessageController@index');
    Route::post('message/group', 'MessageGroupController@store');
    Route::post('profile', 'UserController@update');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
