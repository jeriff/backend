<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => ['web','auth']], function() {
    Route::group(['prefix' => 'login'], function(){
        Route::post('in', 'Login@in');
        Route::get('out', 'Login@out');
        Route::get('test', 'Login@test');
    });

    Route::group(['prefix' => 'file'], function(){
        Route::post('upload', 'Files@multipleUploadFile');
    });

    Route::group(['prefix' => 'user'], function(){
        Route::post('edit', 'User@editUser');
        Route::get('list', 'User@getUserList');
        Route::get('detail', 'User@getUserDetail');
    });

    Route::group(['prefix' => 'pgc'], function(){
        Route::post('edit', 'Data@editPgc');
        Route::get('list', 'Data@getPgcList');
        Route::get('detail', 'Data@getDetail');
        Route::post('change_status', 'Data@changeStatus');
    });
});

