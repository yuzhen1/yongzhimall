<?php

namespace App\Http\Controllers\cart;

use App\model\Cart;
use App\model\Goods;
use App\model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    //加入购物车
    public function cart_add($goods_id,Request $request){
//        session(['user'=>['user_email'=>'ssss','user_id'=>1]]);
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
        //获取商品id   购买数量
        $buy_num=intval($request->input('num'));
        if(empty($buy_num)){
            $buy_num=1;
        }
        $goods_id=intval($goods_id);
//        商品id非空
        if(empty($goods_id)){
            $response=[
                'errno'=>'1',
                'msg'=>'请选择要加入购物车的商品'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
//        查询商品是否存在
        $res=Goods::where('goods_id',$goods_id)->first();
        if(!$res){
            $response=[
                'errno'=>'1',
                'msg'=>'此商品不存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else if($res->status!=1){
            $response=[
                'errno'=>'1',
                'msg'=>'商品已下架'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
//        验证此商品是否被此用户加入购物车，如果加入则修改商品购买数量
        $rs=Cart::where(['goods_id'=>$goods_id,'user_id'=>$user_id])->first();
        if($rs){
            $res=Cart::where('id',$rs->id)->update(['buy_num'=>$rs->buy_num+$buy_num,'updated_at'=>time()]);
            if($res){
                $response=[
                    'errno'=>'0',
                    'msg'=>'加入成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'errno'=>'1',
                    'msg'=>'加入失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }else{
            //否则加入购物车  入库
            $res=Cart::insert(['user_id'=>$user_id,'goods_id'=>$goods_id,'buy_num'=>$buy_num,'created_at'=>time()]);
            if($res){
                $response=[
                    'errno'=>'0',
                    'msg'=>'加入成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'errno'=>'1',
                    'msg'=>'加入失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }
        }
    }
    //购物车列表
    public function cart_list(){
        $res=json_decode($this->cart_little(),true);

        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'msg'=>'请登录'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
            header('Refresh:2;url=/login');
            die;
        }
//        验证此用户是否存在
        $user_info=User::where('user_id',$user_id)->first();
        if(!$user_info){
            $response=[
                'msg'=>'没有此用户'
            ];
            header('Refresh:2;url=/login');
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $cart_info=Cart::join('shop_goods','shop_cart.goods_id','=','shop_goods.goods_id')
            ->where(['user_id'=>$user_id,'shop_cart.status'=>1])
            ->get();
        return view('cart.cart_list',['cart_info'=>$cart_info,'res'=>$res]);
    }
    //删除购物车
    public function cart_del(Request $request){
        $id=intval($request->input('c_id'));
        //获取用户id
        $user_id=session('user.user_id')??'';
        if($user_id==''){
            $response=[
                'errno'=>'1',
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
        if(empty($id)){
            $response=[
                'errno'=>'1',
                'msg'=>'请选择订单删除'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $res=Cart::where(['user_id'=>$user_id,'id'=>$id])->get();
        if($res){
            $rs=Cart::where('id',$id)->delete();
            if($rs){
                $response=[
                    'errno'=>'0',
                    'msg'=>'删除成功'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }else{
                $response=[
                    'errno'=>'1',
                    'msg'=>'删除失败'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }

        }else{
            $response=[
                'errno'=>'1',
                'msg'=>'查询您没有此订单'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }

    }

}
