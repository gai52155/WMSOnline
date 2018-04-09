<?php

Route::get('/', function () {
    return view('login');
});

Route::get('/testPDF','TestPDFController@getIndex'); //เพิ่ม USER

Route::get('/check-connect',function(){
 if(DB::connection()->getDatabaseName())
 {
 return "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
 }else{
 return 'Connection False !!';
 }

});

//Login Controller
Route::post('/loginme', 'loginManagement\LoginController@login');
Route::get('/login','loginManagement\LoginController@getIndex');
Route::get('/logout','loginManagement\LoginController@logout');

Route::get('/dashboard', 'dashboard\DashboardController@getindex');

//account controller
Route::get('/account','Account\AccountController@getIndex'); //หน้าข้อมูล USER
Route::get('/account_form','Account\AccountController@getForm'); //เพิ่ม USER
Route::post('/account_form_submit', 'Account\AccountController@getFormInput'); // POST เพิ่ม USER
Route::post('/account_search', 'Account\AccountController@searchUser'); // POST ค้นหา USER
Route::get('/account_form/{emp_id}', 'Account\AccountController@getForm'); //แก้ไข USER
Route::get('/delete/{emp_id}', 'Account\AccountController@deleteUser'); //ลบ USER

//customer controller
Route::get('/customer','Customer\CustomerController@getIndex');
Route::get('/customer_form','Customer\CustomerController@getForm'); //เพิ่ม USER
Route::post('/customer_form_submit', 'Customer\CustomerController@getFormInput'); // POST
Route::get('/customer_form/{customer_id}', 'Customer\CustomerController@getForm'); //แก้ไข
Route::get('/customer_delete/{customer_id}', 'Customer\CustomerController@deleteCustomer'); //ลบ
Route::post('/customer_search', 'Customer\CustomerController@searchCustomer'); // POST ค้นหา

//goods controller
Route::get('/goods','Goods\GoodsController@getIndex');
Route::get('/goods_form','Goods\GoodsController@getForm');
Route::post('/goods_form_submit', 'Goods\GoodsController@getFormInput'); // POST
Route::get('/goods_edit/{goods_id}', 'Goods\GoodsController@getForm'); //แก้ไข
Route::get('/goods_delete/{goods_id}', 'Goods\GoodsController@deleteGoods'); //ลบ
Route::post('/goods_search', 'Goods\GoodsController@searchGoods'); // POST ค้นหา

Route::get('/goods_detail/{goods_id}', 'Goods\GoodsDetailController@getIndex');
Route::get('/goods_detail_form/{goods_id}', 'Goods\GoodsDetailController@getForm'); //ลบ
Route::post('/goods_detail_form_submit', 'Goods\GoodsDetailController@getFormInput'); // POST
Route::get('/goods_detail_edit/{goods_id}/{goods_period}', 'Goods\GoodsDetailController@getForm'); //แก้ไข
Route::get('/getStorageData', 'Goods\GoodsDetailController@getStorage'); // GET
Route::get('/getLocationData', 'Goods\GoodsDetailController@getLocation'); // POST

//warehouse controller
Route::get('/warehouse','Warehouse\WarehouseController@getIndex');
Route::get('/warehouse_form','Warehouse\WarehouseController@getForm');
Route::post('/warehouse_form_submit', 'Warehouse\WarehouseController@getFormInput'); // POST
Route::get('/warehouse_detail/{warehouse_id}', 'Warehouse\WarehouseDetailController@getIndex');
Route::get('/warehouse_form/{warehouse_id}', 'Warehouse\WarehouseController@getForm');

//order controller
Route::get('/order','Order\OrderController@getIndex');
Route::get('/order_form','Order\OrderController@getForm');
Route::get('/getCustomerData','Order\OrderController@getCustomerData');
Route::get('/getGoodsData','Order\OrderController@getGoodsData');
Route::post('/order_submit', 'Order\OrderController@getFormInput'); // POST
Route::get('/order/delete/{order_id}','Order\OrderController@deleteOrder');

Route::get('/order/confirm/{order_id}','Order\OrderController@confirmOrder');
Route::get('/order_delivery/confirm/{order_id}','Order\OrderController@confirmDelivery');

Route::get('/order/{order_id}','Order\OrderDetailController@getIndex');
Route::get('/order_detail/delete/{order_id}/{goods_id}', 'Order\OrderDetailController@deleteOrderDetail');