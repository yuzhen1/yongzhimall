
@extends('layouts.app')

@section('title', '商店首页')


@section('content')

<!-- side nav right-->
<div class="side-nav-panel-right">
	<ul id="slide-out-right" class="side-nav side-nav-panel collapsible">
		<li class="profil">
			<img src="img/profile.jpg" alt="">
			<h2>John Doe</h2>
		</li>
		<li><a href="setting.html"><i class="fa fa-cog"></i>Settings</a></li>
		<li><a href="/about_us"><i class="fa fa-user"></i>About Us</a></li>
		<li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
		<li><a href="/login"><i class="fa fa-sign-in"></i>Login</a></li>
		<li><a href="/register"><i class="fa fa-user-plus"></i>Register</a></li>
	</ul>
</div>
<!-- end side nav right-->

<!-- end side nav right-->



<!-- slider -->
<div class="slider">

	<ul class="slides">
		<li>
			<img src="img/a1.jpg" alt="">
			<div class="caption slider-content  center-align">
				<h2 style="color:pink">⭐今日美食⭐</h2>
				<h4>中考八百米---木瓜炖雪梨---芝士玉米粒---鸡汁土豆泥</h4>
				<a href="" class="btn button-default">进入美味之旅</a>
			</div>
		</li>
		<li>
			<img src="img/adi.jpeg" alt="">
			<div class="caption slider-content center-align">
				<h2 style="color:pink">👗今日美衣</h2>
				<h4>礼服配球鞋？</h4>
				<a href="" class="btn button-default">进入我的衣橱</a>
			</div>
		</li>
		<li>
			<img src="img/a3.jpg" alt="">
			<div class="caption slider-content center-align">
				<h2 style="color:pink">☀小小祝福</h2>
				<h4>一些该拿起的要拿起，一些该舍弃的要舍弃。因为，只有让该结束的结束了，该开始的才会开始</h4>
				<a href="" class="btn button-default">Happy☺</a>
			</div>
		</li>
	</ul>

</div>
<!-- end slider -->

<!-- features -->
<div class="features section">
	<div class="container">
		<div class="row">
			<div class="col s6">
				<div class="content">
					<div class="icon">
						<i class="fa fa-car"></i>
					</div>
					<h6>免费送货</h6>
					<p>Lorem ipsum dolor sit amet consectetur</p>
				</div>
			</div>
			<div class="col s6">
				<div class="content">
					<div class="icon">
						<i class="fa fa-dollar"></i>
					</div>
					<h6>七天无理由退换</h6>
					<p>Lorem ipsum dolor sit amet consectetur</p>
				</div>
			</div>
		</div>
		<div class="row margin-bottom-0">
			<div class="col s6">
				<div class="content">
					<div class="icon">
						<i class="fa fa-lock"></i>
					</div>
					<h6>安全支付</h6>
					<p>Lorem ipsum dolor sit amet consectetur</p>
				</div>
			</div>
			<div class="col s6">
				<div class="content">
					<div class="icon">
						<i class="fa fa-support"></i>
					</div>
					<h6>24/7 Support</h6>
					<p>Lorem ipsum dolor sit amet consectetur</p>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end features -->

<!-- quote -->
<div class="section quote">
	<div class="container">
		<h4>FASHION UP TO 50% OFF</h4>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
	</div>
</div>
<!-- end quote -->

<!-- product -->
<div class="section product">
	<div class="container">
		<div class="section-head">
			<h4>最新商品</h4>
			<div class="divider-top"></div>
			<div class="divider-bottom"></div>
		</div>
		<div class="row">

			@foreach($goods_new_info as $k=>$v)
			<div class="col s6">
				<div class="content">
					<img src="\img\{{$v['goods_img']}}" style="width: 350px;height: 500px">
					<h6><a href="/goodsdetail/{{$v['goods_id']}}">{{$v['goods_name']}}</a></h6>
					<div class="price">
						${{$v['goods_price']}} <span>${{$v['goods_bzprice']}}</span>
					</div>
					<button class="btn button-default addcat" goods_id="{{$v['goods_id']}}">加入购物车</button>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
<!-- end product -->

<!-- promo -->
<div class="promo section">
	<div class="container">
		<div class="content">
			<h4>PRODUCT BUNDLE</h4>
			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
			<button class="btn button-default">SHOP NOW</button>
		</div>
	</div>
</div>
<!-- end promo -->

<!-- product -->
<div class="section product">
	<div class="container">
		<div class="section-head">
			<h4>精品商品</h4>
			<div class="divider-top"></div>
			<div class="divider-bottom"></div>
		</div>
		<div class="row">
			@foreach($goods_best_info as $k=>$v)
				<div class="col s6">
					<div class="content">
						<img src="\img\{{$v->goods_img}}">
						<h6><a href="/goodsdetail/{{$v->goods_id}}">{{$v->goods_name}}</a></h6>
						<div class="price">
							${{$v->goods_price}} <span>${{$v->goods_bzprice}}</span>
						</div>
						<button class="btn button-default">加入购物车</button>
					</div>
				</div>
			@endforeach
		</div>
		<div class="pagination-product">
			{{ $goods_best_info->links() }}
		</div>
	</div>
</div>
<!-- end product -->

<!-- loader -->
<div id="fakeLoader"></div>
<script>
	$(function(){
		$(".addcat").each(function(){
			$(this).click(function(){
				var goods_id=$(this).attr('goods_id');
				$.get(
					'/cart/add/'+goods_id,
					function(res){
						if(res.errno==0){
							alert(res.msg);
							location.href="/cart/list";
						}else{
							alert(res.msg);
						}
					},
					'json'
				)
			})
		})
	})
</script>
@endsection
