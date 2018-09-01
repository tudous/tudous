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

Auth::routes();

Route::get('/', 'TopicsController@index')->name('home');


Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

Route::resource('users', 'UsersController',['only'=>['show','edit','update']]);

// Route::get('/users/{user}', 'UsersController@show')->name('users.show');
// Route::get('/users/{user}/edit', 'UsersController@edit')->name('users.edit');
// Route::patch('/users/{user}', 'UsersController@update')->name('users.update');

Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');//变更show方法，slug

Route::resource('categories', 'CategoriesController', ['only' => ['show']]);

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');

Route::resource('replies', 'RepliesController', ['only' => [ 'store', 'destroy']]);


Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

Route::get('permission-denied', 'HomeController@permissionDenied')->name('permission-denied');

Route::get('search','HomeController@search')->name('search');