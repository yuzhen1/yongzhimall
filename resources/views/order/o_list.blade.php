@extends('layouts.app')
@section('title', '订单列表')
@section('content')
    <table border="1">
        <tr>
            <td>订单号</td>
            <td>总价格</td>
            <td>操作</td>
        </tr>
        @foreach($order_info as $k=>$v)
        <tr>
            <td>{{$v->order_no}}</td>
            <td>{{$v->order_amout}}</td>
            <td><a href="/pay/alipay?oid={{$v->order_id}}" class="btn button-default">去支付</a></td>
        </tr>
        @endforeach
    </table>
    @endsection