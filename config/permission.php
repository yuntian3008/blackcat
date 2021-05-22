<?php

return [
	'web' => [
		'AdminController@index' => 'admin',
		'AdminController@category' => 'contentmanagement',
		'AdminController@plant' => 'contentmanagement',
		'AdminController@user' => '*',
		'AdminController@permission' => '*',
	],

	'api' => [
		'Api\V1\CategoriesController' => 'contentmanagement',
		'Api\V1\ProductsController' => 'productmanager',
		'Api\V1\UsersController' => '*',
		'Api\V1\PermissionsController' => 'superadmin',
	],
];