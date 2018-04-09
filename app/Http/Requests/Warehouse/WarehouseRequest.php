<?php 
namespace App\Http\Requests\Warehouse;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest {
        //กำหนดเงื่อนไข ของการกรองข้อมูล
    public function rules()
    {
      if($this->get('warehouse_id') == 0){
      return[
        'warehouse_id'=>'required|size:3|unique:warehouse',
        'warehouse_storageCount'=>'required',
        'warehouse_floorCount'=>'required',
        'warehouse_slotCount'=>'required',
      ];
    }
    else{
      return[
        'warehouse_storageCount'=>'required|min:1',
        'warehouse_floorCount'=>'required|min:1',
        'warehouse_slotCount'=>'required|min:1',
      ];
    }
    }
    public function messages()
    {
        return [

            'warehouse_id.required' => 'ระบุ ID คลังสินค้า',
            'warehouse_id.unique' => 'ID คลังสินค้านี้มีในระบบแล้ว',
            'warehouse_id.size' => 'ระบุ ID คลังสินค้า 3 ตัวอักษร',

            'warehouse_storageCount.required' => 'ระบุจำนวนชั้นวางสินค้า',

            'warehouse_floorCount.required' => 'ระบุจำนวนชั้น',

            'warehouse_slotCount.required' => 'ระบุจำนวนช่องเก็บของ',

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
