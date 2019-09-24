@extends('layouts.app')
@section('title', '生成订单')
@section('content')



<!-- checkout -->
<div class="checkout pages section">
    <div class="container">
        <div class="pages-head">
            <h3>结算</h3>
        </div>
        <div class="checkout-content">
            <div class="row">
                <div class="col s12">
                    <ul class="collapsible" data-collapsible="accordion">

                        <li>
                            <div class="collapsible-header"><h5>1 - 收货信息</h5></div>
                            <div class="collapsible-body">
                                <div class="billing-information">
                                    <form action="#">
                                        <div class="input-field">
                                            <h5>收货人姓名*</h5>
                                            <input type="text" id="address_name" class="validate" required>
                                        </div>
                                        <div class="input-field">
                                            <h5>邮箱*</h5>
                                            <input type="email" id="email" class="validate" required>
                                        </div>
                                        <div class="input-field">
                                            <h5>详细地址*</h5>
                                            <input type="text" id="address_detail" class="validate" required>
                                        </div>
                                        <div class="input-field">
                                            <h5>城市*</h5>
                                            <input type="text" id="city" class="validate" required>
                                        </div>
                                        <div class="input-field">
                                            <h5>手机号*</h5>
                                            <input type="number" id="tel" class="validate" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header"><h5>2 - 支付方式</h5></div>
                            <div class="collapsible-body">
                                <div class="payment-mode">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur provident repellat</p>
                                    <form action="#" class="checkout-radio">
                                        <div class="input-field">
                                            <input type="radio" class="with-gap" id="cash-on-delivery" name="group1">
                                            <label for="cash-on-delivery"><span>微信支付</span></label>
                                        </div>
                                        <div class="input-field">
                                            <input type="radio" class="with-gap" id="online-payments" name="group1">
                                            <label for="online-payments"><span>支付宝支付</span></label>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="collapsible-header"><h5>3 - 订单确认</h5></div>
                            <div class="collapsible-body">
                                @foreach($cart_info as $k=>$v)
                                <div class="order-review ll" cart_id="{{$v->id}}">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>商品图片</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <img src="/img/{{$v->goods_img}}" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>商品名称</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <a href="">{{$v->goods_name}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>购买数量</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <input type="text" value="{{$v->buy_num}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="divider"></div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>单价</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <span>${{$v->goods_price}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cart-details">
                                                <div class="col s5">
                                                    <div class="cart-product">
                                                        <h5>总价</h5>
                                                    </div>
                                                </div>
                                                <div class="col s7">
                                                    <div class="cart-product">
                                                        <span> $<span  class="tot">{{$v->goods_price*$v->buy_num}}</span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <div class="order-review final-price">
                                    <div class="row">
                                        <div class="col s12">
                                            <div class="cart-details">
                                                <div class="col s8">
                                                    <div class="cart-product">
                                                        <h5>总金额</h5>
                                                    </div>
                                                </div>
                                                <div class="col s4">
                                                    <div class="cart-product">
                                                        <span id="total">$31.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button id="check">去结算</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end checkout -->
<script src="/js/jquery-3.2.1.min.js"></script>
<script>
    //总金额
var total=0;
var goods_total=$('.tot');
goods_total.each(function(index){
    total += parseInt($(this).text());
})
    $('#total').text('$'+total);
$('#check').click(function () {
    var pay_way=0;
    if($('#cash-on-delivery').prop('checked')==true){
        pay_way=1;
    }else if($('#online-payments').prop('checked')==true){
        pay_way=2;
    }
    if(pay_way==0){
        alert('请选择支付方式');
        return false;
    }
    var address_name=$('#address_name').val();
    var email=$('#email').val();
    var address_detail=$('#address_detail').val();
    var city=$('#city').val();
    var tel=$('#tel').val();
    if(address_name=='' || email=='' || address_detail=='' || city=='' || tel==''){
        alert('收货信息不可缺失');
        return false;
    }
    var cart_id=$("div[class='order-review ll'");
    var c_id='';
    cart_id.each(function(index){
        c_id += $(this).attr('cart_id')+',';
    })
    c_id=c_id.substr(0,c_id.length-1);
    $.ajax({
        url:'/order/checkout',
        type:'post',
        data:{c_id:c_id,address_name:address_name,email:email,address_detail:address_detail,city:city,tel:tel,pay_way:pay_way},
        dataType:'json',
        success:function(index){
            if(index.errno==0){
                var r=confirm('生成订单成功，是否立即支付');
                if(r==true){
                    location.href="/pay/alipay?oid="+index.order_id;
                }else{
                    location.href='/order/order_list';
                }
            }else if(index.errno==1){
                alert(index.msg);
            }
        }
    })
})
</script>
@endsection