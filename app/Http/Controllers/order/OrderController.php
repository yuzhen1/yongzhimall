<?php

namespace App\Http\Controllers\order;

use App\model\Address;
use App\model\Cart;
use App\model\Detail;
use App\model\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\User;

class OrderController extends Controller
{
//    生成订单页面
    public function order_view(Request $request){
        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'errno'=>1,
                'msg'=>'请登录'
            ];
            header('Refresh:2;url=/login');
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
//        验证此用户是否存在
        $user_info=User::where('user_id',$user_id)->first();
        if(!$user_info){
            $response=[
                'errno'=>'1',
                'msg'=>'没有此用户'
            ];
            header('Refresh:2;url=/login');
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $c_id=$request->input('c_id');
        if(!$c_id){
            $response=[
                'errno'=>'1',
                'msg'=>'请选择购物车订单进行结算'
            ];
            header('Refresh:2;url=/cart/list');
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $c_id=explode(',',$c_id);
//        dd($c_id);
//        echo $c_id[1];die;
        for($i=0;$i<count($c_id);$i++){
            $cart_info=Cart::where(['user_id'=>$user_id,'id'=>$c_id[$i],'status'=>1])->get();
            if(!$cart_info){
                $response=[
                    'errno'=>'1',
                    'msg'=>'请选择正确的购物车订单'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
        $cart_info=Cart::join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
            ->where('user_id',$user_id)
            ->whereIn('id',$c_id)->get();
        $res=json_decode($this->cart_little(),true);
        return view('order.order_list',['cart_info'=>$cart_info,'res'=>$res]);
    }
   //生成订单
    public function order(Request $request){
//        session(["user"=>["user_name"=>"sss","user_id"=>"1"]]);
        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'errno'=>1,
                'msg'=>'请登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
//        验证此用户是否存在
        $user_info=User::where('user_id',$user_id)->first();
        if(!$user_info){
            $response=[
                'errno'=>'1',
                'msg'=>'没有此用户'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $c_id=$request->input('c_id');
        $address_name=$request->input('address_name');
        $city=$request->input('city');
        $address_detail=$request->input('address_detail');
        $email=$request->input('email');
        $tel=$request->input('tel');
        $pay_way=$request->input('pay_way');

        if(empty($address_detail)||empty($address_name)||empty($city)||empty($email)||empty($tel)){
            $response=[
                'errno'=>'1',
                'msg'=>'收货信息不全'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if(empty($pay_way)){
            $response=[
                'errno'=>'1',
                'msg'=>'请选择付款方式'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        if(!$c_id){
            $response=[
                'errno'=>'1',
                'msg'=>'请选择购物车订单进行结算'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $c_id=explode(',',$c_id);
        for($i=0;$i<count($c_id);$i++){
            $cart_info=Cart::where(['user_id'=>$user_id,'id'=>$c_id[$i],'status'=>1])->first();
            if(!$cart_info){
                $response=[
                    'errno'=>'1',
                    'msg'=>'购物车订单不存在'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
        //生成订单号
        $order_no='jd'.substr(md5($user_id),0,13).time();
        //求出总金额
        $count_price=0;
        $cart_info=Cart::join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
                    ->where(['user_id'=>$user_id,'shop_cart.status'=>1])
                    ->whereIn('id',$c_id)->get();
        foreach($cart_info as $k=>$v){
            $count_price+=$v->buy_num*$v->goods_price;
        }

//        加入订单表
        $data=[
            'order_no'=>$order_no,
            'user_id'=>$user_id,
            'order_amout'=>$count_price,
            'pay_way'=>$pay_way,
            'created_at'=>time()
        ];
        $oid=Order::insertGetId($data);
        if(!$oid){
            $response=[
                'errno'=>'1',
                'msg'=>'加入订单失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //加入订单详情表
        foreach($cart_info as $k=>$v){
            $detail_data=[
                'order_id'=>$oid,
                'order_no'=>$order_no,
                'user_id'=>$user_id,
                'goods_id'=>$v->goods_id,
                'buy_num'=>$v->buy_num,
                'goods_price'=>$v->goods_price,
                'goods_name'=>$v->goods_name,
                'goods_img'=>$v->goods_img,
                'create_time'=>time(),
            ];
            $rs=Detail::insert($detail_data);
            if(!$rs){
                $response=[
                    'errno'=>'1',
                    'msg'=>'加入订单详情出现问题'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
        //加入订单收货地址表
        $address=[
            'order_id'=>$oid,
            'user_id'=>$user_id,
            'name'=>$address_name,
            'tel'=>$tel,
            'city'=>$city,
            'mail'=>$email,
            'address'=>$address_detail,
            'created_at'=>time()
        ];
        $res=Address::insert($address);
        if($res){
            foreach ($cart_info as $k=>$v){
                Cart::where('id',$v->id)->update(['status'=>2]);
            }
            $response=[
                'errno'=>'0',
                'msg'=>'生成订单成功',
                'order_id'=>$oid
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $response=[
                'errno'=>'1',
                'msg'=>'加入订单收货地址失败'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }
    //订单列表
    public function order_list(){
        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'errno'=>1,
                'msg'=>'请登录'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
//        验证此用户是否存在
        $user_info=User::where('user_id',$user_id)->first();
        if(!$user_info){
            $response=[
                'errno'=>'1',
                'msg'=>'没有此用户'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $order_info=Order::where(['user_id'=>$user_id,'status'=>0])->get();
        $res=json_decode($this->cart_little(),true);
        return view('order/o_list',['order_info'=>$order_info,'res'=>$res]);
    }
}
