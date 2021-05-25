<?php


Route::group(['as' => 'admin.'], function() {  //route name = admin.*


	// AUTH
	Route::get('login', 'Staff\Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Staff\Auth\LoginController@login');
	Route::post('logout', 'Staff\Auth\LoginController@logout')->name('logout');


	// VIEW MANAGER
	Route::group(['middleware' => 'auth:admin', 'as' => 'manager.'], function () {

		Route::get('/', 'ManagerController@dashboard')->name('dashboard');
			

	    Route::get('/dashboard', 'ManagerController@dashboard')->name('dashboard');
	    	

		Route::get('/categories', 'ManagerController@category')->name('category')
			->middleware('role:productmanager');

		Route::get('/products', 'ManagerController@product')->name('product')
			->middleware('role:productmanager');

		Route::get('/customers', 'ManagerController@customer')->name('customer')
			->middleware('role:admin');

		Route::get('/staff', 'ManagerController@staff')->name('staff')
			->middleware('role:admin');

		Route::get('/get-orders', 'ManagerController@getOrders')->name('get-orders')
			->middleware('role:ordermanager');

		Route::get('/ship-orders', 'ManagerController@shipOrders')->name('ship-orders')
			->middleware('role:ordermanager');

		Route::get('/complete-orders', 'ManagerController@completeOrders')->name('complete-orders')
			->middleware('role:shipper');

	    Route::get('/permissions', 'ManagerController@role')->name('role')
	    	->middleware('role:admin');
	    
	});
});
