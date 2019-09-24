<?php

Route::get('/','home\HomeController@index');

//商品详情
Route::get('/goodsdetail/{goods_id}','goods\GoodsController@detail');
//分类
Route::get('/brand/{brand_id?}','goods\GoodsController@brand');

//收藏
Route::get('/collect/add/{goods_id?}','collect\CollectController@add');//加入收藏
Route::get('/collect/wishlist','collect\CollectController@wishlist');//心愿列表
Route::get('/collect/del','collect\CollectController@del');//收藏删除
Route::get('/collect/iscollect','collect\CollectController@iscollect');//判断是否收藏

//用户
Route::get('/register','User\UserController@register');//注册
Route::post('/reg_do','User\UserController@reg_do');//注册执行
Route::get('/login','User\UserController@login');//登录
Route::post('/login_do','User\UserController@login_do');//登录执行
Route::get('/forget','User\UserController@forget');//忘记密码
Route::post('/forget_do','User\UserController@forget_do');//执行找回密码
Route::get('/new_password','User\UserController@new_password');//设置新密码视图
Route::post('/set_new_password','User\UserController@set_new_password');//执行设置新密码
Route::get('/logout','User\UserController@logout');//退出登录
Route::get('/about_us','User\UserController@about_us');//关于我们


//购物车列表
Route::get('/cart/list','cart\CartController@cart_list');
//删除购物车订单
Route::get('/cart/del','cart\CartController@cart_del');
//生成订单页面
Route::get('/order/create','order\OrderController@order_view');
//生成订单
Route::post('/order/checkout','order\OrderController@order');
//订单列表
Route::get('/order/order_list','order\OrderController@order_list');
//订单支付
Route::get('/pay/alipay','pay\PayController@pay');
//支付回调异步
Route::get('/notify_url','pay\PayController@notify');
//支付回调同步
Route::get('/return_url','pay\PayController@aliReturn');
//加入购物车
Route::get('/cart/add/{goods_id?}','cart\CartController@cart_add');
//微信支付异步回调
Route::post('/weixin/pay/notify','pay\PayController@notify_url');
//验证微信是否支付成功
Route::get('/weixin/paystatus','pay\PayController@paystatus');
//微信支付成功同步跳转
Route::get('/weixin/supay','pay\PayController@supay');

//微信授权
Route::get('/wx','wx\WxController@wx');
//使用微信登录
Route::post('/wxuser','wx\WxController@wxuser');
//绑定微信
Route::post('/wxadd','wx\WxController@wxadd');

