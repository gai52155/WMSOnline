<?php

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller; //เรียกใช้ Controller หลักของ Laravel 5.0
use App\Customer;
use App\Province;
use App\Amphures;
use App\Distincts;
use Request;
use Response;
use App\Http\Requests\Customer\AddCustomerRequest;
use DB;
class CustomerController extends Controller
{
    public function getIndex(){
    $customer = Customer::selectRaw('customer_id, customer_namelastname, customer_addressno, customer_subdistrict, customer_district, customer_province, customer_postal, customer_tel')->get();
    $search = false;
    $data=[
      'customer' => $customer,
      'search' => $search
    ];
    return view('customer.customer', $data);
  }

  public function getForm($customer_id = 0){
    if($customer_id != 0){
        $customer = Customer::where('customer_id', $customer_id)->first();
        if(!$customer) return redirect('customer.customer_form');
        else{
          $name = ""; $lastname = ""; $flag = 1;
          $temp = str_split($customer["customer_namelastname"]);
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
          unset($customer["customer_namelastname"]);
          $customer["customer_name"] = $name;
          $customer["customer_lastname"] = $lastname;
        }
    }
    else{ $customer = false;}
    $data = array('customer_id' => $customer_id,'customer' => $customer);
    return view('customer.customer_form',$data);
  }

  public function getFormInput(AddCustomerRequest $req){
    $customer_id = $req->get('customer_id');
    $chk = Customer::where('customer_id',$customer_id)->first();
    $customer = $chk ? $chk : new Customer;

    if($req->get('customer_province') != ""){
      $province = Province::where('PROVINCE_ID', $req->get('customer_province'))->value('PROVINCE_NAME');
      $customer->customer_province = $province;
    }

    if($req->get('customer_district') != ""){
      $amphur = Amphures::where('AMPHUR_ID', $req->get('customer_district'))->value('AMPHUR_NAME');
      $customer->customer_district = $amphur;
    }

    if($req->get('customer_subdistrict') != ""){
      $distinct = Distincts::where('DISTRICT_ID', $req->get('customer_subdistrict'))->value('DISTRICT_NAME');
      $customer->customer_subdistrict = $distinct;
    }
    
    $customer_name = $req->get('customer_name');
    $customer_lastname = $req->get('customer_lastname');
    $customer->customer_namelastname = $customer_name." ".$customer_lastname;
    $customer->customer_addressno = $req->get('customer_addressno');
    $customer->customer_postal = $req->get('customer_postal');
    $customer->customer_tel = $req->get('customer_tel');
    $customer->save();

    return redirect('customer');
  }

  public function deleteCustomer($customer_id){
    Customer::where('customer_id', '=', $customer_id)->delete();
    return redirect('customer');
  }

  public function searchCustomer(){
    $searchTxt = Request::input('searchTxt');
    $customer = Customer::where('customer_namelastname', 'LIKE', "%{$searchTxt}%")->get();
    $data=[
      'customer' => $customer,
      'search' => $searchTxt
    ];
    return view('customer.customer', $data);
  }

  function getProvince(){
    $data = Province::select('PROVINCE_ID', 'PROVINCE_NAME')->get();
    return Response::json($data);
  }

  function getAmphures($province_index){
    $data = Amphures::select('AMPHUR_ID', 'AMPHUR_NAME')->where('PROVINCE_ID', $province_index)->get();
    return Response::json($data);
  }

  function getDistinct($amphur_index){
    $data = Distincts::select('DISTRICT_ID', 'DISTRICT_NAME')->where('AMPHUR_ID', $amphur_index)->get();
    return Response::json($data);
  }
}
