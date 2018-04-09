<?php namespace App\Http\Requests\Goods;

use Illuminate\Foundation\Http\FormRequest;
class AddGoodsRequest extends FormRequest {
        //กำหนดเงื่อนไข ของการกรองข้อมูล
    public function rules()
    {
      if($this->get('goods_id') == 0){
      return[
        'goods_id'=>'required|size:4|unique:employee',
        'goods_name'=>'required|min:2',
        'goods_limit'=>'required|numeric',
        'goods_price'=>'required|numeric',
      ];
    }
    else{
      return[
        'goods_name'=>'required|min:2',
        'goods_limit'=>'required',
        'goods_price'=>'required|numeric',
      ];
    }
    }
    public function messages()
    {
        return [

            'goods_id.required' => 'ระบุ ID สินค้า',
            'goods_id.unique' => 'ID สินค้านี้มีในระบบแล้ว',
            'goods_id.size' => 'ระบุ ID สินค้า 4 ตัวอักษร',

            'goods_name.required' => 'ระบุชื่อสินค้า',

            'goods_limit.required' => 'ระบ limit จำนวนสินค้า',

            'goods_price.required' => 'ระบุราคาสินค้า',
            'goods_price.numeric' => 'ระบุราคาสินค้าเป็นตัวเลข',

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
