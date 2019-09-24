<?php

namespace App\Http\Controllers;

use App\model\Cart;
use App\model\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function cart_little(){
        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'errno'=>1,
                'msg'=>'请登录'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
//        验证此用户是否存在
        $user_info=User::where('user_id',$user_id)->first();
        if(!$user_info){
            $response=[
                'errno'=>'1',
                'msg'=>'没有此用户'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
        $cart_info=Cart::join('shop_goods','shop_goods.goods_id','=','shop_cart.goods_id')
                    ->where(['user_id'=>$user_id,'shop_cart.status'=>1])->get();
        if($cart_info){
            $response=[
                'errno'=>'0',
                'data'=>$cart_info
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }else{
            $response=[
                'errno'=>'1',
                'msg'=>'没有数据'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }
}
