<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\WarehouseRequest;
use App\Warehouse;
use App\WarehouseDetail;
use Request;
use DB;

class WarehouseController extends Controller
{
    public function getIndex(){
    $storage = Warehouse::selectRaw("*")->get();
    $search = false;
    $data=[
       'storage' => $storage,
       'search' => $search
    ];
     return view('warehouse.warehouse', $data);
   }

	 public function getForm($warehouse_id = 0){
     if($warehouse_id != 0){
         $warehouse = warehouse::where('warehouse_id', $warehouse_id)->first();
         if(!$warehouse) return redirect('warehouse.warehouse_form');
     }
     else{ $warehouse = false;}
     $data = array('warehouse_id' => $warehouse_id,'warehouse' => $warehouse);
     return view('warehouse.warehouse_form',$data);
   }

	 public function getFormInput(WarehouseRequest $req){
     $warehouse_id = $req->get('warehouse_id');
		 $storage = $req->get('warehouse_storageCount');
		 $floor = $req->get('warehouse_floorCount');
		 $slot = $req->get('warehouse_slotCount');
     $chk = Warehouse::where('warehouse_id',$warehouse_id)->first();
     $warehouse = $chk ? $chk : new Warehouse;
     if(!$chk){
       $warehouse->warehouse_id = $warehouse_id;

			 $list = [];
			 for($i=0;$i<$storage;$i++){
				 for($j=0;$j<$floor;$j++){
					 for($k=0;$k<$slot;$k++){
						 array_push($list, array("warehouse_detail_id" => null, "warehouse_id" => $warehouse_id, "storage_index" => $i+1, "floor_index" => $j+1, "slot_index" => $k+1));
			 		}
		 		}
			}
			WarehouseDetail::insert($list);
     }
		 $warehouse->warehose_status = 0;
     $warehouse->warehouse_storageCount = $storage;
     $warehouse->warehouse_floorCount = $floor;
     $warehouse->warehouse_slotCount = $slot;
     $warehouse->save();

     return redirect('warehouse');
   }

	 public function deleteGoods($goods_id){
		 Goods::where('goods_id', '=', $goods_id)->delete();
		 return redirect('goods');
	 }

	 public function searchGoods(){
		 $searchTxt = Request::input('searchTxt');
		 $searchTSel = Request::input('searchSel');

		 $goods = Goods::where($searchTSel, 'LIKE', "%{$searchTxt}%")->get();
		 $data=[
			 'goods' => $goods,
			 'search' => $searchTxt
		 ];
		 return view('goods.goods', $data);
	 }
}
