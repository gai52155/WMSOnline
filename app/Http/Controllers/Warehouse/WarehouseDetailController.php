<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use App\Warehouse;
use App\WarehouseDetail;
use Illuminate\Http\Request;
use DB;

class WarehouseDetailController extends Controller
{
  function getIndex($warehouse_id){
    $warehouse = WarehouseDetail::selectRaw('*')->where('warehouse_id', $warehouse_id)->orderBy('goods_period', 'desc')->get();
    $search = false;
    $data=[
      'warehouse' => $warehouse,
      'warehouse_id' => $warehouse_id,
      'search' => $search
    ];
    return view('warehouse.warehouse_detail', $data);
  }

  function moveGoods(Request $req){
    $oldwarehouse_id = $req->get('oldwarehouse_id');
    $goods_id = $req->get('goods_id');
    $goods_period = $req->get('goods_period');
    $goods_amount = $req->get('goods_amount');
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
    //DELETE OLD PLACE
    WarehouseDetail::where('warehouse_id', $oldwarehouse_id)
                      ->where('goods_id', $goods_id)
                      ->where('goods_period', $goods_period)
                      ->update(['goods_id' => null,
                                'goods_amount' => null,
                                'goods_period' => null]);
    Warehouse::where('warehouse_id', $oldwarehouse_id)->update(['warehouse_access_date' => date("Y-m-d H:i:s")]);
    //MOVE
    WarehouseDetail::where('warehouse_id', $selectWarehouse_id)
                      ->where('storage_index', $storage_index)
                      ->where('floor_index', $floor_index)
                      ->where('slot_index', $slot_index)
                      ->update(['goods_id' => $goods_id,
                                'goods_amount' => $goods_amount,
                                'goods_period' => $goods_period]);
    Warehouse::where('warehouse_id', $selectWarehouse_id)->update(['warehouse_access_date' => date("Y-m-d H:i:s")]);
    
    return redirect('warehouse_detail/'.$selectWarehouse_id);
  }
}
