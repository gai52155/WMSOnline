@extends('admin.layouts.template')
@section('content')
<div class="row page-header">
    <a class="btn btn-default" href="{{url('goods')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
    <i class="fa fa-edit"></i> {{$goods_id != null ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล'}}สินค้า {{ $goods_id != null ? $goods_id : ''}}
  </div>
  <div class="card-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('goods_form_submit') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6" {{ $goods_id ? 'hidden' : '' }}>
            <label for="goods_id">ID(เลข 4 หลัก)</label>
            <input type="number" class="form-control" name="goods_id" value="{{ $goods ? $goods->goods_id : old('goods_id') }}">
              {!!$errors->first('goods_id', '<span class="control-label" style="color:red" for="goods_id">*:message</span>')!!}
          </div>

          <div class="col-md-6">
            <label for="goods_name">ชื่อสินค้า</label>
            <input type="text" class="form-control" name="goods_name" value="{{ $goods ? $goods->goods_name : old('goods_name') }}">
            {!!$errors->first('goods_name', '<span class="control-label" style="color:red" for="goods_name">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
            <div class="col-md-6">
              <label for="goods_limit">จำนวนที่แจ้งเตือน</label>
              <input type="number" class="form-control" name="goods_limit" value="{{ $goods ? $goods->goods_limit : old('goods_limit') }}">
              {!!$errors->first('goods_limit', '<span class="control-label" style="color:red" for="goods_limit">*:message</span>')!!}
            </div>

            <div class="col-md-6">
              <label for="goods_price">ราคาสินค้า</label>
              <input type="number" class="form-control" name="goods_price" value="{{ $goods ? $goods->goods_price : old('goods_price') }}">
              {!!$errors->first('goods_price', '<span class="control-label" style="color:red" for="goods_price">*:message</span>')!!}
            </div>
          </div>
      </div>
      <div class="form-group">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-success">
            <i class="fa fa-save"></i>{{$goods_id == 0 ? ' เพิ่ม สินค้า':' แก้ไข สินค้า'}}</button>
              <a href="{{url('goods_form_submit')}}" style="visibility: hidden"><i class="fa fa-customer-md"></i>New customer</a>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>
@stop
