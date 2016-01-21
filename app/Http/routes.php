<?php


Route::get('/', [
    'as'=> 'root',
    'uses'=> 'DashboardController@index'
]);

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

Route::post('/servers/add', [
    'as'=> 'server.add',
    'uses'=> 'ServerController@add',
]);

Route::get('/servers/profile/{id}', [
    'as'=> 'server.profile',
    'uses'=> 'ServerController@profile',
]);


Route::post('/servers/edit', [
    'as'=> 'server.edit',
    'uses'=> 'ServerController@edit',
]);

Route::get('/servers/delete/{id}', [
    'as'=> 'server.delete',
    'uses'=> 'ServerController@delete',
]);


#comments
Route::post('/comments/add', [
    'as'=> 'comment.add',
    'uses'=>'CommentController@add'
]);

Route::get('/comments/delete/{id}', [
    'as'=> 'comment.delete',
    'uses'=> 'CommentController@delete'
]);

#projects
Route::get('/projects', [
    'as' => 'projects',
    'uses'=> 'ProjectController@index',
]);

Route::post('/projects/add', [
    'as'=> 'project.add',
    'uses'=> 'ProjectController@add',
]);

Route::get('/projects/profile/{id}', [
    'as'=> 'project.profile',
    'uses'=> 'ProjectController@profile',
]);

Route::post('/projects/{id}/servers', [
    'as'=> 'project.servers',
    'uses'=> 'ProjectController@servers',
]);
Route::get('/projects/{id}/server/{server_id}', [
    'as'=> 'project.server.disconnect',
    'uses'=> 'ProjectController@server_disconnect'
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

Route::post('/projects/{id}/server', [
    'as'=> 'project.server.edit',
    'uses'=> 'ProjectController@server_edit',
]);

Route::post('/projects/{id}/profile_item', [
    'as'=> 'project.profile.item',
    'uses'=> 'ProjectController@profile_item',
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
    'uses'=> 'ParamController@add',
]);

Route::get('/params/delete/{id}', [
    'as'=> 'param.delete',
    'uses'=> 'ParamController@delete',
]);

Route::post('/params/edit', [
    'as'=> 'param.edit',
    'uses'=> 'ParamController@edit',
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

Route::post('/subproduct/{id}/param', [
    'as'=> 'subproduct.param.edit',
    'uses'=>'SubProductController@param_edit',
]);

Route::get('/hardwares', [
    'as'=> 'hardwares',
    'uses'=> 'HardWareController@index',
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


Route::get('/users', [
    'as'=> 'users',
    'uses'=> 'UserController@users',
]);

Route::get('/users/refresh', [
    'as'=> 'user.refresh',
    'uses'=> 'UserController@refresh',
]);

Route::get('/users.json', [
    'as'=> 'users.json',
    'uses'=> 'UserController@users_json',
]);

Route::get('/users/view', [
    'as'=> 'user.view',
    'uses'=> 'UserController@view',
]);

Route::get('/roles', [
    'as'=> 'roles',
    'uses'=> 'RoleController@roles',
]);

Route::post('/roles/{role_id}/user/{user_id}', [
    'as'=> 'role.user.connect',
    'uses'=> 'RoleController@user_connect',
]);

Route::post('/roles/{role_id}/user/{user_id}/delete', [
    'as'=> 'role.user.disconnect',
    'uses'=> 'RoleController@user_disconnect',
]);

Route::post('/roles/users', [
    'as'=> 'role.user.connect_many',
    'uses'=> 'RoleController@user_connect_many',
]);


Route::get('/gapper/go/{type}', [
    'as'=> 'gapper.go',
    'uses'=> 'GapperController@go',
]);

Route::post('/gapper/login', [
    'as'=> 'login',
    'uses'=> 'GapperController@login',
]);

Route::get('/gapper/logout', [
    'as'=> 'logout',
    'uses'=> 'GapperController@logout',
]);