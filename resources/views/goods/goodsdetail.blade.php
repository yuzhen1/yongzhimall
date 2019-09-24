@extends('layouts.app')

@section('title', '商品详情')

@section('content')

<!-- shop single -->
<div class="pages section">
    <div class="container">
        <div class="shop-single" goods_id="{{$goods_info['goods_id']}}">
            <img src="/img/{{$goods_info['goods_img']}}" alt="">
            <h5>{{$goods_info['goods_name']}}</h5>
            <div class="price">${{$goods_info['goods_price']}}<span>${{$goods_info['goods_bzprice']}}</span></div>
            <p>{{$goods_info['goods_desc']}}</p>
            <button type="button" class="btn button-default" id="addcat" goods_id="{{$goods_info['goods_id']}}">加入购物车</button>
            <button type="button" class="btn button-default"><i class="fa fa-heart" id="iscollect">收藏</i></button>
        </div>
        <div class="review">
            <h5>1 reviews</h5>
            <div class="review-details">
                <div class="row">
                    <div class="col s3">
                        <img src="img/user-comment.jpg" alt="" class="responsive-img">
                    </div>
                    <div class="col s9">
                        <div class="review-title">
                            <span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-form">
            <div class="review-head">
                <h5>Post Review in Below</h5>
                <p>Lorem ipsum dolor sit amet consectetur*</p>
            </div>
            <div class="row">
                <form class="col s12 form-details">
                    <div class="input-field">
                        <input type="text" required class="validate" placeholder="NAME">
                    </div>
                    <div class="input-field">
                        <input type="email" class="validate" placeholder="EMAIL" required>
                    </div>
                    <div class="input-field">
                        <input type="text" class="validate" placeholder="SUBJECT" required>
                    </div>
                    <div class="input-field">
                        <textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
                    </div>
                    <div class="form-button">
                        <div class="btn button-default">POST REVIEW</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end shop single -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
@endsection
<script src="/js/jquery.min.js"></script>
<script>
    $(function(){
        $("#addcat").click(function(){
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

        //判断是否收藏
        var goods_id=$("#addcat").attr('goods_id');
        $.get(
            '/collect/iscollect?goods_id='+goods_id,
            function(res){
                if(res=="收藏"){
                    $("#iscollect").css({color:"gray"})
                    $("#iscollect").text('收藏');
                }else{
                    $("#iscollect").css({color:"red"})
                    $("#iscollect").text('已收藏');
                }
            }
        )
        //点击收藏
        $('.fa').click(function () {
            var goods_id=$(this).parents('div').attr('goods_id');
            var _this=$(this);
            $.ajax({
                url:'/collect/add/'+goods_id,
                dataType:'json',
                success:function (res) {
                    if(res.errno==0){
                        alert('收藏成功');
                        $("#iscollect").css({color:"red"}).text('已收藏');
                    }else if (res.errno==1){
                        alert('收藏失败');
                    }else if(res.errno==2){
                        alert('取消收藏成功');
                        $("#iscollect").css({color:"gray"}).text('收藏');
                    }else{
                        alert('请登录');
                        location.href='/login';
                    }
                }
            })
        })
    })
</script>



