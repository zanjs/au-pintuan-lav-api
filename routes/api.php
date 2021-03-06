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
Route::middleware('auth:api')->get('/group/edit/{id}', 'GroupController@edit');
Route::middleware('auth:api')->post('/group/update/{id}', 'GroupController@update');

Route::middleware('auth:api')->post('/group/open/{id}', 'GroupController@updateOpen');
Route::middleware('auth:api')->post('/group/del/{id}', 'GroupController@destroy');

// comment
Route::middleware('auth:api')->get('/comment', 'CommentController@index');
Route::middleware('auth:api')->post('/comment', 'CommentController@store');
Route::middleware('auth:api')->post('/comment/del/{id}', 'CommentController@destroy');

Route::middleware('auth:api')->get('/comment/{id}', 'CommentController@show');

Route::middleware('auth:api')->get('/group/product/{id}', 'ProductController@show');

Route::middleware('auth:api')->get('/group/product/order/{id}', 'ProductOrderController@show');

Route::middleware('auth:api')->post('/image/upload', 'ImageController@uploadImages');

Route::get('/image/del/{id}', 'ImageController@del');
Route::middleware('auth:api')->post('/image/del/{id}', 'ImageController@destroy');

Route::middleware('auth:api')->post('/image/delete', 'ImageController@delete');

Route::post('/wx/login','WeUserController@login');
Route::post('/wx/login/test','WeUserController@getWxUserInfo');
Route::post('/wx-info','WeUserController@getWxUserInfo');


Route::get('/code/{id}','CodeController@getCode');

Route::get('/time','TimeController@index');
Route::get('/time/{name}','TimeController@show');

Route::middleware('auth:api')->get('/email/send','EmailController@send');

Route::get('/baidu','CodeController@baidu');


Route::get('/baidu','CodeController@baidu');

Route::group(['namespace' => 'Demo','prefix' => 'demo'], function () {
//    Route::get('/code/{id}','CodeController@getCode');
    Route::get('/code_t','CodeController@codeT');
});