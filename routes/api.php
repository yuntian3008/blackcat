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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::group([
		'prefix' => '/v1',
		'namespace' => 'Api\V1',
		'as' => 'api.',
	], function () {
		Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']])
			->middleware('permission:'.config('permission.api.CategoriesController'));
		Route::resource('users', 'UsersController', ['except' => ['create', 'edit']])
			->middleware('permission:'.config('permission.api.UsersController'));
		Route::resource('plants', 'PlantsController', ['except' => ['create', 'edit']])
			->middleware('permission:'.config('permission.api.PlantsController'));
		Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'edit']])
			->middleware('permission:'.config('permission.api.PermissionsController'));
	}
	);
});