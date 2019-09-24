@extends('layouts.app')

@section('title', '忘记密码')

@section('content')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>忘记密码</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate user_name" placeholder="请输入用户名找回密码" required>
						</div>
						<a href="/login"><h6>返回登录页面</h6></a>
						<a class="btn button-default">点击找回</a>
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
		$(function () {
			$(document).on('click','.btn',function () {
				var user_name = $('.user_name').val();
                $.ajax({
                    url:"/forget_do",
                    data:{user_name:user_name},
                    type:'post',
                    async:false,
                    dataType:'json',
                    success:function(res){
                        if(res.errno==1){
                            alert(res.msg);
							location.href='/new_password';
                        }
                    }
                })
            })
        })
	</script>

@endsection