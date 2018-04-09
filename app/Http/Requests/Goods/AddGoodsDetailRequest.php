<?php namespace App\Http\Requests\Goods;

use Illuminate\Foundation\Http\FormRequest;
class AddGoodsDetailRequest extends FormRequest {
        //กำหนดเงื่อนไข ของการกรองข้อมูล
    public function rules()
    {
      if($this->get('goods_period') == 0){
      return[
        'goods_amount'=>'required|min:1|integer',
        'goods_waste'=>'integer',
        'goods_import_from'=>'required|min:5',
        'selectCarco'=>'required',
      ];
    }
    else{
      return[
        'goods_amount'=>'required|min:1|integer',
        'goods_waste'=>'integer',
        'goods_import_from'=>'required|min:5',
      ];
    }
    }
    public function messages()
    {
        return [

            'goods_amount.required' => 'ระบุจำนวนสินค้า',
            'goods_amount.integer' => 'ระบุจำนวนสินค้าเป็นเลขจำนวนเต็ม',

            'goods_waste.integer' => 'ระบุจำนวนสินค้าชำรุดเป็นเลขจำนวนเต็ม',

            'goods_import.required' => 'ระบุบริษัทที่นำเข้าสินค้า',

            'selectCarco.required' => 'เลือกสถานที่เก็บสินค้า',
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
