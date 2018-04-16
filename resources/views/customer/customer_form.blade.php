@extends('admin.layouts.template')
@section('content')
<div class="row page-header">
  <div class="padding-top-20">
    <a class="btn btn-default" href="{{url('customer')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
  </div>
  <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
          <i class="fa fa-edit"></i> {{$customer_id != null ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล'}}พนักงาน
      </div>
      <div class="card-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('customer_form_submit') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <input type="hidden" name="customer_id" value="{{ $customer_id }}">

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="customer_name">ชื่อ</label>
                <input type="text" class="form-control" name="customer_name" value="{{ $customer ? $customer->customer_name : old('customer_name') }}">
                {!!$errors->first('customer_name', '<span class="control-label" style="color:red" for="customer_name">*:message</span>')!!}
              </div>

              <div class="col-md-6">
                <label for="customer_lastname">นามสกุล</label>
                <input type="text" class="form-control" name="customer_lastname" value="{{ $customer ? $customer->customer_lastname : old('customer_lastname') }}">
                {!!$errors->first('customer_lastname', '<span class="control-label" style="color:red" for="customer_lastname">*:message</span>')!!}
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-4">
                <label for="customer_province">จังหวัด</label>
                  <select class="form-control" name="customer_province" id="customer_province">
                    <option value="" selected>{{ $customer ? $customer->customer_province : 'เลือกที่อยู่จังหวัด' }}</option>
                  </select>
                  {!!$errors->first('customer_province', '<span class="control-label" style="color:red" for="customer_province">*:message</span>')!!}
              </div>

              <div class="col-md-4">
                <label for="customer_district">เขต</label>
                  <select class="form-control" name="customer_district" id="customer_district">
                    <option value="" selected>{{ $customer ? $customer->customer_district : 'เลือกที่อยู่ เขต/อำเภอ' }}</option>
                  </select>
                  {!!$errors->first('customer_district', '<span class="control-label" style="color:red" for="customer_district">*:message</span>')!!}
              </div>

              <div class="col-md-4">
                <label for="customer_subdistrict">แขวง</label>
                  <select class="form-control" name="customer_subdistrict" id="customer_subdistrict">
                    <option value="" selected>{{ $customer ? $customer->customer_subdistrict : 'เลือกที่อยู่ แขวง/ตำบล' }}</option>
                  </select>
                {!!$errors->first('customer_subdistrict', '<span class="control-label" style="color:red" for="customer_subdistrict">*:message</span>')!!}
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-12">
                <label for="customer_addressno">ที่อยู่โดยละเอียด.</label>
                <input type="text" class="form-control" name="customer_addressno" value="{{ $customer ? $customer->customer_addressno : old('customer_addressno') }}">
                {!!$errors->first('customer_addressno', '<span class="control-label" style="color:red" for="customer_addressno">*:message</span>')!!}
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="customer_postal">เลขไปรษณีย์</label>
                <input type="text" class="form-control" name="customer_postal" value="{{ $customer ? $customer->customer_postal : old('customer_postal') }}">
                {!!$errors->first('customer_postal', '<span class="control-label" style="color:red" for="customer_postal">*:message</span>')!!}
              </div>

              <div class="col-md-6">
                <label for="customer_tel">Tel.</label>
                <input type="text" class="form-control" name="customer_tel" value="{{ $customer ? $customer->customer_tel : old('customer_tel') }}">
                {!!$errors->first('customer_tel', '<span class="control-label" style="color:red" for="emp_tel">*:message</span>')!!}
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-12">
              <button type="submit" class="btn btn-block btn-success">
                <i class="fa fa-save"></i>{{$customer_id == 0 ? ' เพิ่ม ลูกค้า':' แก้ไข ลูกค้า'}}</button>
              <a href="{{url('customer_form_submit')}}" style="visibility: hidden"><i class="fa fa-customer-md"></i>New customer</a>
            </div>
          </div>

        </form>
  </div>
  </div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('#customer_district').prop('disabled', true);
    $('#customer_subdistrict').prop('disabled', true);
    var province;
    var distinct;
    var sub_distinct;
    var form = $(this);
    $.ajax({
      type: "GET",
      url: "/getProvince",
      data: form.serialize(),
      dataType: "json",
      success: function(data) {
        if (data.length > 0) {
          province = data;
          
          for (var x = 0; x < province.length; x++) {
            $("#customer_province").append("<option value='" + province[x].PROVINCE_ID + "'>" + province[x].PROVINCE_NAME + "</option>");
          }
        }
      },
      error: function(data){
        console.log(data);
      },
    }, "json");

    $('#customer_province').on('change', function() {
      $('#customer_district').prop('disabled', false);
      var province_index = $('#customer_province').find(":selected").val();
      $('#customer_district').find('option').remove().end();
      if (this.value != "") {
        $.ajax({
          type: "GET",
          url: "/getAmphures/"+province_index,
          data: form.serialize(),
          dataType: "json",
          success: function(data) {
            if (data.length > 0) {
              distinct = data;
              $("#customer_district").append("<option value='' selected>เลือกที่อยู่ เขต/อำเภอ</option>");
              for (var x = 0; x < distinct.length; x++) {
                $("#customer_district").append("<option value='" + distinct[x].AMPHUR_ID +"'>" + distinct[x].AMPHUR_NAME +"</option>");
              }
            }
          },error: function(data){
            console.log(data.error);
          },
        }, "json");
      }
    });

    $('#customer_district').on('change', function() {
      $('#customer_subdistrict').prop('disabled', false);
      var amphur_index = $('#customer_district').find(":selected").val();
      $('#customer_subdistrict').find('option').remove().end();
      if (this.value != "") {
        $.ajax({
          type: "GET",
          url: "/getDistinct/"+amphur_index,
          data: form.serialize(),
          dataType: "json",
          success: function(data) {
            if (data.length > 0) {
              sub_distinct = data;
              $("#customer_subdistrict").append("<option value='' selected>เลือกที่อยู่ แขวง/ตำบล</option>");
              for (var x = 0; x < sub_distinct.length; x++) {
                $("#customer_subdistrict").append("<option value='" + sub_distinct[x].DISTRICT_ID +"'>" + sub_distinct[x].DISTRICT_NAME +"</option>");
              }
            }
          },error: function(data){
            console.log(data.error);
          },
        }, "json");
      }
    });

  });
</script>
@stop
