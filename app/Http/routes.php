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
    'as'=> 'client.profile',
    'uses'=> 'ClientController@profile',
]);

Route::post('/clients/add', 'ClientController@add');
Route::post('/clients/edit', 'ClientController@edit');
Route::get('/clients/delete/{id}', 'ClientController@delete');


#products
Route::get('/products', [
    'as'=> 'products',
    'uses'=> 'ProductController@products',
]);

Route::get('/products/profile/{id}', [
    'as'=> 'product.profile',
    'uses'=> 'ProductController@profile',
]);

Route::post('/products/add', [
    'as'=> 'product.add',
    'uses'=> 'ProductController@add',

]);

Route::get('/products/delete', [
    'as'=> 'product.delete',
    'uses'=> 'ProductController@delete',
]);

Route::post('/products/edit', [
    'as'=> 'product.edit',
    'uses'=> 'ProductController@edit',
]);

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
Route::get('/projects', [
    'as' => 'projects',
    'uses'=> 'ProjectController@index',
]);

Route::post('/projects/add', 'ProjectController@add');
Route::get('/projects/profile/{id}', [
    'as'=> 'project.profile',
    'uses'=> 'ProjectController@profile',
]);

Route::post('/projects/{id}/servers', [
    'as'=> 'project.server',
    'uses'=> 'ProjectController@server',
]);

Route::get('/projects/delete/{id}', [
    'as'=> 'project.delete',
    'uses'=> 'ProjectController@delete',
]);

Route::post('/projects/edit', [
    'as'=> 'project.edit',
    'uses'=> 'ProjectController@edit'
]);

#service start
Route::post('/services/add', [
    'as'=> 'service.add',
    'uses'=> 'ServiceController@add',
]);

Route::get('/services/delete/{id}', [
    'as'=> 'service.delete',
    'uses'=> 'ServiceController@delete',
]);

Route::post('/services/edit/{id}', [
    'as'=> 'service.edit',
    'uses'=> 'ServiceController@edit',
]);
# service end

# item start
Route::post('/items/add', [
    'as'=> 'item.add',
    'uses'=> 'ItemController@add',
]);

Route::get('/items/delete/{id}', [
    'as'=> 'item.delete',
    'uses'=> 'ItemController@delete',
]);
# item end

# modules start
Route::post('/modules/add', [
    'as'=> 'module.add',
    'uses'=> 'ModuleController@add',
]);

Route::get('/modules/delete/{id}', [
    'as'=> 'module.delete',
    'uses'=> 'ModuleController@delete',
]);

Route::post('/modules/edit/{id}', [
    'as'=> 'module.edit',
    'uses'=> 'ModuleController@edit',
]);


Route::get('/modules/delete/{id}', [
    'as'=> 'module.delete',
    'uses'=> 'ModuleController@delete',
]);

# modules end
