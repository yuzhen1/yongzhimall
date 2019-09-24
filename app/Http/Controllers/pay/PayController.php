<?php

namespace App\Http\Controllers\pay;
use App\model\Address;
use App\model\Detail;
use App\model\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\model\Order;
use App\model\User;
use Illuminate\Support\Str;
class PayController extends Controller
{

    public $weixin_unifiedorder_url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
    public $weixin_notify_url = 'http://store.zhbcto.com/weixin/pay/notify';
    public $values=[];


    public $app_id;
    public $gate_way;
    public $notify_url;
    public $return_url;
    public $rsaPrivateKeyFilePath;
    public $aliPubKey;
    public function __construct()
    {
        $this->app_id = env('ALIPAY_APPID');
        $this->gate_way = 'https://openapi.alipaydev.com/gateway.do';
        $this->notify_url = env('ALIPAY_NOTIFY_URL');
        $this->return_url = env('ALIPAY_RETURN_URL');
        $this->rsaPrivateKeyFilePath = storage_path('app/keys/alipay/priv.key');    //应用私钥
        $this->aliPubKey = storage_path('app/keys/alipay/ali_pub.key'); //支付宝公钥
    }
    public function test()
    {
        echo $this->aliPubKey;echo '</br>';
        echo $this->rsaPrivateKeyFilePath;echo '</br>';
    }
    /**
     * 订单支付
     * @param $oid
     */
    public function pay(Request $request)
    {
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



        $oid=$request->input('oid');
        //验证订单状态 是否已支付 是否是有效订单
        $order_info = Order::where(['order_id'=>$oid,'status'=>0,'pay_status'=>1,'user_id'=>$user_id])->first();

        if(!$order_info){
            header('Refresh:2;url=/index');
            die('该订单号不存在,三秒钟后会跳转至主页');
        }
        if($order_info->pay_way==2){

            if( strstr ($_SERVER['HTTP_USER_AGENT'],'Android') ){
                //            支付宝支付
                //业务参数
                $bizcont = [
                    'subject'           => 'Lening-Order: ' .$oid,
                    'out_trade_no'      => $order_info->order_no,
                    'total_amount'      => $order_info->order_amout ,
                    'product_code'      => 'QUICK_WAP_WAY',
                ];
                //公共参数
                $data = [
                    'app_id'   => $this->app_id,
                    'method'   => 'alipay.trade.wap.pay',
                    'format'   => 'JSON',
                    'charset'   => 'utf-8',
                    'sign_type'   => 'RSA2',
                    'timestamp'   => date('Y-m-d H:i:s'),
                    'version'   => '1.0',
                    'notify_url'   => $this->notify_url,        //异步通知地址
                    'return_url'   => $this->return_url,        // 同步通知地址
                    'biz_content'   => json_encode($bizcont),
                ];
                //签名
                $sign = $this->rsaSign($data);
                $data['sign'] = $sign;
                $param_str = '?';
                foreach($data as $k=>$v){
                    $param_str .= $k.'='.urlencode($v) . '&';
                }
                $url = rtrim($param_str,'&');
                $url = $this->gate_way . $url;
                header("Location:".$url);       // 重定向到支付宝支付页面
            }else{
                require_once app_path('/libs/alipay/pagepay/service/AlipayTradeService.php');
                require_once app_path('/libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php');


                //商户订单号，商户网站订单系统中唯一订单号，必填
                $out_trade_no = $order_info->order_no;

                //订单名称，必填
                $subject = "1809a测试";

                //付款金额，必填
                $total_amount = trim($order_info->order_amout);

                //商品描述，可空
                $body = "";

                //构造参数
                $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
                $payRequestBuilder->setBody($body);
                $payRequestBuilder->setSubject($subject);
                $payRequestBuilder->setTotalAmount($total_amount);
                $payRequestBuilder->setOutTradeNo($out_trade_no);

                $aop = new \AlipayTradeService(config('alipay'));

                /**
                 * pagePay 电脑网站支付请求
                 * @param $builder 业务参数，使用buildmodel中的对象生成。
                 * @param $return_url 同步跳转地址，公网可以访问
                 * @param $notify_url 异步通知地址，公网可以访问
                 * @return $response 支付宝返回的信息
                 */
                $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));
                //输出表单
                var_dump($response);
            }
        }else if($order_info->pay_way==1){
            if( strstr ($_SERVER['HTTP_USER_AGENT'],'Android')){
                //微信支付
                $total_fee=1;
                $order_id=$order_info->order_no;
                $arr=[
                    'h5_info'=>[
                        'tap'=>'Wap',
                        'wap_url'=>'http://store.zhbcto.com',
                        'wap_name'=>'测试订单支付'
                    ]
                ];
                $info=[
                    'appid'		=>	env('WEIXIN_APPID_0'),
                    'mch_id'	=>	env('WEIXIN_MCH_ID'),
                    'nonce_str'	=>	Str::random(16),
                    'sign_type'	=>	'MD5',
                    'body'		=>'测试订单号：'.$order_id,
                    'out_trade_no'	=>	$order_id,
                    'total_fee'	=>	$total_fee,
                    'spbill_create_ip'	=>	$_SERVER['REMOTE_ADDR'],
                    'notify_url'	=> 	$this->weixin_notify_url,
                    'trade_type'	=> 'MWEB',
                    'scene_info'=>json_encode($arr,JSON_UNESCAPED_UNICODE)
                ];
                $this->values=$info;
                $this->SetSign();
                // dd($this->values);
                $xml=$this->toxml();
                $res = $this->postXmlCurl($xml, $this->weixin_unifiedorder_url, $useCert = false, $second = 30);
                $obj=simplexml_load_string($res);
            }else{

//                dd(json_encode($arr,JSON_UNESCAPED_UNICODE));
                //微信支付
                $total_fee=1;
                $order_id=$order_info->order_no;

                $info=[
                    'appid'		=>	env('WEIXIN_APPID_0'),
                    'mch_id'	=>	env('WEIXIN_MCH_ID'),
                    'nonce_str'	=>	Str::random(16),
                    'sign_type'	=>	'MD5',
                    'body'		=>'测试订单号：'.$order_id,
                    'out_trade_no'	=>	$order_id,
                    'total_fee'	=>	$total_fee,
                    'spbill_create_ip'	=>	$_SERVER['REMOTE_ADDR'],
                    'notify_url'	=> 	$this->weixin_notify_url,
                    'trade_type'	=> 'NATIVE'
                ];
                $this->values=$info;
                $this->SetSign();
                // dd($this->values);
                $xml=$this->toxml();
                $res = $this->postXmlCurl($xml, $this->weixin_unifiedorder_url, $useCert = false, $second = 30);
                $obj=simplexml_load_string($res);
                $data=[
                    'code_url'=>$obj->code_url,
                    'oid'=>$order_info->order_id
                ];
                return view('weixin.test',$data);


            }

        }
    }
    public function rsaSign($params) {
        return $this->sign($this->getSignContent($params));
    }
    protected function sign($data) {
        $priKey = file_get_contents($this->rsaPrivateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        if(!$this->checkEmpty($this->rsaPrivateKeyFilePath)){
            openssl_free_key($res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }
    public function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, 'UTF-8');
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }
        unset ($k, $v);
        return $stringToBeSigned;
    }
    protected function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;
        return false;
    }
    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = 'UTF-8';
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
            }
        }
        return $data;
    }
    /**
     * 支付宝异步通知
     */
    public function notifypay()
    {
        $p = json_encode($_POST);
        $log_str = "\n>>>>>> " .date('Y-m-d H:i:s') . ' '.$p . " \n";
        file_put_contents('logs/alipay_notify',$log_str,FILE_APPEND);
        echo 'success';
        //TODO 验签 更新订单状态
    }
    /**
     * 支付宝同步通知
     */
    public function aliReturn()
    {
        $data=$_GET;
        echo '<pre>';print_r($data);echo '</pre>';
//        echo '您的订单号为:'.;
    }
