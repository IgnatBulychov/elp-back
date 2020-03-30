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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::get('categories', 'CategoryController@getAll');
Route::get('categories/{id}', 'CategoryController@getOne');
Route::get('items', 'ItemController@getAll');
Route::get('items/{id}', 'ItemController@getOne');
Route::get('works', 'WorkController@getAll');
Route::get('works/{id}', 'WorkController@getOne');

Route::group([
    'middleware' => 'jwt.auth'
], function ($router) {

    Route::post('categories/new', 'CategoryController@new');
    Route::post('categories/remove/{id}', 'CategoryController@remove');
    Route::post('categories/update/{id}', 'CategoryController@update');

    Route::post('items/new', 'ItemController@new');
    Route::post('items/remove/{id}', 'ItemController@remove');
    Route::post('items/update/{id}', 'ItemController@update');

    Route::get('files', 'FileController@getAll');
    Route::post('files/new', 'FileController@new');
    Route::post('files/remove/{id}', 'FileController@remove');

    Route::post('works/new', 'WorkController@new');
    Route::post('works/remove/{id}', 'WorkController@remove');
    Route::post('works/update/{id}', 'WorkController@update');

});