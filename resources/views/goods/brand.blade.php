@extends('layouts.app')

@section('title', '品牌分类')



@section('content')
        <!-- product -->
<div class="section product product-list">
    <div class="container">
        <div class="pages-head">
            <h3>品牌分类</h3>
        </div>
        <div class="input-field">
            @foreach($brandInfo as $k=>$v)
                <a href="/brand/{{$v['brand_id']}}" >{{$v['brand_name']}}&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</a>
            @endforeach
            <br><br>
        </div>
        <div class="row">
            @foreach($goods_info as $k=>$v)
            <div class="col s6">
                <div class="content">
                    <img src="/img/{{$v['goods_img']}}" alt="">
                    <h6><a href="/goodsdetail/{{$v['goods_id']}}">{{$v['goods_name']}}</a></h6>
                    <div class="price">
                        ${{$v['goods_price']}}<span>${{$v['goods_bzprice']}}</span>
                    </div>
                    <button class="btn button-default">加入购物车</button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="pagination-product">
            <ul>
                <li class="active">1</li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">4</a></li>
                <li><a href="">5</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- end product -->


<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
@endsection