//判断用户电脑端还是手机端
    function isMobile(){
        $useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';
        function CheckSubstrs($substrs,$text){
            foreach($substrs as $substr)
                if(false!==strpos($text,$substr)){
                    return true;
                }
            return false;
        }
        $mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
        $mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');

        $found_mobile = CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||  CheckSubstrs($mobile_token_list,$useragent);

        if ($found_mobile){
            return true;
        }else{
            return false;
        }
    }



//    微信支付
    //回调地址
    public function notify_url(){
        $data=file_get_contents('php://input');
        $log_str = date('Y-m-d H:i:s') . "\n" . $data . "\n<<<<<<<";

        file_put_contents('logs/wx_pay.logs',$log_str,FILE_APPEND);
        $xml = simplexml_load_string($data);
        if($xml->result_code=='SUCCESS' && $xml->return_code=='SUCCESS'){      //微信支付成功回调
            //验证签名
            $sign = true;
            if($sign){       //签名验证成功
                //TODO 逻辑处理  订单状态更新
                $out_trade_no=$xml->out_trade_no;
                $order_info=Order::where(['order_no'=>$out_trade_no])->first();
                if($order_info){
                    Address::where('order_id',$order_info->order_id)->update(['status'=>1]);
                    $res=Order::where(['order_no'=>$out_trade_no])->update(['pay_amout'=>$xml->cash_fee,'pay_time'=>time(),'pay_status'=>1]);
                    $goodsInfo=Detail::where(['order_no'=>$out_trade_no])->get();
                    foreach($goodsInfo->toArray() as $k=>$v){
                        $good=Goods::where(['goods_id'=>$v['goods_id']])->first();
                        Goods::where(['goods_id'=>$v['goods_id']])->update(['goods_num'=>$good->goods_num-$v['buy_num']]);
                    }
                }

            }else{
                //TODO 验签失败
                echo '验签失败，IP: '.$_SERVER['REMOTE_ADDR'];
                // TODO 记录日志
            }
        }
        $response = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        echo $response;
    }
    //将数据转换为xml形式
    public function toxml(){
        if(!is_array($this->values)||count($this->values)<=0){
            die('数据格式异常');
        }
        $xml='<xml>';
        foreach($this->values as $k=>$v){
            if(is_numeric($v)){
                $xml .= '<'.$k.'>'.$v.'</'.$k.'>';
            }else{
                $xml .= '<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
            }
        }
        $xml.='</xml>';
        return $xml;
    }
    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
