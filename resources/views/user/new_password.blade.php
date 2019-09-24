@extends('layouts.app')

@section('title', '设置新密码')

@section('content')
	<!-- login -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>设置新密码</h3>
			</div>
			<div class="login">
				<div class="row">
					<form class="col s12">
						<div class="input-field">
							<input type="text" class="validate user_name" placeholder="请输入您的用户名" required>
						</div>
						<div class="input-field">
							<input type="text" class="validate password" placeholder="请输入新密码" required>
						</div>
						<a href="/forget"><h6>返回上一页面</h6></a>
						<a class="btn button-default">设置</a>
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
			$(".btn").click(function () {
                var user_name = $(".user_name").val();
                var password = $(".password").val();
                $.ajax({
                    url:"/set_new_password",
                    data:{user_name:user_name,password:password},
                    type:'post',
                    async:false,
                    dataType:'json',
                    success:function(res){
                        if(res.errno==1){
                            alert('res.msg');
                            location.href='/login';
                        }
                    }
                })
            })
        })
	</script>


@endsection