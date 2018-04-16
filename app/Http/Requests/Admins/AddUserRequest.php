<?php namespace App\Http\Requests\Admins;

use Illuminate\Foundation\Http\FormRequest;
class AddUserRequest extends FormRequest {
        //กำหนดเงื่อนไข ของการกรองข้อมูล
    public function rules()
    {
      if($this->get('emp_id') == -99){
      return[
        'emp_id'=>'required|digits:5|unique:employee',
        'emp_username'=>'required|min:5|unique:employee',
        'emp_password'=>'required|min:8|unique:employee',
        'emp_name'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',
        'emp_lastname'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',
        'emp_position'=>'required',
        'emp_tel'=>'required|digits_between:9,10'
      ];
    }
    else{
      return[
        'emp_username'=>'required|min:5',
        'emp_password'=>'required|min:8',
        'emp_name'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',
        'emp_lastname'=>'required|regex:/^[a-zA-Zก-๙]*$/|min:2',
        'emp_position'=>'required',
        'emp_tel'=>'required|digits_between:9,10'
      ];
    }
    }
    public function messages()
    {
        return [
            'emp_id.required' => 'โปรดใส่รหัสพนักงาน',
            'emp_id.unique' => 'รหัสพนักงานนี้มีในระบบแล้ว',
            'emp_id.digits' => 'ระบุหมายเลขรหัสประจำตัวพนักงานเป็นตัวเลข 5 หลัก',

            'emp_username.required' => 'กำหนด USERNAME ของพนักงาน',
            'emp_username.min' => 'กำหนด USERNAME ของพนักงานอย่างน้อย 5 ตัวอักษร',
            'emp_username.unique' => 'USERNAME นี้ ซ้ำในระบบ',

            'emp_password.required' => 'กำหนด PASSWORD ของพนักงาน',
            'emp_password.min' => 'กำหนด PASSWORD ของพนักงานอย่างน้อย 8 ตัวอักษร',
            'emp_password.unique' => 'PASSWORD นี้ ซ้ำในระบบ',

            'emp_name.required' => 'ระบุชื่อพนักงาน',
            'emp_name.regex' => 'ระบุชื่อพนักงานให้ถูกต้อง',

            'emp_lastname.required' => 'ระบุชื่อนามสกุล',
            'emp_lastname.regex' => 'ระบุชื่อนามสกุลให้ถูกต้อง',

            'emp_position.required' => 'เลือกตำแหน่งของพนักงาน',

            'emp_tel.required' => 'ระบุหมายเลขโทรศัพท์ของพนักงาน',
            'emp_tel.digits_between' => 'ระบุหมายเลขโทรศัพท์เป็นตัวเลขอย่างน้อย 9 หลัก และ ไม่เกิน 10 หลัก',
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
