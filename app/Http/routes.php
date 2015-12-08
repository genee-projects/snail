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
Route::get('/clients/profile', 'ClientController@profile');
Route::post('/clients/add', 'ClientController@add');


#products
Route::get('/products', 'ProductController@products');
Route::get('/products/profile', 'ProductController@profile');
Route::get('/products/add', 'ProductController@add');
Route::get('/products/delete', 'ProductController@delete');


#servers
Route::get('/servers', 'ServerController@servers');
Route::post('/servers/add', 'ServerController@add');
Route::get('/servers/profile/{id}', 'ServerController@profile');
Route::post('/servers/edit', 'ServerController@edit');
Route::get('/servers/delete/{id}', 'ServerController@delete');


#templates
Route::get('/templates', 'TemplateController@index');
Route::get('/templates/generate', 'TemplateController@generate');