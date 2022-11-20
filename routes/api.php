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
			->middleware('api.role:ordermanager');
		Route::resource('shipping', 'ShippingController', ['except' => ['create', 'edit']])
			->middleware('api.role:shipper,ordermanager');
		Route::resource('roles', 'RolesController', ['except' => ['create', 'edit']])
			->middleware('api.role:superadmin');
		Route::resource('settings', 'SettingsController', ['except' => ['create', 'edit']])
			->middleware('api.role:admin');
		Route::resource('suppliers', 'SuppliersController', ['except' => ['create', 'edit']])
			->middleware('api.role:productmanager');
		Route::resource('goods-receipts', 'GoodsReceiptsController', ['except' => ['create', 'edit']])
			->middleware('api.role:productmanager');
		Route::group([
			'middleware' => 'api.role:productmanager',
			'prefix' => 'product',
			'as' => 'product.',
		], function () {
			Route::post('image','ProductsController@storeImage');
			Route::delete('image/{dir}/{image}','ProductsController@destroyImage');
		});
        Route::group([
			'middleware' => 'api.role:productmanager',
			'prefix' => 'statistics',
			'as' => 'statistics.',
		], function () {
			Route::get('sales','StatisticsController@sales');
			Route::get('customers','StatisticsController@customer');
		});
		// Route::group([
		// 	'prefix' => 'inventory',
		// 	'middleware' => 'api.role:productmanager',
		// ], function () {
		// 	Route::post('request','InventoryController@goodsReceiptsRequest');
		// 	Route::post('goods-receipt','InventoryController@goodsReceipts');
		// });
	});
});

Route::group(['middleware' => 'auth:web_api'], function() {
    Route::group([
		'prefix' => '/customer',
		'namespace' => 'Api\Customer',
		'as' => 'web_api.',
	], function () {
		Route::get('test','TestController@test');
		Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']]);
		// Route::resource('carts', 'CartsController', ['except' => ['create', 'edit']]);
		Route::resource('reviews', 'ReviewsController', ['except' => ['create', 'edit']]);
	}
	);
});
Route::get('customer/carts','Api\Customer\CartsController@index');

Route::group(['middleware' => 'auth:app_api'], function() {
    Route::group([
		'prefix' => '/app/customer',
		'namespace' => 'Api\Customer',
		'as' => 'app_api.',
	], function () {
		Route::get('test','TestController@test');
		Route::resource('orders', 'OrdersController', ['except' => ['create', 'edit']]);
		Route::resource('carts', 'CartsController', ['except' => ['create', 'edit']]);
		Route::resource('reviews', 'ReviewsController', ['except' => ['create', 'edit']]);
	}
	);
});

Route::group([
		'prefix' => '/public',
		'namespace' => 'Api',
		'as' => 'public.',
	], function () {
		Route::get('product','ProductController@index');
	}
);
