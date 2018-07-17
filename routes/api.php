<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', 'Api\APIAuthController@login');
Route::post('register', 'Api\APIAuthController@register');
Route::group(['middleware' => 'auth:api'], function(){
	Route::get('details', 'Api\APIAuthController@details');
	Route::get('profile', 'Api\APIToDoController@profile');
	Route::post('change-password', 'Api\APIToDoController@changePassword');

	Route::get('task', 'Api\ApiTaskController@task');
	Route::get('task/group', 'Api\ApiTaskController@taskGroup');
	Route::post('task/create', 'Api\ApiTaskController@createTask');
	Route::get('task/{id}', 'Api\ApiTaskController@view')->where(['id' => '[0-9]+']);
	Route::post('task/{id}/update', 'Api\ApiTaskController@update')->where(['id' => '[0-9]+']);
	Route::post('task/{id}/assigned', 'Api\ApiTaskController@assigned')->where(['id' => '[0-9]+']);
	Route::post('task/group/store', 'Api\ApiTaskController@groupStore');
	Route::get('task/group/{id}', 'Api\ApiTaskController@viewGroup')->where(['id' => '[0-9]+']);


	Route::post('/task/{id}/cancel', 'Api\ApiTaskController@cancel')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/processing', 'Api\ApiTaskController@processing')->where(['id' => '[0-9]+']);
	Route::post('/task/{id}/complete', 'Api\ApiTaskController@complete')->where(['id' => '[0-9]+']);


	Route::get('task/my', 'Api\ApiTaskController@myTask');

	Route::get('users', 'Api\ApiTaskController@users');
});
