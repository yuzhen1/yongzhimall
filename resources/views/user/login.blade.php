@extends('layouts.app')

@section('title', '登录')

@section('content')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>LOGIN</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate user_name" placeholder="请输入用户名" required>
						</div>
						<div class="input-field">
							<input type="password" class="validate password" placeholder="请输入密码" required>
						</div>
						<a href="/forget" class="forget"><h6>忘记密码?</h6></a>
						<a class="btn button-default">点击登录</a>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end login -->

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->

	<!-- scripts -->
	<script src="js/jquery.min.js"></script>

	<script>
		$(function(){
		    //点击登录
		    $(document).on('click',".btn",function () {
				var user_name = $(".user_name").val();
				var password = $(".password").val();
				$.ajax({
					url:"/login_do",
					data:{user_name:user_name,password:password},
                    type:'post',
                    async:false,
                    dataType:'json',
					success:function (res) {
						if(res.errno==1){
						    alert(res.msg);
						    location.href="/"
						}
						if(res.errno==2){
                            alert(res.msg);
                            location.href="/login"
						}
						if(res.errno==3){
                            alert(res.msg);
                            location.href="/register"
						}
                    }
				})
            });
		})
	</script>
@endsection