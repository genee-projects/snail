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

#dashboard
Route::get('/', 'DashboardController@index');


#clients
Route::get('/clients', 'ClientController@clients');
Route::get('/clients/profile/{id}', 'ClientController@profile');
Route::post('/clients/add', 'ClientController@add');
Route::post('/clients/edit', 'ClientController@edit');
Route::get('/clients/delete/{id}', 'ClientController@delete');


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


#comments
Route::post('/comments/add', 'CommentController@add');
Route::get('/comments/delete/{id}', 'CommentController@delete');
Route::get('/comments/profile/{id}', 'CommentController@profile');


#templates
Route::get('/templates', 'TemplateController@index');
Route::get('/templates/generate', 'TemplateController@generate');


#projects
Route::get('/projects', 'ProjectController@index');
Route::post('/projects/add', 'ProjectController@add');
Route::get('/projects/profile/{id}', 'ProjectController@profile');