//		if($useCert == true){
//			//设置证书
//			//使用证书：cert 与 key 分别属于两个.pem文件
//			curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLCERT, WxPayConfig::SSLCERT_PATH);
//			curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
//			curl_setopt($ch,CURLOPT_SSLKEY, WxPayConfig::SSLKEY_PATH);
//		}
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }
    //生成签名
    public function SetSign(){
        $sign=$this->makeSign();
        $this->values['sign']=$sign;
        return $sign;
    }
    //制作签名
    public function makeSign(){
        //第一步,排序签名,对参数按照key=value的格式，并按照参数名ASCII字典序排序
        Ksort($this->values);
        $str=$this->ToUrlParams();
        //第二步,拼接API密钥并加密
        $sign_str=$str.'&key='.env('WEIXIN_MCH_KEY');
        $sign=MD5($sign_str);
        //第三步,将所有的字符转换为大写
        $string=strtoupper($sign);
        return $string;
    }
    public function ToUrlParams(){
        $str='';
        foreach($this->values as $k=>$v){
            if($k!='sign'&&$v!=''&&!is_array($v)){
                $str .= $k.'='.$v.'&';
            }
        }
        $str=trim($str,'&');
        return $str;
    }
    //验证微信支付是否成功
    public function paystatus(){
        $res=Order::where(['oid'=>$_GET['oid']])->first();

        $response=[
            'code'=>2,
        ];

        if($res){
            if($res->pay_status==1){
                $response=[
                    'code'=>1,
                    'font'=>'支付成功'
                ];
            }
        }
        return json_encode($response);
    }
    //支付成功
    public function supay(){
        echo "支付成功";
    }

}

