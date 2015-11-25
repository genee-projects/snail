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

Route::get('/', 'ClientController@clients');
Route::get('/clients', 'ClientController@clients');
Route::get('/clients/add', 'ClientController@add');
Route::get('/clients/profile', 'ClientController@profile');

Route::group(['prefix'=> 'api/v1'], function ($app) {
    $app->get('client', 'ClientAPIController@index');
    $app->get('client/refreshLatestBackupTime', 'ClientAPIController@refreshLatestBackupTime');
});