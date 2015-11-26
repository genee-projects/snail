<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

#clients
Route::get('/', 'DashboardController@index');


Route::get('/clients', 'ClientController@clients');
Route::get('/clients/add', 'ClientController@add');
Route::get('/clients/profile', 'ClientController@profile');

#products
Route::get('/products', 'ProductController@products');
Route::get('/products/profile', 'ProductController@profile');


#servers
Route::get('/servers', 'ServerController@servers');
Route::get('/servers/profile', 'ServerController@profile');