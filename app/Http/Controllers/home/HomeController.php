<?php

namespace App\Http\Controllers\home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Goods;
class HomeController extends Controller
{
    //
    public function index(){
        $goods_new_info=Goods::where(['goods_new'=>1,'goods_show'=>1])->get()->toArray();
        $goods_best_info=Goods::where(['goods_best'=>1,'goods_show'=>1])->paginate('4');
        $res=json_decode($this->cart_little(),true);
        $data=[
            'goods_new_info'=>$goods_new_info,
            'goods_best_info'=>$goods_best_info,
            'res'=>$res
        ];
        return view('home.index',$data);
    }
}
