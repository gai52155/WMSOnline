<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
class LoginRequest extends FormRequest {
        //กำหนดเงื่อนไข ของการกรองข้อมูล
    public function rules()
    {
      return[
        'emp_username'=>'required',
        'emp_password'=>'required'
      ];
    }
    public function messages()
    {
        return [
            'emp_id.required' => 'ระบุ USERNAME',
            'emp_password.required' => 'ระบุ PASSWORD',
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
