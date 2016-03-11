<?php


Route::get('/', [
    'as' => 'root',
    'uses' => 'DashboardController@index',
]);

# 返回 json 的基础服务
#json
Route::group(['prefix' => 'json'], function () {

    Route::get('/servers', [
        'as' => 'servers.json',
        'uses' => 'ServerController@servers_json',
    ]);

    Route::get('/hardwares', [
        'as' => 'hardwares.json',
        'uses' => 'HardwareController@hardwares_json',
    ]);

    Route::get('/users', [
        'as' => 'users.json',
        'uses' => 'UserController@users_json',
    ]);
});
#json end

#clients
Route::group(['prefix' => 'clients'], function () {

   Route::get('/', [
       'as' => 'clients',
       'uses' => 'ClientController@clients',
   ]);

    Route::get('/profile/{id}', [
        'as' => 'client.profile',
        'uses' => 'ClientController@profile',
    ]);

    Route::post('/add', [
        'as' => 'client.add',
        'uses' => 'ClientController@add',
    ]);

    Route::post('/edit', [
        'as' => 'client.edit',
        'uses' => 'ClientController@edit',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'client.delete',
        'uses' => 'ClientController@delete',
    ]);
});
#clients end

#products
Route::group(['prefix' => 'products'], function () {

    Route::get('/', [
        'as' => 'products',
        'uses' => 'ProductController@products',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'product.profile',
        'uses' => 'ProductController@profile',
    ]);

    Route::post('/add', [
        'as' => 'product.add',
        'uses' => 'ProductController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'product.delete',
        'uses' => 'ProductController@delete',
    ]);

    Route::post('/edit', [
        'as' => 'product.edit',
        'uses' => 'ProductController@edit',
    ]);

    Route::post('/{id}/modules', [
        'as' => 'product.module',
        'uses' => 'ProductController@modules',
    ]);
});
#products end

#subproduct
Route::group(['prefix' => 'subproduct'], function () {

    Route::post('/add', [
        'as' => 'subproduct.add',
        'uses' => 'SubProductController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'subproduct.delete',
        'uses' => 'SubProductController@delete',
    ]);

    Route::post('/edit', [
        'as' => 'subproduct.edit',
        'uses' => 'SubProductController@edit',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'subproduct.profile',
        'uses' => 'SubProductController@profile',
    ]);

    Route::post('/{id}/modules', [
        'as' => 'subproduct.modules',
        'uses' => 'SubProductController@modules',
    ]);

    Route::post('/{id}/param', [
        'as' => 'subproduct.param.edit',
        'uses' => 'SubProductController@param_edit',
    ]);
});
#subproduct end

#servers
Route::group(['prefix' => 'servers'], function () {

    Route::get('/', [
        'as' => 'servers',
        'uses' => 'ServerController@servers',
    ]);

    Route::post('/add', [
        'as' => 'server.add',
        'uses' => 'ServerController@add',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'server.profile',
        'uses' => 'ServerController@profile',
    ]);

    Route::post('/edit', [
        'as' => 'server.edit',
        'uses' => 'ServerController@edit',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'server.delete',
        'uses' => 'ServerController@delete',
    ]);
});
#servers end

#comments
Route::group(['prefix' => 'comments'], function () {

    Route::post('/add', [
        'as' => 'comment.add',
        'uses' => 'CommentController@add',
    ]);
});
#comments end

#projects
Route::group(['prefix' => 'projects'], function () {

    Route::get('/', [
        'as' => 'projects',
        'uses' => 'ProjectController@index',
    ]);

    Route::post('/add', [
        'as' => 'project.add',
        'uses' => 'ProjectController@add',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'project.profile',
        'uses' => 'ProjectController@profile',
    ]);

    Route::post('/{id}/servers', [
        'as' => 'project.servers',
        'uses' => 'ProjectController@servers',
    ]);
    Route::get('/{id}/server/{server_id}', [
        'as' => 'project.server.disconnect',
        'uses' => 'ProjectController@server_disconnect',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'project.delete',
        'uses' => 'ProjectController@delete',
    ]);

    Route::post('/edit', [
        'as' => 'project.edit',
        'uses' => 'ProjectController@edit',
    ]);

    Route::post('/{id}/modules', [
        'as' => 'project.modules',
        'uses' => 'ProjectController@modules',
    ]);

    Route::post('/{id}/hardwares', [
        'as' => 'project.hardwares',
        'uses' => 'ProjectController@hardwares',
    ]);

    Route::post('/{id}/param', [
        'as' => 'project.param.edit',
        'uses' => 'ProjectController@param_edit',
    ]);

    Route::post('/{id}/hardware', [
        'as' => 'project.hardware.edit',
        'uses' => 'ProjectController@hardware_edit',
    ]);

    Route::post('/{id}/server', [
        'as' => 'project.server.edit',
        'uses' => 'ProjectController@server_edit',
    ]);

    Route::post('/{id}/profile_item', [
        'as' => 'project.profile.item',
        'uses' => 'ProjectController@profile_item',
    ]);
});
#projects end

# items start
Route::group(['prefix' => 'items'], function () {

    Route::post('/add', [
        'as' => 'item.add',
        'uses' => 'ItemController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'item.delete',
        'uses' => 'ItemController@delete',
    ]);
});
# items end

