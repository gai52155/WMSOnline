<?php

namespace App\Http\Controllers\LoginManagement; // กำหนดที่อยู่ของ Controller
use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use Illuminate\http\Request; // เรียกใช้ Request เมื่อมีการส่ง FORM INPUT
use App\Http\Requests\LoginRequest;
use App\Employee;
use Session;
use DB;

class LoginController extends Controller
{
	public function getIndex(){
		return view('login');
	}

	public function login(LoginRequest $req){
		$username = $req->input('emp_username');
		$password = $req->input('emp_password');
		$emp_name = "";
		$checklogin = DB::table('employee')->where(['emp_username'=>$username, 'emp_password'=>$password])->get();
		if(count($checklogin)>0){
			session()->put('nameLogin', $username);
			DB::table('employee')->where('emp_username', $username)->update(['emp_last_login'=>date("Y-m-d H:i:s"), 'emp_status'=>'1']);
			return redirect('dashboard');
		}
		else{
			echo "Login Failed";
		}
	}

	public function logout(){
		DB::table('employee')->where('emp_username', Session::get('nameLogin'))->update(['emp_status'=>'0']);
    	Session::flush();
    	return redirect('login');
	}
}
