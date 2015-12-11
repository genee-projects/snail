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
Route::get('/clients', [
    'as'=> 'clients',
    'uses'=> 'ClientController@clients',
]);

Route::get('/clients/profile/{id}', [
    'uses'=> 'ClientController@profile',
    'as'=> 'client.profile',
]);

Route::post('/clients/add', 'ClientController@add');
Route::post('/clients/edit', 'ClientController@edit');
Route::get('/clients/delete/{id}', 'ClientController@delete');


#products
Route::get('/products', [
    'as'=> 'products',
    'uses'=> 'ProductController@products',
]);

Route::get('/products/profile', 'ProductController@profile');
Route::get('/products/add', 'ProductController@add');
Route::get('/products/delete', 'ProductController@delete');


#servers
Route::get('/servers', [
    'as'=> 'servers',
    'uses'=> 'ServerController@servers',
]);

Route::get('/servers.json', [
    'as'=> 'servers.json',
    'uses'=> 'ServerController@servers_json',

]);

Route::post('/servers/add', 'ServerController@add');

Route::get('/servers/profile/{id}', [
    'as'=> 'server.profile',
    'uses'=> 'ServerController@profile',
]);

Route::post('/servers/edit', 'ServerController@edit');
Route::get('/servers/delete/{id}', 'ServerController@delete');


#comments
Route::post('/comments/add', 'CommentController@add');
Route::get('/comments/delete/{id}', 'CommentController@delete');

#templates
Route::get('/templates', 'TemplateController@index');
Route::get('/templates/generate', 'TemplateController@generate');


#projects
Route::get('/projects', 'ProjectController@index');
Route::post('/projects/add', 'ProjectController@add');
Route::get('/projects/profile/{id}', [
    'as'=> 'project.profile',
    'uses'=> 'ProjectController@profile',
]);

Route::post('/projects/{project_id}/servers', [
    'as'=> 'project.server',
    'uses'=> 'ProjectController@server',
]);


Route::group(['namespace'=> 'API', 'prefix'=> 'api'], function() {

    Route::resource('products', 'ProductsController');
});