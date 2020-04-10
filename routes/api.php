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
Route::get('items', 'ItemController@getAll');
Route::get('works', 'WorkController@getAll');
Route::get('reviews', 'ReviewController@getAll');

Route::group([
    'middleware' => 'jwt.auth'
], function ($router) {

    Route::get('categories/{id}', 'CategoryController@getOne');
    Route::post('categories/new', 'CategoryController@new');
    Route::post('categories/remove/{id}', 'CategoryController@remove');
    Route::post('categories/update/{id}', 'CategoryController@update');

    Route::get('items/{id}', 'ItemController@getOne');
    Route::post('items/new', 'ItemController@new');
    Route::post('items/remove/{id}', 'ItemController@remove');
    Route::post('items/update/{id}', 'ItemController@update');

    Route::get('files', 'FileController@getAll');
    Route::post('files/new', 'FileController@new');
    Route::post('files/remove/{id}', 'FileController@remove');

    Route::get('works/{id}', 'WorkController@getOne');
    Route::post('works/new', 'WorkController@new');
    Route::post('works/remove/{id}', 'WorkController@remove');
    Route::post('works/update/{id}', 'WorkController@update');

    Route::get('reviews/{id}', 'ReviewController@getOne');
    Route::post('reviews/new', 'ReviewController@new');
    Route::post('reviews/remove/{id}', 'ReviewController@remove');
    Route::post('reviews/update/{id}', 'ReviewController@update');

});