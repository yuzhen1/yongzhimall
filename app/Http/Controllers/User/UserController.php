<?php

namespace App\Http\Controllers\User;

use App\User;
use App\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * 注册视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function register(){
        $res=json_decode($this->cart_little(),true);

        return view('user/register',['res'=>$res]);
    }

    /**
     * 注册执行
     * @return string
     */
    public function reg_do(){
        $user_name = $_POST['user_name'];
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        //验证
        if(empty($user_name) || empty($email) || empty($pwd)){
            $response=[
                'errno'=>'2',
                'msg'=>'请填写完整的注册信息'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $nameInfo = UserModel::where(['user_name'=>$user_name])->first();
        if($nameInfo){
            $response=[
                'errno'=>'2',
                'msg'=>'用户名已存在'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $password=password_hash($pwd,PASSWORD_BCRYPT);
            $data = [
              'user_name'=>$user_name,
              'email'=>$email,
              'password'=>$password,
                'add_time'=>time()
            ];
            $res = UserModel::insertGetId($data);
            if($res){
                $response=[
                    'errno'=>'1',
                    'msg'=>'注册成功'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                $response=[
                    'errno'=>'2',
                    'msg'=>'好像出现了一点小错误呢'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }
    }

    /**
     * 登录的视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function login(){
        $res=json_decode($this->cart_little(),true);

        return view('/user/login',['res'=>$res]);
    }

    /**
     * 登录执行
     * @return string
     */
    public function login_do(){
        $user_name = $_POST['user_name'];
        $password = $_POST['password'];
        //验证用户名
        if(empty($user_name)){
            $response=[
                'errno'=>'2',
                'msg'=> '用户名不能为空'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        //根据用户名查询数据库
        $nameInfo = UserModel::where(['user_name'=>$user_name])->first();
        $time = time();
        if($nameInfo){
            $error_num = $nameInfo->error_num;        //错误次数
            $last_error_time=$nameInfo->last_error_time;  //最后一次错误的时间
            $updateWhere=[
                'user_id'=>$nameInfo->user_id
            ];
            if(password_verify($password,$nameInfo->password)){
                if($error_num>=3&&$time-$last_error_time<3600){
                    $remain = 60-(ceil(($time-$last_error_time)/60));
                    $response=[
                        'errno'=>'2',
                        'msg'=>"账号锁定中，请".$remain."分钟后重新登录"
                    ];
                    die(json_encode($response,JSON_UNESCAPED_UNICODE));
                }
                //错误次数改为0，错误时间改为null
                $updateInfo=[
                    'error_num'=>0,
                    'last_error_time'=>null
                ];
                UserModel::where($updateWhere)->update($updateInfo);

                $token = $this->getLoginToken($nameInfo->user_id);
                $key = 'login_token:user_id:'.$nameInfo->user_id;
                Redis::set($key,$token);
                Redis::expire($key,3600);
                session(['user'=>['user_name'=>$user_name,'user_id'=>$nameInfo->user_id]]);
                $response=[
                    'errno'=>'1',
                    'msg'=> '登录成功'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                //判断当前时间是否大于最后一次错误的时间
                if($time-$last_error_time>3600){
                    $updateInfo=[
                        'error_num'=>1,
                        'last_error_time'=>$time
                    ];
                    UserModel::where($updateWhere)->update($updateInfo);
                    $response=[
                        'errno'=>2,
                        'msg'=>"账号或密码有误，您还有2次机会可以登录"
                    ];
                    die(json_encode($response,JSON_UNESCAPED_UNICODE));
                }else{
                    if($error_num>=3){
                        $remain = 60-(ceil(($time-$last_error_time)/60));
                        $response=[
                            'errno'=>2,
                            'msg'=>"账号已锁定，请".$remain."分钟后重新登录"
                        ];
                        die(json_encode($response,JSON_UNESCAPED_UNICODE));
                    }else{
                        $updateInfo=[
                            'error_num'=>$error_num+1,
                            'last_error_time'=>$time
                        ];
                        UserModel::where($updateWhere)->update($updateInfo);
                        $num=3-($error_num+1);
                        $response=[
                            'errno'=>2,
                            'msg'=>"账号或密码有误，您还有".$num."次机会可以登录"
                        ];
                        die(json_encode($response,JSON_UNESCAPED_UNICODE));
                    }
                }
            }
        }else{
            $response=[
                'errno'=>'3',
                'msg'=> '该用户不存在，请先注册'
            ];
            return json_encode($response,JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 获取登录token
     * @param $user_id
     * @return bool|string
     */
    public function getLoginToken($user_id){
        $token = substr(md5($user_id.time().Str::random(10)),5,15);
        return $token;
    }

    /**
     * 忘记密码视图页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forget(){
        $res=json_decode($this->cart_little(),true);
      return view('user/forget',['res'=>$res]);
    }

    /**
     * 执行找回密码
     * @return string
     */
    public function forget_do(){
        $user_name = $_POST;
        if(empty($user_name)){
            $response=[
                'errno'=>'2',
                'msg'=> '用来找回密码的用户信息不能为空'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }else{
            $nameInfo = UserModel::where(['user_name'=>$user_name])->first();
            if($nameInfo){
                $response=[
                    'errno'=>'1',
                    'msg'=>'验证成功'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }
        }
    }

    /**
     * 设置新密码视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new_password(){
        $res=json_decode($this->cart_little(),true);
        return view('user/new_password',['res'=>$res]);
    }

    /**
     * 设置新密码
     * @return string
     */
    public function set_new_password(){
        $user_name = $_POST['user_name'];
        $set_password = $_POST['password'];
        if(empty($set_password)){
            $response=[
                'errno'=>'2',
                'msg'=> '请填写设置的新密码'
            ];
            die(json_encode($response,JSON_UNESCAPED_UNICODE));
        }
        $nameInfo = UserModel::where(['user_name'=>$user_name])->first();
        if($nameInfo){
            $new_password = password_hash($set_password,PASSWORD_BCRYPT);
            $res = UserModel::where(['user_name'=>$user_name])->update(['password'=>$new_password]);
            if($res){
                $response=[
                    'errno'=>'1',
                    'msg'=>'找回密码成功'
                ];
                return json_encode($response,JSON_UNESCAPED_UNICODE);
            }else{
                $response=[
                    'errno'=>'2',
                    'msg'=> '好像出错了，请重试'
                ];
                die(json_encode($response,JSON_UNESCAPED_UNICODE));
            }

        }
    }

    /**
     * 退出登录
     */
    public function logout(Request $request){
        $request->session()->forget('user');
        echo "<script>alert('退出成功');location.href='/login';</script>";
    }

    /**
     * 关于我们
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about_us(){
        $res=json_decode($this->cart_little(),true);
        return view('user/about_us',['res'=>$res]);
    }
}
