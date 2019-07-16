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
    });
});

