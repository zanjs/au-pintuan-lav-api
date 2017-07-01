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

Route::middleware('auth:api')->get('/group', 'GroupController@index');
Route::middleware('auth:api')->post('/group', 'GroupController@store');

Route::middleware('auth:api')->get('/group/{id}', 'GroupController@show');

Route::middleware('auth:api')->post('/group/open/{id}', 'GroupController@updateOpen');

// comment
Route::middleware('auth:api')->get('/comment', 'CommentController@index');
Route::middleware('auth:api')->post('/comment', 'CommentController@store');

Route::middleware('auth:api')->get('/comment/{id}', 'CommentController@show');

Route::middleware('auth:api')->post('/image/upload', 'ImageController@uploadImages');

Route::post('/wx/login','WeUserController@login');
Route::post('/wx/login/test','WeUserController@getWxUserInfo');
Route::post('/wx-info','WeUserController@getWxUserInfo');