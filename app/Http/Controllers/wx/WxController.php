<?php

namespace App\Http\Controllers\wx;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserModel;
class WxController extends Controller
{
    //
    public function wx(){
//        $a= urlEncode("http://store.zhbcto.com/wx");
//        $url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx71cba979e28407f8&redirect_uri=".$a."&response_type=code&scope=snsapi_base &state=STATE#wechat_redirect";
//        echo $url;die;

        $code=$_GET['code'];
        $access_token_url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx71cba979e28407f8&secret=764edbb06c265cfce2c7dca5f5128e25&code=".$code."&grant_type=authorization_code";
        $access_token=file_get_contents($access_token_url);
        $arr=json_decode($access_token);
        dd($arr);
        $token=$arr->access_token;
        $openid=$arr->openid;

        $openid_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
        $user_info=file_get_contents($openid_url);
        $user_info=json_decode($user_info,true);
        return view('weixin.wxsq',['user_info'=>$user_info]);
    }
    public function wxuser(Request $request){
        $openid=$request->openid;
        $nickname=$request->nickname;
        $user_openid=UserModel::where(['openid'=>$openid])->first();
        if($user_openid){
            echo "3";
            session(['user'=>['user_name'=>$user_openid['user_name'],'user_id'=>$user_openid['user_id']]]);
        }else{
            if(session('user.user_id')){
                echo "1";
            }else{
                echo "2";
                session(['user'=>['user_name'=>$nickname]]);
            };
        }
    }
    //绑定用户
    public function wxadd(Request $request){
        $openid=$request->openid;
        $user_id=session('user.user_id');
        $res=UserModel::where(['user_id'=>$user_id])->update(['openid'=>$openid]);
        $user_info=UserModel::where(['user_id'=>$user_id])->first()->toArray();
        if($res){
            echo "绑定成功";
            session(['user'=>['user_name'=>$user_info['user_name'],'user_id'=>$user_info['user_id']]]);
        }

    }
}
