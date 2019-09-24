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
			<li><a href="about-us.html"><i class="fa fa-user"></i>About Us</a></li>
			<li><a href="contact.html"><i class="fa fa-envelope-o"></i>Contact Us</a></li>
			<li><a href="login.html"><i class="fa fa-sign-in"></i>Login</a></li>
			<li><a href="register.html"><i class="fa fa-user-plus"></i>Register</a></li>
		</ul>
	</div>
	<!-- end side nav right-->




	<!-- cart -->
	<div class="cart section">

		<div class="container">
			<div class="pages-head">
				<h3>CART</h3>
			</div>
			<div class="content">
				@foreach($cart_info as $k=>$v)

					@if($k>0)
						<div class="divider"></div>
					@endif
				<div class="cart-1" c_id="{{$v->id}}">
					<div class="row">
						<div class="col s5">
							<h5>图片</h5>
						</div>
						<div class="col s7">
							<img src="/img/{{$v->goods_img}}" alt="">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>商品名称</h5>
						</div>
						<div class="col s7">
							<h5><a href=""></a></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>购买数量</h5>
						</div>
						<div class="col s7">
							<input value="{{$v->buy_num}}" type="text">
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>单价</h5>
						</div>
						<div class="col s7">
							<h5>${{$v->goods_price}}</h5>
						</div>
					</div>
					<div class="row one">
						<div class="col s5">
							<h5>总价格</h5>
						</div>
						<div class="col s7">
							<h5 class="h11">$<span class="goods_price">{{$v->buy_num*$v->goods_price}}</span></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>操作</h5>
						</div>
						<div class="col s7">
							<h5><i class="fa fa-trash"></i></h5>
						</div>
					</div>
					<div class="row">
						<div class="col s5">
							<h5>是否参与结算</h5>
						</div>
						<div class="col s7">
							<input type="hidden" value="0" class="bp">
							<button class="but">点击参与结算</button>
						</div>
					</div>
				</div>
				{{--横线--}}

				@endforeach
			</div>

			<div class="total">
				@foreach($cart_info as $k=>$v)
				<div class="row">
					<div class="col s7">
						<h5>{{$v->goods_name}}</h5>
					</div>
					<div class="col s5">
						<h5>${{$v->goods_price}}</h5>
					</div>
				</div>
				@endforeach
				<div class="row">
					<div class="col s7">
						<h6>总价格</h6>
					</div>
					<div class="col s5">
						<h6>$ <span id="total">0</span></h6>
					</div>
				</div>
			</div>
			<button class="btn button-default" id="check">前去结算</button>
		</div>
	</div>
	<!-- end cart -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->

	<!-- scripts -->
	<script src="/js/jquery-3.2.1.min.js"></script>
	<script>
		// var goods_price=$('.goods_price');




		$('.but').click(function(){
			var text=$(this).text();
			if(text=='点击参与结算'){
				$(this).text('点击取消结算');
				$(this).prev('input').val('1');

				var price=$('.bp');
				var total=count(price);
				$('#total').text(total)
			}else if(text=='点击取消结算'){
				$(this).text('点击参与结算');
				$(this).prev().val('0');
				var price=$('.bp');
				var total=count(price);
				$('#total').text(total)
			}else{
				$(this).text('点击参与结算');
				$(this).prev().val('0');
				var price=$('.bp');
				var total=count(price);
				$('#total').text(total)
			}
		})
		//求总价格
		function count(price){
			var total=0;
			price.each(function(index){
				if($(this).val()==1){
					total += parseInt($(this).parents("div[class='row']").siblings('div[class="row one"]').find("span[class='goods_price']").text());
				}
			})
			return total;

		}
		//生成订单  点击结算
		$('#check').click(function(){
			var bp=$('.bp');
			var c_id='';
			bp.each(function(index){
				if($(this).val()==1){
					c_id += $(this).parents("div[class='cart-1']").attr('c_id')+',';
				}
			})
			c_id=c_id.substr(0,c_id.length-1);
			if(c_id==''){
				alert('请选择订单进行结算');
				return false;
			}
			location.href="/order/create?c_id="+c_id;
		})
		//点击删除
		$("i[class='fa fa-trash']").click(function(){
			var c_id=$(this).parents('div[class="cart-1"]').attr('c_id');
			$.ajax({
				url:"/cart/del?c_id="+c_id,
				dataType:'json',
				success:function(res) {
					if (res.errno == 0) {
						alert('删除成功');
						location.reload();
					} else {
						alert('删除失败');
					}
				}

			})
		})

	</script>
@endsection
