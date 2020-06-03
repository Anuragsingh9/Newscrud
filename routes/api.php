<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function()
{
  
Route::post('news','NewsController@store');
Route::get('news','NewsController@index');
Route::get('news/{id}','NewsController@show');
Route::post('news/{id}','NewsController@update');
Route::delete('news/{id}','NewsController@destroy');

Route::post('news/{id}/review','ReviewController@save');
Route::get('news/{id}/review','ReviewController@show');
Route::post('news/review/{id}','ReviewController@update');
Route::delete('news/review/{id}','ReviewController@destroy');


});




