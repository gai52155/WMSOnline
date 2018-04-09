<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\OrderDetail;
use App\Goods;

class OrderDetailController extends Controller
{
    function getIndex($order_id){
    	$order = OrderDetail::selectRaw('order_id, goods_id, goods_detail_amount')->where('order_id', $order_id)->get();
   		$search = false;
    	$data=[
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
}
