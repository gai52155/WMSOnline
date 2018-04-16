<?php

namespace App\Http\Controllers\Goods;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Goods\AddGoodsRequest;
use App\Goods;
use App\Goods_detail;
use DB;

class GoodsController extends Controller
{
    public function getIndex(){
    $goods = DB::select("SELECT t1.goods_id, t1.goods_name, sum(t2.goods_amount) AS goods_amount, t1.goods_limit, t1.goods_price, t1.goods_oldprice, t1.goods_booked
                         FROM goods t1
                         LEFT JOIN goods_detail t2 ON t1.goods_id = t2.goods_id
                         GROUP BY t1.goods_id
                         ORDER BY t1.goods_id");
    $search = false;
    $data=[
      'goods' => $goods,
      'search' => $search
    ];
    return view('goods.goods', $data);
  }

  public function getForm($goods_id = 0){
    if($goods_id != 0){
        $goods = Goods::where('goods_id', $goods_id)->first();
        if(!$goods) return redirect('goods.goods_form');
    }
    else{ $goods = false;}
    $data = array('goods_id' => $goods_id,'goods' => $goods);
    return view('goods.goods_form',$data);
  }

  public function getFormInput(AddGoodsRequest $req){
    $goods_id = $req->get('goods_id');
    $chk = Goods::where('goods_id',$goods_id)->first();
    $goods = $chk ? $chk : new Goods;
    if(!$chk){
      $goods->goods_id = $goods_id;
    }
    else if($goods->goods_price != $goods->goods_oldprice){
      $goods->goods_oldprice = $goods->goods_price;
    }
    $goods->goods_name = $req->get('goods_name');
    $goods->goods_price = $req->get('goods_price');
    $goods->goods_limit = $req->get('goods_limit');
    $goods->goods_booked = 0;
    $goods->save();

    return redirect('goods');
  }

  public function deleteGoods($goods_id){
    Goods::where('goods_id', '=', $goods_id)->delete();
    return redirect('goods');
  }

  public function searchGoods(Request $req){
    $searchTxt = $req->get('searchTxt');
    $searchTSel = $req->get('searchSel');

    $goods = Goods::where($searchTSel, 'LIKE', "%{$searchTxt}%")->get();
    $data=[
      'goods' => $goods,
      'search' => $searchTxt
    ];
    return view('goods.goods', $data);
  }
}
