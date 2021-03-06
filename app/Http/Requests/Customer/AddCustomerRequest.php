<?php namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
class AddCustomerRequest extends FormRequest {
    public function rules()
    {
        if($this->get('emp_id') == -99){
          return[
            'customer_name'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',

            'customer_lastname'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',

            'customer_addressno'=>'required|min:2',

            'customer_subdistrict'=>'required',

            'customer_district'=>'required',

            'customer_province'=>'required',

            'customer_postal'=>'required|digits:5',

            'customer_tel'=>'required|digits_between:9,10'
          ];
        }
        else{
            return[
            'customer_name'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',

            'customer_lastname'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',

            'customer_addressno'=>'required|min:2',

            'customer_postal'=>'required|digits:5',

            'customer_tel'=>'required|digits_between:9,10'
          ];
        }
    }

    public function messages()
    {
        return [

            'customer_name.required' => 'ระบุชื่อลูกค้า',
            'customer_name.regex' => 'ระบุชื่อลูกค้าให้ถูกต้อง',

            'customer_lastname.required' => 'ระบุชื่อนามสกุล',
            'customer_lastname.regex' => 'ระบุนามสกุลลูกค้าให้ถูกต้อง',

            'customer_addressno.required' => 'ระบุเลขที่อยู่',

            'customer_subdistrict.required' => 'ระบุแขวง',

            'customer_district.required' => 'ระบุเขต',

            'customer_province.required' => 'ระบุจังหวัด',

            'customer_postal.required' => 'ระบุหมายเลขไปรษณีย์',
            'customer_postal.digits' => 'ระบุหมายเลขไปรษณีย์เป็นตัวเลข 5 หลัก',

            'customer_tel.required' => 'ระบุหมายเลขโทรศัพท์',
            'customer_tel.digits_between' => 'ระบุหมายเลขโทรศัพท์เป็นตัวเลขอย่างน้อย 9 หลัก และ ไม่เกิน 10 หลัก',
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
