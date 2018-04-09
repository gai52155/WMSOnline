<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use App\WarehouseDetail;
use Request;
use DB;

class WarehouseDetailController extends Controller
{
    function getIndex($warehouse_id){
    $warehouse = WarehouseDetail::selectRaw('*')->where('warehouse_id', $warehouse_id)->get();
    $search = false;
    $data=[
      'warehouse' => $warehouse,
      'warehouse_id' => $warehouse_id,
      'search' => $search
    ];
    return view('warehouse.warehouse_detail', $data);
  }
}
