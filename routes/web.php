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

Route::get('/', 'ItemController@index')->name('index');

Route::get('/items/create', 'ItemController@create')->name('create');
Route::post('/items', 'ItemController@store')->name('store');
Route::get('/items/{id}', 'ItemController@show')->name('show')->where('id', '[0-9]+');
