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


Route::group(['middleware' => 'api-guest'], function () {
	Route::view('/login', 'authentication.login')->name('login');
	Route::view('/register', 'authentication.register')->name('register');
});

Route::post('/login', 'AuthController@login');
Route::post('/register', 'AuthController@register');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'api-auth'], function () {
	Route::get('/', 'ToDoController@index');
	Route::get('/task', 'ToDoController@index');
	Route::get('/profile', 'ToDoController@profile');
	Route::view('/profile/change-password', 'change-password');
	Route::post('/profile/change-password', 'ToDoController@changePassword');

	Route::view('/task/create', 'task.create');
	Route::post('/task/create', 'TaskController@create');
	Route::get('/task/{id}', 'TaskController@view')->where(['id' => '[0-9]+']);
	Route::get('/task/{id}/edit', 'TaskController@edit')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/edit', 'TaskController@update')->where(['id' => '[0-9]+']);
	Route::get('/task/{id}/assign', 'TaskController@assign')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/assigned', 'TaskController@assigned')->where(['id' => '[0-9]+']);
	Route::get('/task/group/create', 'TaskController@createGroup');
	Route::post('/task/group', 'TaskController@storeGroup')->where(['id' => '[0-9]+']);
	Route::get('/task/group/{id}', 'TaskController@viewGroup')->where(['id' => '[0-9]+']);

	Route::post('/task/{id}/cancel', 'TaskController@cancel')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/processing', 'TaskController@processing')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/complete', 'TaskController@complete')->where(['id' => '[0-9]+']);

});


Route::group(['prefix' => 'ajax', 'middleware' => 'ajax'], function () {
});
