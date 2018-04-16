@extends('admin.layouts.template')
@section('content')
<div class="row page-header">
  <a class="btn btn-default" href="{{url('order')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
    <i class="fa fa-edit"></i> {{$order_id != null ? 'แก้ไขข้อมูล' : 'สร้าง'}}ใบเสนอคาคา
  </div>
  <div class="card-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('order_submit') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <input type="hidden" name="order_id" value="{{ $order_id }}">

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-12">
            <label for="selectCustomer">ผู้สั่งซื้อ</label>
            <select class="form-control" name="selectCustomer" id="selectCustomer">
              <option value="" selected>เลือกลูกค้า</option>
          </select>
          </div>
        </div>
      </div>

        <div class="form-group" id="first_form">
          <div class="form-row">
              <div class="col-md-8">
                <label for="selectProduct">เลือกสินค้า</label>
                <select class="form-control" name="selectProduct[]" id="selectProduct">
                  <option value="" selected>เลือกสินค้า</option>
                </select>
              </div>
              {!!$errors->first('selectCarco', '<span class="control-label" style="color:red" for="selectProduct">*:message</span>')!!}

           <div class="col-md-4">
            <label for="productBuyCount">จำนวนที่สั่งซื้อ</label>
             <input type="number" class="form-control" name="productBuyCount[]" id="productBuyCount" placeholder="จำนวนสั่งซื้อ">
              {!!$errors->first('productBuyCount', '<span class="control-label" style="color:red" for="productBuyCount">*:message</span>')!!}
            </div>
          </div>
        </div>

      <div id="productZone"></div>
        <div class="col-md-12">
            <a id="addProductOrder" class="btn btn-sm btn-block btn-light">เพิ่มรายการขาย</a>
      </div>

      <div class="form-group" style="margin-top: 2%">
        <div class="form-row">
          <div class="col-md-6">
            <label for="order_payment_type">รูปแบบการชำระเงิน : </label>
            <label class="radio-inline">
              <input type="radio" name="order_payment_type" value="0" {{ $order ? $order->order_payment_type == '0' ? 'checked' : '' : '' }}> เก็บเงินปลายทาง
            </label> | 
            <label class="radio-inline">
              <input type="radio" name="order_payment_type" value="1" {{ $order ? $order->order_payment_type == '1' ? 'checked' : '' : '' }}> บัตรเครดิต 
            </label>
            {!!$errors->first('order_payment_type', '<span class="control-label" style="color:red" for="order_payment_type">*:message</span>')!!}
          </div>

          <div class="col-md-6">
            <label for="order_payment_type">รูปแบบการจัดส่ง : </label>
            <label class="radio-inline">
              <input type="radio" name="order_delivery_status" value="0" {{ $order ? $order->order_delivery_status == '0' ? 'checked' : '' : '' }}> ส่งตามที่อยู่ลูกค้า
            </label> | 
            <label class="radio-inline">
              <input type="radio" name="order_delivery_status" value="9" {{ $order ? $order->order_delivery_status == '99' ? 'checked' : '' : '' }}> รับของด้วยตนเอง
            </label>
            {!!$errors->first('order_payment_type', '<span class="control-label" style="color:red" for="order_payment_type">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-success">
            <i class="fa fa-save"></i>{{$order_id == 0 ? ' เพิ่ม คลังสินค้า':' แก้ไข คลังสินค้า'}}</button>
          <a href="{{url('order_submit')}}" style="visibility: hidden"><i class="fa fa-user-md"></i>New User</a>
        </div>
      </div>

    </form>
  </div>
</div>
</div>
</div>
@stop
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
  $(document).ready(function() {

    $('#addProductOrder').click(function(){
      $("#first_form").clone().appendTo("#productZone");
    });

    var form = $(this);
    $.ajax({
      type: "GET",
      url: "/getCustomerData",
      data: form.serialize(),
      dataType: "json",
      success: function(data) {
        if (data.length > 0) {
          var customer = data;
          for (var x = 0; x < customer.length; x++) {
            $("#selectCustomer").append("<option value='" + customer[x].customer_id + "'>" + customer[x].customer_namelastname + "</option>");
          }
        } else {
          console.log('ไม่มีข้อมูลลูกค้า');
        }
      },
      error: function(data){
        console.log(data);
      },
    }, "json");

    $.ajax({
      type: "GET",
      url: "/getGoodsData",
      data: form.serialize(),
      dataType: "json",
      success: function(data) {
        console.log(data);
        if (data.length > 0) {
          var goods = data;
          for (var x = 0; x < goods.length; x++) {
            $("#selectProduct").append("<option value='" + goods[x].goods_id + "'>" + goods[x].goods_name + " (จำนวนที่เหลือ: " + goods[x].goods_amountall + ")</option>");
          }
        } else {
          console.log('ไม่มีข้อมูลลูกค้า');
        }
      },
      error: function(data){
        console.log(data);
      },
    }, "json");
  });
</script>
