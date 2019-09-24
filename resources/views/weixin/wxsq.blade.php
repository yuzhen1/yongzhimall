<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <script src="/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <input type="hidden" id="openid" value="{{$user_info['openid']}}">
    <input type="hidden" id="nickname" value="{{$user_info['nickname']}}">
</body>
</html>
<script>
    $(function(){
        var openid=$("#openid").val();
        var nickname=$("#nickname").val();
            if(confirm("是否使用当前微信用户登录此网站?")){
                $.post(
                        '/wxuser',
                        {openid:openid,nickname:nickname},
                        function(res){
                            if(res==1){
                                if(confirm("检测到你已登录此网站，是否绑定此微信用户")){
                                    $.post(
                                            '/wxadd',
                                            {openid:openid},
                                            function(res){
                                                if(res=="绑定成功"){
                                                    alert('绑定成功');
                                                    location.href="/";
                                                }
                                            }
                                    )
                                }
                            }else if(res==2){
                                if(confirm('使用微信登录成功，微信登录属于游客登录，是否注册当前网站用户')){
                                    location.href="/register";
                                }
                            }else if(res==3){
                                alert('微信登录成功');
                                location.href="/";
                            }
                        }
                )
            }else{
                location.href="/";
            }
    })
</script>