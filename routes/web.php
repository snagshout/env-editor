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


Route::get('/', 'IndexController@index')->name('list_env_files');
Route::post('/', 'IndexController@index')->name('set_env_file_root_path');
Route::get('/create', 'IndexController@create')->name('add_env_file');
Route::post('/store', 'IndexController@store')->name('store_env_file')->middleware(['env.normalize']);
Route::get('/edit', 'IndexController@edit')->name('edit_env_file')->middleware(['env.exists']);
Route::post('/update', 'IndexController@update')->name('update_env_file')->middleware(['env.normalize']);
Route::get('/delete', 'IndexController@destroy')->name('delete_env_file')->middleware(['env.exists']);