# modules start
Route::group(['prefix' => 'modules'], function () {

    Route::post('/add', [
        'as' => 'module.add',
        'uses' => 'ModuleController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'module.delete',
        'uses' => 'ModuleController@delete',
    ]);

    Route::post('/edit/', [
        'as' => 'module.edit',
        'uses' => 'ModuleController@edit',
    ]);
});
# modules end

#params start
Route::group(['prefix' => 'params'], function () {

    Route::post('/add', [
        'as' => 'param.add',
        'uses' => 'ParamController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'param.delete',
        'uses' => 'ParamController@delete',
    ]);

    Route::post('/edit', [
        'as' => 'param.edit',
        'uses' => 'ParamController@edit',
    ]);
});
#params end

#hardwares
Route::group(['prefix' => 'hardwares'], function () {

    Route::get('/', [
        'as' => 'hardwares',
        'uses' => 'HardwareController@index',
    ]);

    Route::post('/add', [
        'as' => 'hardware.add',
        'uses' => 'HardwareController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'hardware.delete',
        'uses' => 'HardwareController@delete',
    ]);

    Route::post('/edit', [
        'as' => 'hardware.edit',
        'uses' => 'HardwareController@edit',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'hardware.profile',
        'uses' => 'HardwareController@profile',
    ]);
});

#users
Route::group(['prefix' => 'users'], function () {

    Route::get('/', [
        'as' => 'users',
        'uses' => 'UserController@users',
    ]);

    Route::get('/refresh', [
        'as' => 'user.refresh',
        'uses' => 'UserController@refresh',
    ]);

    Route::get('/view', [
        'as' => 'user.view',
        'uses' => 'UserController@view',
    ]);

});
#users end

#roles
Route::group(['prefix' => 'roles'], function () {

    Route::get('/', [
        'as' => 'roles',
        'uses' => 'RoleController@roles',
    ]);

    Route::post('/{role_id}/user/{user_id}', [
        'as' => 'role.user.connect',
        'uses' => 'RoleController@user_connect',
    ]);

    Route::delete('/{role_id}/user/{user_id}/delete', [
        'as' => 'role.user.disconnect',
        'uses' => 'RoleController@user_disconnect',
    ]);

    Route::post('/users', [
        'as' => 'role.user.connect_many',
        'uses' => 'RoleController@user_connect_many',
    ]);
});
#roles end

#gapper
Route::group(['prefix' => 'gapper'], function () {

    Route::post('/login', [
        'as' => 'login',
        'uses' => 'GapperController@login',
    ]);

    Route::get('/logout', [
        'as' => 'logout',
        'uses' => 'GapperController@logout',
    ]);
});
#gapper end

#nfs
Route::group(['prefix' => 'nfs'], function () {

    # 进行路径匹配
    Route::get('/list/{project_id}/{path}', [
        'as' => 'nfs.path',
        'uses' => 'NFSController@path',
    ])->where(['path' => '[\w\W]*']);

    # 下载
    Route::get('/download/{project_id}/{file}/download', [
        'as' => 'nfs.download',
        'uses' => 'NFSController@download',
    ])->where(['file' => '.*']);

    # 删除
    # 增加 delete 是为了让 nginx 正常解析
    Route::post('/delete/{project_id}/{file}/delete', [
        'as' => 'nfs.delete',
        'uses' => 'NFSController@delete',
    ])->where(['file' => '.*']);

    # 重命名
    Route::post('/edit', [
        'as' => 'nfs.edit',
        'uses' => 'NFSController@edit',
    ]);

    Route::post('/upload/{project_id}', [
        'as' => 'nfs.upload',
        'uses' => 'NFSController@upload',
    ]);
});
#nfs end

#records
Route::group(['prefix' => 'records'], function () {

    Route::post('/add', [
        'as' => 'record.add',
        'uses' => 'RecordController@add',
    ]);

    Route::delete('/delete/{id}', [
        'as' => 'record.delete',
        'uses' => 'RecordController@delete',
    ]);

    Route::post('/edit', [
        'as'=> 'record.edit',
        'uses'=> 'RecordController@edit',
    ]);
});
#records end

#hardware_field
Route::group(['prefix' => 'hardware_field'], function () {

    Route::post('/add', [
        'as' => 'hardware_field.add',
        'uses' => 'HardwareFieldController@add',
    ]);

    Route::post('/edit', [
        'as' => 'hardware_field.edit',
        'uses' => 'HardwareFieldController@edit',
    ]);

    Route::get('/delete/{id}', [
        'as' => 'hardware_field.delete',
        'uses' => 'HardwareFieldController@delete',
    ]);
});
#hardware_field end

#hardware_item
Route::group(['prefix' => 'hardware_item'], function () {

    Route::post('/add', [
        'as' => 'hardware_item.add',
        'uses' => 'HardwareItemController@add',
    ]);

    Route::post('/form', [
        'as' => 'hardware_item.form',
        'uses' => 'HardwareItemController@form',
    ]);

    Route::post('/edit', [
        'as' => 'hardware_item.edit',
        'uses' => 'HardwareItemController@edit',
    ]);

    Route::get('/profile/{id}', [
        'as' => 'hardware_item.profile',
        'uses' => 'HardwareItemController@profile',
    ]);
});
#hardware_item end