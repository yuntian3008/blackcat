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
			->middleware('api.role:productmanager');
		Route::resource('customers', 'CustomersController', ['except' => ['create', 'edit']])
			->middleware('api.role:admin');
		Route::resource('products', 'ProductsController', ['except' => ['create', 'edit']])
			->middleware('api.role:productmanager');
		Route::resource('permissions', 'PermissionsController', ['except' => ['create', 'edit']])
			->middleware('permission:'.config('permission.api.PermissionsController'));
	}
	);
});