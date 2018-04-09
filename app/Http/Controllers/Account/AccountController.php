<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admins\AddUserRequest;
use App\Employee;
use DB;

class AccountController extends Controller
{
    public function getIndex(){
    $emp = Employee::selectRaw('*')->get();
    $search = false;
    $data=[
      'emp' => $emp,
      'search' => $search
    ];
    return view('admin.account.accounts', $data);
  }

  public function getForm($emp_id = 0){
  	if($emp_id != 0){
        $user = Employee::where('emp_id', $emp_id)->first();
        if(!$user) return redirect('admin.account.account_form');
        else{
          $name = ""; $lastname = ""; $flag = 1;
          $temp = str_split($user["emp_name"]);
          for($i = 0;$i<sizeOf($temp);$i++){
            if($temp[$i] != " "){ //ช่องว่างระหว่าง ชื่อ(1) กับ นามสกุล(0)
              if($flag == 1){
                $name .= $temp[$i];
              }
              else{
                $lastname .= $temp[$i];
              }
            }
            else{
              $flag = 2;
            }
          }
          unset($user["emp_name"]);
          $user["emp_name"] = $name;
          $user["emp_lastname"] = $lastname;
        }
    }
    else{ $user = false;}
    $data = array('emp_id' => $emp_id,'user' => $user);
    return view('admin.account.account_form',$data);
  }

  public function deleteUser($emp_id){
    Employee::where('emp_id', '=', $emp_id)->delete();
    return redirect('account');
  }

  public function searchUser(Request $req){
    $searchTxt = $req->get('searchTxt');
    $searchTSel = $req->get('searchSel');

    $emp = Employee::where($searchTSel, 'LIKE', "%{$searchTxt}%")->get();
    $data=[
      'emp' => $emp,
      'search' => $searchTxt
    ];
    return view('admin.account.accounts', $data);
  }

  public function getFormInput(AddUserRequest $req){
    $emp_id = $req->get('emp_id');
    $chk = Employee::where('emp_id',$emp_id)->first();
    $employee = $chk ? $chk : new Employee;
    if(!$chk){
      $employee->emp_id = $emp_id;
    }
    $employee->emp_username = $req->get('emp_username');
    $employee->emp_password = $req->get('emp_password');

    $emp_name = $req->get('emp_name');
    $emp_lastname = $req->get('emp_lastname');
    $employee->emp_name = $emp_name." ".$emp_lastname;

    $employee->emp_position = $req->get('emp_position');
    $employee->emp_tel = $req->get('emp_tel');
    $employee->save();

    return redirect('account');
  }
}
