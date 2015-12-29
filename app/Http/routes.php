<?php


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

Route::post('/clients/add', [
    'as'=> 'client.add',
    'uses'=> 'ClientController@add',
]);

Route::post('/clients/edit', [
    'as'=> 'client.edit',
    'uses'=> 'ClientController@edit',
]);

Route::get('/clients/delete/{id}', [
    'as'=> 'client.delete',
    'uses'=> 'ClientController@delete',
]);
#clients end

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

Route::get('/products/delete/{id}', [
    'as'=> 'product.delete',
    'uses'=> 'ProductController@delete',
]);

Route::post('/products/edit', [
    'as'=> 'product.edit',
    'uses'=> 'ProductController@edit',
]);

Route::post('/products/{id}/modules', [
    'as'=> 'product.module',
    'uses'=> 'ProductController@modules',
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
Route::get('/servers/delete/{id}', [
    'as'=> 'server.delete',
    'uses'=> 'ServerController@delete',
]);


#comments
Route::post('/comments/add', 'CommentController@add');
Route::get('/comments/delete/{id}', 'CommentController@delete');

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
    'as'=> 'project.servers',
    'uses'=> 'ProjectController@servers',
]);

Route::get('/projects/delete/{id}', [
    'as'=> 'project.delete',
    'uses'=> 'ProjectController@delete',
]);

Route::post('/projects/edit', [
    'as'=> 'project.edit',
    'uses'=> 'ProjectController@edit'
]);

Route::post('/projects/{id}/modules', [
    'as'=> 'project.modules',
    'uses'=> 'ProjectController@modules',
]);

Route::post('/projects/{id}/params', [
    'as'=> 'project.params',
    'uses'=> 'ProjectController@params',
]);

Route::post('/projects/{id}/hardwares', [
    'as'=> 'project.hardwares',
    'uses'=> 'ProjectController@hardwares',
]);

Route::post('/projects/{id}/param', [
    'as'=> 'project.param.edit',
    'uses'=> 'ProjectController@param_edit',
]);

Route::post('/projects/{id}/hardware', [
    'as'=> 'project.hardware.edit',
    'uses'=> 'ProjectController@hardware_edit',
]);

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

Route::post('/modules/edit/', [
    'as'=> 'module.edit',
    'uses'=> 'ModuleController@edit',
]);
# modules end


#params start
Route::post('/params/add', [
    'as'=> 'param.add',
    'uses'=> 'ParamsController@add',
]);

Route::get('/params/delete/{id}', [
    'as'=> 'param.delete',
    'uses'=> 'ParamsController@delete',
]);

Route::post('/params/edit', [
    'as'=> 'param.edit',
    'uses'=> 'ParamsController@edit',
]);
#params end


Route::post('/subproduct/add', [
    'as'=> 'subproduct.add',
    'uses'=> 'SubProductController@add',
]);

Route::get('/subproduct/delete/{id}', [
    'as'=> 'subproduct.delete',
    'uses'=> 'SubProductController@delete',
]);

Route::post('/subproduct/edit', [
    'as'=> 'subproduct.edit',
    'uses'=> 'SubProductController@edit',
]);

Route::get('/subproduct/profile/{id}', [
    'as'=> 'subproduct.profile',
    'uses'=> 'SubProductController@profile',
]);

Route::post('/subporduct/{id}/modules', [
    'as'=> 'subproduct.modules',
    'uses'=> 'SubProductController@modules'
]);

Route::post('/subproduct/{id}/params', [
    'as'=> 'subproduct.params',
    'uses'=> 'SubProductController@params',
]);

Route::post('/subproduct/{id}/hardwares', [
    'as'=> 'subproduct.hardwares',
    'uses'=> 'SubProductController@hardwares',
]);


Route::post('/subproduct/{id}/param', [
    'as'=> 'subproduct.param.edit',
    'uses'=>'SubProductController@param_edit',
]);


Route::post('/hardware/add', [
    'as'=> 'hardware.add',
    'uses'=> 'HardWareController@add',
]);

Route::get('/hardware/delete/{id}', [
    'as'=> 'hardware.delete',
    'uses'=> 'HardWareController@delete',
]);

Route::post('/hardware/edit', [
    'as'=> 'hardware.edit',
    'uses'=> 'HardWareController@edit',
]);