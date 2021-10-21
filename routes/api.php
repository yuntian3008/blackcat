<?php

use App\Role;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:api'], function() {
    Route::group([
		'prefix' => '/v1',
		'namespace' => 'Api\V1',
		'as' => 'api.',
	], function () {
		Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']])
			->middleware('api.role:productmanager');
		Route::resource('categories-trash', 'CategoriesTrashController', ['expect' => ['create','edit']])
			->middleware('api.role:productmanager');
		Route::resource('customers', 'CustomersController', ['except' => ['create', 'edit']])
			->middleware('api.role:admin');
		Route::resource('staff', 'StaffController', ['except' => ['create', 'edit']])
			->middleware('api.role:admin');
		Route::resource('products', 'ProductsController', ['except' => ['create', 'edit']])
			->middleware('api.role:productmanager');
		Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']])
			->middleware('api.role:ordermanager,api.role:shipper');
		Route::resource('roles', 'RolesController', ['except' => ['create', 'edit']])
			->middleware('api.role:superadmin');
	}
	);
});