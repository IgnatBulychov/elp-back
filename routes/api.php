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

Route::group([
    'middleware' => 'jwt.auth'
], function ($router) {

    Route::get('categories', 'CategoryController@getAll');
    Route::post('categories/new', 'CategoryController@new');

    Route::get('pricecategories', 'PriceCategoriesController@all');
    Route::get('pricecategories/{id}', 'PriceCategoriesController@get');
    Route::post('items/new', 'ItemController@new');
    Route::post('pricecategories/remove/{id}', 'PriceCategoriesController@remove');
    Route::post('pricecategories/update/{id}', 'PriceCategoriesController@update');

    Route::get('price', 'PriceItemsController@getAllWithCategory');



    
    Route::get('portfolioitems', 'PortfolioController@all');
    Route::get('portfolioitem/{id}', 'PortfolioController@get');
    Route::post('portfolioitems/new', 'PortfolioController@new');
    Route::post('portfolioitems/remove/{id}', 'PortfolioController@remove');
    Route::post('portfolioitems/update/{id}', 'PortfolioController@update');

    Route::get('priceitems/', 'PriceItemsController@all');
    Route::get('priceitems/{id}', 'PriceItemsController@getByCategory');
    Route::get('priceitem/{id}', 'PriceItemsController@get');
    Route::post('priceitems/new', 'PriceItemsController@new');
    Route::post('priceitems/remove/{id}', 'PriceItemsController@remove');
    Route::post('priceitems/update/{id}', 'PriceItemsController@update');

});