<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->resource('user', UserController::class);
    $router->resource('brand', BrandController::class);
    $router->resource('goods', GoodsController::class);
    $router->resource('collect', CollectController::class);
    $router->resource('user', UserController::class);
    $router->resource('order', OrderController::class);
    $router->resource('cart', CartController::class);
    $router->resource('address', AddressController::class);
});


