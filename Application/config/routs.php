<?php

$route->GET('product/find',               'ShopController@find');
$route->GET('product/search',             'ShopController@search');
$route->GET('product/getByManufacturers', 'ShopController@getByManufacturers');
$route->GET('product/getBySection',       'ShopController@getBySection');
$route->GET('product/getBySections',      'ShopController@getBySections');