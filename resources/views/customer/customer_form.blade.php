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
              <div class="col-md-3">
                <label for="customer_addressno">เลขที่อยู่.</label>
                <input type="text" class="form-control" name="customer_addressno" value="{{ $customer ? $customer->customer_addressno : old('customer_addressno') }}">
                {!!$errors->first('customer_addressno', '<span class="control-label" style="color:red" for="customer_addressno">*:message</span>')!!}
              </div>

              <div class="col-md-3">
                <label for="customer_province">จังหวัด</label>
                <input type="text" class="form-control" name="customer_province" value="{{ $customer ? $customer->customer_province : old('customer_province') }}">
                {!!$errors->first('customer_province', '<span class="control-label" style="color:red" for="customer_province">*:message</span>')!!}
              </div>

              <div class="col-md-3">
                <label for="customer_district">เขต</label>
                <input type="text" class="form-control" name="customer_district" value="{{ $customer ? $customer->customer_district : old('customer_district') }}">
                {!!$errors->first('customer_district', '<span class="control-label" style="color:red" for="customer_district">*:message</span>')!!}
              </div>

              <div class="col-md-3">
                <label for="customer_subdistrict">แขวง</label>
                <input type="text" class="form-control" name="customer_subdistrict" value="{{ $customer ? $customer->customer_subdistrict : old('customer_subdistrict') }}">
                {!!$errors->first('customer_subdistrict', '<span class="control-label" style="color:red" for="customer_subdistrict">*:message</span>')!!}
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
@stop
