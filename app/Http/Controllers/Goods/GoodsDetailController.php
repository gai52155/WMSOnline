<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use App\Http\Requests\Goods\AddGoodsDetailRequest;
use App\Goods_detail;
use App\Employee;
use App\Warehouse;
use App\WarehouseDetail;
use Response;
use Illuminate\Http\Request;
use DB;

class GoodsDetailController extends Controller
{
    function getIndex($goods_id){
    $goods = DB::select("SELECT t1.goods_detail_id, t1.goods_id, t1.goods_amount, goods_waste, goods_import, t1.goods_period, goods_import_from, t2.emp_id, emp_name as emp_name, t3.warehouse_id, 
                                t3.storage_index, t3.floor_index, t3.slot_index
                         FROM goods_detail t1
                         INNER JOIN employee t2 ON t1.emp_id = t2.emp_id
                         INNER JOIN warehouse_detail t3 ON t1.goods_id = t3.goods_id AND t1.goods_period = t3.goods_period AND t1.goods_amount = t3.goods_amount
                         WHERE t1.goods_id = $goods_id
                         ORDER BY goods_import ASC");
    $search = false;
    $data=[
      'goods' => $goods,
      'goods_id' => $goods_id,
      'search' => $search
    ];
    return view('goods.goods_detail', $data);
  }

  function getForm($goods_id, $goods_period = 0){
    if($goods_period != 0){
        $goods_detail = Goods_detail::where('goods_period', $goods_period)->first();
        if(!$goods_detail) return redirect('goods.goods_detail_form');
    }
    else{ $goods_detail = false;}
    $data = array('goods_id' => $goods_id, 'goods_period' => $goods_period, 'goods_detail' => $goods_detail);
    return view('goods.goods_detail_form',$data);
  }

  function getFormInput(AddGoodsDetailRequest $req){
    $getlogin = Employee::where('emp_username', Session('nameLogin'))->value('emp_id');
    $goods_period = $req->get('goods_period');
    $goods_id = $req->get('goods_id');
    $goods_amount = $req->get('goods_amount');
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
                              ->value('warehouse_detail_id');

      WarehouseDetail::where('warehouse_detail_id', $warehouse_detail_id)
                    ->update(['goods_id' => null,
                              'goods_period' => null]);
    }
    $goods_detail->goods_amount = $goods_amount;
    $goods_detail->goods_import = $goods_amount;
    $goods_detail->goods_waste = $req->get('goods_waste');
    $goods_detail->goods_import_from = $req->get('goods_import_from');
    $goods_detail->emp_id = $getlogin;

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
                              'goods_amount' => $goods_amount,
                              'goods_period' => $goods_period]);

    Warehouse::where('warehouse_id', $selectWarehouse_id)->update(['warehouse_access_date' => date("Y-m-d H:i:s")]);

    $goods_detail->save();

    $checkFull = WarehouseDetail::where('goods_id', '=', null)->get();
    if(sizeof($checkFull) == 0){
      Warehouse::where('warehouse_id', $selectWarehouse_id)->update(['warehouse_status' => 1]);
    }

    return redirect('goods_detail/'.$goods_id);
  }

  function editGoods(Request $req){
    $goods_id = $req->get('goods_id');
    $goods_detail_id = $req->get('goods_detail_id');
    $goods_import_new = $req->get('goods_import');
    $goods_waste = $req->get('goods_waste');
    $getImport = Goods_detail::where('goods_detail_id', $goods_detail_id)->value('goods_import');
    $newImport =  $goods_import_new - $getImport;
    $newAmount = Goods_detail::where('goods_detail_id', $goods_detail_id)->value('goods_amount') + $newImport;

    //UPDATE DATA
    Goods_detail::where('goods_detail_id', $goods_detail_id)->update(['goods_amount' => $newAmount,
                                                                      'goods_import' => $goods_import_new,
                                                                      'goods_waste' => $goods_waste]);

    return redirect('goods_detail/'.$goods_id);
  }

  function deleteGoods($goods_id){
    Goods::where('goods_id', '=', $goods_id)->delete();
    return redirect('goods');
  }

  function getStorage(){
    $data = Warehouse::select('warehouse_id')->where('warehouse_status','=', '0')->get();
    return Response::json($data);
  }

  function getLocation($cargo){
    $data = WarehouseDetail::select('storage_index', 'floor_index', 'slot_index')->where('warehouse_id', $cargo)->where('goods_id', null)->get();
    return Response::json($data);
  }
}
