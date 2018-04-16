<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Goods;
use DB;

class OrderDetailController extends Controller
{
    function getIndex($order_id){
    	//$order = OrderDetail::selectRaw('order_id, goods_id, goods_detail_amount')->where('order_id', $order_id)->get();
      $order = DB::select("SELECT t1.order_id, t1.goods_id, t2.goods_name, t1.goods_detail_amount
                            FROM order_detail t1
                            LEFT JOIN goods t2 ON t1.goods_id = t2.goods_id
                            WHERE t1.order_id = $order_id
                            ORDER BY t1.order_id");
      $chkPay = Order::where('order_id', $order_id)->value('order_payment_status');
   		$search = false;
    	$data=[
        'chkPay' => $chkPay,
    	  'order_id' => $order_id,
        'order' => $order,
      	'search' => $search
    	];

    	return view('order.order_detail', $data);
    }

    function deleteOrderDetail($order_id, $goods_id){
    	$order_detail = OrderDetail::where('order_id', $order_id)->where('goods_id', $goods_id)->first();

    	//ลดยอดรวม ORDER
    	$price = Goods::where('goods_id', $goods_id)->value('goods_price');
    	$goodsSummary = $order_detail->goods_detail_amount * $price;
      $getOldPrice = Order::where('order_id', $order_id)->value('order_summary');
      $summary = $getOldPrice - $goodsSummary;
      Order::where('order_id', $order_id)->update(['order_summary' => $summary]);

      	//คืนการจอง
    	$turn = Goods::where('goods_id', $goods_id)->value('goods_booked') - $order_detail->goods_detail_amount;
      Goods::where('goods_id', $goods_id)->update(['goods_booked' => $turn]);
      OrderDetail::where('order_detail_id', $order_detail->order_detail_id)->delete();

    	return redirect('/order/'.$order_id);
    }

    function editOrderDetail(Request $req, $order_id){
      $goods_id = $req->get('goods_id');
      $newValue = $req->get('newValue');
      $oldValue = $req->get('oldValue');
      //คิดยอดที่จะ + เข้าไปใหม่
      $price = Goods::where('goods_id', $goods_id)->value('goods_price');
      $summary = ((double) $newValue * $price);

      //ยอดเก่าก่อนแก้
      $oldPrice = Goods::where('goods_id', $goods_id)->value('goods_price');
      $oldSummary = ((double) $oldValue * $price);

      $newPrice = $summary - $oldSummary;

      $getOldPrice = Order::where('order_id', $order_id)->value('order_summary');
      $newSum = $getOldPrice + $newPrice;

      Order::where('order_id', $order_id)->update(['order_summary' => $newSum]);
      
      Goods::where('goods_id', $goods_id)->update(['goods_booked' => $newValue]);

      OrderDetail::where('order_id', $order_id)->where('goods_id', $goods_id)->update(['goods_detail_amount' => $newValue]);

      return redirect('/order/'.$order_id);
    }
}
