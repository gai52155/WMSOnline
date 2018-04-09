<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use App\Http\Requests\Goods\AddGoodsDetailRequest;
use App\Goods_detail;
use App\Employee;
use App\Warehouse;
use App\WarehouseDetail;
use Response;
use Request;
use DB;

class GoodsDetailController extends Controller
{
    public function getIndex($goods_id){
    $goods = DB::select("SELECT goods_id, goods_amount, goods_waste, goods_import, goods_period, t2.emp_id, emp_name as emp_name
                         FROM goods_detail t1
                         INNER JOIN employee t2 ON t1.emp_id = t2.emp_id
                         WHERE goods_id = '$goods_id'
                         ORDER BY goods_import ASC");
    $search = false;
    $data=[
      'goods' => $goods,
      'goods_id' => $goods_id,
      'search' => $search
    ];
    return view('goods.goods_detail', $data);
  }

  public function getForm($goods_id, $goods_period = 0){
    if($goods_period != 0){
        $goods_detail = Goods_detail::where('goods_period', $goods_period)->first();
        if(!$goods_detail) return redirect('goods.goods_detail_form');
    }
    else{ $goods_detail = false;}
    $data = array('goods_id' => $goods_id, 'goods_period' => $goods_period, 'goods_detail' => $goods_detail);
    return view('goods.goods_detail_form',$data);
  }

  public function getFormInput(AddGoodsDetailRequest $req){
    $getlogin = Employee::where('emp_username', Session('nameLogin'))->pluck('emp_id');
    $goods_period = $req->get('goods_period');
    $goods_id = $req->get('goods_id');
    $chk = Goods_detail::where('goods_period',$goods_period)->first();
    $goods_detail = $chk ? $chk : new Goods_detail;
    $goods_detail->goods_id = $goods_id;
    if(!$chk){
      $goods_period = '20'.date('ymd');
      $goods_detail->goods_period = $goods_period;
    }
    else{
      $warehouse_detail_id = WarehouseDetail::where('goods_period', $goods_period)
                              ->Where('goods_id', $goods_id)
                              ->pluck('warehouse_detail_id');

      WarehouseDetail::where('warehouse_detail_id', $warehouse_detail_id)
                    ->update(['goods_id' => null,
                              'goods_period' => null]);
    }
    $goods_detail->goods_amount = $req->get('goods_amount');
    $goods_detail->goods_import = $req->get('goods_amount');
    $goods_detail->goods_waste = $req->get('goods_waste');
    $goods_detail->goods_import_from = $req->get('goods_import_from');
    $goods_detail->emp_id = $getlogin[0];

    $selectWarehouse_id = $req->get('selectCarco');
    $selectLocation = $req->get('selectLocation');

    $storage_index = ""; $floor_index = ""; $slot_index = ""; $flag = 1;
    $temp = str_split($selectLocation);
    for($i = 0;$i<sizeOf($temp);$i++){
      if($temp[$i] != "|"){ //ใช้ | ในการแบ่ง
        if($flag == 1){
          $storage_index .= $temp[$i];
        }
        else if($flag == 2){
          $floor_index .= $temp[$i];
        }
        else{
          $slot_index .= $temp[$i];
        }
      }
      else{
        $flag = $flag + 1;
      }
    }

    WarehouseDetail::where('warehouse_id', $selectWarehouse_id)
                    ->Where('storage_index', $storage_index)
                    ->Where('floor_index', $floor_index)
                    ->Where('slot_index', $slot_index)
                    ->update(['goods_id' => $goods_id,
                              'goods_period' => $goods_period]);

    Warehouse::where('warehouse_id', $selectWarehouse_id)->update(['warehouse_access_date' => date("Y-m-d H:i:s")]);

    $goods_detail->save();

    $checkFull = WarehouseDetail::where('goods_id', '=', null)->get();
    if(sizeof($checkFull) == 0){
      Warehouse::where('warehouse_id', $selectWarehouse_id)->update(['warehouse_status' => 1]);
    }

    return redirect('goods_detail/'.$goods_id);
  }

  public function deleteGoods($goods_id){
    Goods::where('goods_id', '=', $goods_id)->delete();
    return redirect('goods');
  }

  public function getStorage(){
    $data = Warehouse::select('warehouse_id')->where('warehouse_status','=', '0')->get();
    return Response::json($data);
  }

  public function getLocation(){
    $data = WarehouseDetail::select('storage_index', 'floor_index', 'slot_index')->where('goods_id', '=', null)->get();
    return Response::json($data);
  }
}
