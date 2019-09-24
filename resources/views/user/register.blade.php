@extends('layouts.app')
@section('title', '注册')
@section('content')

<!-- register -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>注册</h3>
        </div>
        <div class="register">
            <div class="row">
                <form class="col s12">
                    <div class="input-field">
                        <input type="text" class="validate user_name" placeholder="请输入用户名" required>
                    </div>
                    <div class="input-field">
                        <input type="email" placeholder="请输入邮箱" class="validate email" required>
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="请输入密码" class="validate password" required>
                    </div>
                    <div class="btn button-default" id="btn">点击注册</div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end register -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->

<!-- scripts -->
<script src="js/jquery.min.js"></script>

<script>
    $(function(){
        $(document).on('click',"#btn",function () {
            var user_name = $('.user_name').val();
            var email = $('.email').val();
            var password = $('.password').val();
            $.ajax({
                url:"/reg_do",
                data:{user_name:user_name,email:email,password:password},
                type:'post',
                async:false,
                dataType:'json',
                success:function(res){
                    if(res.errno==1){
                        var choose = confirm("注册成功,去登陆？");
                        if(choose==true) { //点击是 跳转到登录页面
                            location.href = "/login";
                        }else{              //点击取消 跳转到首页
                            location.href = "/";
                        }
                    }else{
                        alert(res.msg);
                    }
                }
            })
        })
    })
</script>

@endsection