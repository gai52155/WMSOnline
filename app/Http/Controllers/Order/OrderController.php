<?php

namespace App\Http\Controllers\Order;

use Illuminate\Http\Request;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Controllers\Controller;
use App\Employee;
use App\Customer;
use App\Order;
use App\OrderDetail;
use App\Goods;
use App\Goods_detail;
use Response;
use DB;
use PDF;
class OrderController extends Controller
{
	function getIndex(){
		$order = DB::select("SELECT t1.order_id, t1.order_date, t1.order_summary, t1.order_payment_type, t1.order_payment_term, t1.order_payment_status, t1.order_delivery_status, t2.customer_namelastname, t3.emp_name
							 FROM orders t1
    					 LEFT JOIN customer_detail t2 ON t1.customer_id = t2.customer_id
							 LEFT JOIN employee t3 ON t1.emp_id = t3.emp_id
							 GROUP BY t1.order_id
							 ORDER BY t1.order_id");
    	$search = false;
    	$data=[
      		'order' => $order,
      		'search' => $search
   		];

		return view('order.order', $data);
	}

	function getForm($order_id = 0){
		if($order_id != 0){
			$order = Order::where('order_id', $order_id)->first();
         if(!$order) return redirect('order.order_form');
     }
     else{ $order = false;}
     $data = array('order_id' => $order_id,'order' => $order);
     return view('order.order_form',$data);
	}

	function getFormInput(OrderRequest $req){
		$summary = 0.0;
		$datep7 = strtotime("+7 day");
		$selectProduct = $req->get('selectProduct');
		$productBuyCount = $req->get('productBuyCount');
		
		$order_id = $req->get('order_id');
    	$chk = Order::where('order_id',$order_id)->first();
    	$order = $chk ? $chk : new Order;
    	
    	$order->order_date = date('20y-m-d H:i:s');
    	foreach ($selectProduct as $key => $n) {
			$price[$key] = Goods::where('goods_id', $selectProduct[$key])->value('goods_price');
			$summary = $summary + ((double) $productBuyCount[$key] * $price[$key]);

      Goods::where('goods_id', $selectProduct[$key])->update(['goods_booked' => $productBuyCount[$key]]);
		}
    $order->order_summary = $summary;
    $order->order_payment_term = date('20y-m-d H:i:s', $datep7);
  	$order->order_payment_status = 0;
  	$order->order_delivery_status = 0;
   	$order->customer_id = $req->get('selectCustomer');
    $order->order_payment_type = $req->get('order_payment_type');
   	$order->emp_id = Employee::select('emp_id')->where('emp_username', Session('nameLogin'))->value('emp_id');
   	$order->save();

   	$list = [];
    for($i=0;$i<count($selectProduct);$i++){
		  array_push($list, array("order_detail_id" => null, "order_id" => $order->order_id, "goods_id" => $selectProduct[$i], "goods_detail_amount" => $productBuyCount[$i]));
		}
		OrderDetail::insert($list);
    	return redirect('order');
  }

  function deleteOrder($order_id){
    $goods_count = OrderDetail::where('order_id', $order_id)->get();
    if(sizeof($goods_count) > 0){
      foreach ($goods_count as $key => $u) {
        $turn = Goods::where('goods_id', $u->goods_id)->value('goods_booked') - $u->goods_detail_amount;
        Goods::where('goods_id', $u->goods_id)->update(['goods_booked' => $turn]);
        OrderDetail::where('order_detail_id', $u->order_detail_id)->delete();
      }
    }
    Order::where('order_id', $order_id)->delete();
    return redirect('order');
  }

  function confirmOrder($order_id){
    Order::where('order_id', $order_id)->update(['order_payment_status' => 1]);
    $order_detail = OrderDetail::where('order_id', $order_id)->get();
    foreach ($order_detail as $key => $value) {
      $goods_detail = Goods_detail::where('goods_id', $value->goods_id)->where('goods_amount', '>', '0')->orderBy('goods_period', 'asc')->first();

      $delAmount = $goods_detail->goods_amount - Goods::where('goods_id', $value->goods_id)->value('goods_booked');

      Goods_detail::where('goods_id', $value->goods_id)->where('goods_period', $goods_detail->goods_period)->update(['goods_amount' => $delAmount]);

      Goods::where('goods_id', $value->goods_id)->update(['goods_booked' => 0]);
    }
    return redirect('order');
  }

  function confirmDelivery($order_id){
    Order::where('order_id', $order_id)->update(['order_delivery_status' => 1]);
    return redirect('order');
  }

  function getCustomerData(){
  	$data = Customer::select('customer_id','customer_namelastname')->get();
    return Response::json($data);
  }

  function getGoodsData(){
  	$data = DB::select(" SELECT t1.goods_id, t1.goods_name, sum(t2.goods_amount - t2.goods_waste) - t1.goods_booked AS goods_amountall
                         FROM goods t1
                         LEFT JOIN goods_detail t2 ON t1.goods_id = t2.goods_id
                         GROUP BY t1.goods_id
                         ORDER BY t1.goods_id");
    return Response::json($data);
  }

  function orderSearch(Request $req){
    $searchTSel = $req->get('searchSel');
    $searchTxt = $req->get('searchTxt');
    $searchPayType = $req->get('searchPayType');
    $where = "";
    if($searchTSel == "order_id"){
      $where = "t1.order_id = ".$searchTxt;
    }
    else{
      $where = "t2.customer_namelastname LIKE '%".$searchTxt."%' AND t1.order_payment_status = ".$searchPayType;
    }
    $order = DB::select("SELECT t1.order_id, t1.order_date, t1.order_summary, t1.order_payment_type, t1.order_payment_term, t1.order_payment_status, t1.order_delivery_status, t2.customer_namelastname, t3.emp_name
               FROM orders t1
               LEFT JOIN customer_detail t2 ON t1.customer_id = t2.customer_id
               LEFT JOIN employee t3 ON t1.emp_id = t3.emp_id
               WHERE $where
               GROUP BY t1.order_id
               ORDER BY t1.order_id");
      $search = 1;
      $data=[
          'order' => $order,
          'search' => $search
      ];

    return view('order.order', $data);
  }

  function orderInvoice($order_id){
    $order_start_end = Order::select('order_date', 'order_payment_term', 'customer_id')->where('order_id', $order_id)->first();
    $customerId = $order_start_end->customer_id;
    $getCustomer = Customer::select('*')->where('customer_id', $customerId)->first();
    $orderDetail = DB::select("SELECT t3.goods_name, t3.goods_price, t2.goods_detail_amount,(t2.goods_detail_amount * t3.goods_price) AS sum_price
                                FROM orders t1
                                LEFT JOIN order_detail t2 ON t1.order_id = t2.order_id
                                LEFT JOIN goods t3 ON t2.goods_id = t3.goods_id
                                WHERE t1.order_id = $order_id");

    $data=[
          'orderDetail' => $orderDetail,
          'getCustomer' => $getCustomer,
          'order_start_end' => $order_start_end,
          'order_id' => $order_id
      ];
    return view('order.order_invoice', $data);
  }

  function printOrder($order_id){
    $order_start_end = Order::select('order_date', 'order_payment_term', 'customer_id')->where('order_id', $order_id)->first();
    $customerId = $order_start_end->customer_id;
    $getCustomer = Customer::select('*')->where('customer_id', $customerId)->first();
    $orderDetail = DB::select("SELECT t3.goods_name, t3.goods_price, t2.goods_detail_amount,(t2.goods_detail_amount * t3.goods_price) AS sum_price
                                FROM orders t1
                                LEFT JOIN order_detail t2 ON t1.order_id = t2.order_id
                                LEFT JOIN goods t3 ON t2.goods_id = t3.goods_id
                                WHERE t1.order_id = $order_id");

    $data=[
          'orderDetail' => $orderDetail,
          'getCustomer' => $getCustomer,
          'order_start_end' => $order_start_end,
          'order_id' => $order_id
      ];
    $pdf = PDF::loadView('order.order_invoice', $data);
    return $pdf->stream('document.pdf');
  }
}