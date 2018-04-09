@extends('admin.layouts.template')
@section('content')
<div class="row page-header">
    <a class="btn btn-default" href="{{url('warehouse')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
    <i class="fa fa-edit"></i> {{$warehouse_id != null ? 'แก้ไขข้อมูล' : 'เพิ่มข้อมูล'}} โกดังสินค้า {{ $warehouse_id != null ? $warehouse_id : ''}}
  </div>
  <div class="card-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('warehouse_form_submit') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <div class="form-group" {{ $warehouse_id ? 'hidden' : '' }}>
        <div class="form-row">
          <div class="col-md-6">
            <label for="warehouse_id">รหัสคลังสินค้า(รหัส 3 หลัก)</label>
            <input type="number" class="form-control" name="warehouse_id" value="{{ $warehouse ? $warehouse->warehouse_id : old('emp_id') }}">
            {!!$errors->first('warehouse_id', '<span class="control-label" style="color:red" for="warehouse_id">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-4">
            <label for="warehouse_storageCount">จำนวนชั้นวางสินค้า</label>
            <input type="number" class="form-control" name="warehouse_storageCount" value="{{ $warehouse ? $warehouse->warehouse_storageCount : old('warehouse_storageCount') }}">
            {!!$errors->first('warehouse_storageCount', '<span class="control-label" style="color:red" for="warehouse_storageCount">*:message</span>')!!}
          </div>

          <div class="col-md-4">
            <label for="warehouse_floorCount">จำนวนชั้น</label>
            <input type="number" class="form-control" name="warehouse_floorCount" value="{{ $warehouse ? $warehouse->warehouse_floorCount : old('warehouse_floorCount') }}">
            {!!$errors->first('warehouse_floorCount', '<span class="control-label" style="color:red" for="warehouse_floorCount">*:message</span>')!!}
          </div>

          <div class="col-md-4">
            <label for="warehouse_slotCount">จำนวนช่องเก็บของ</label>
            <input type="number" class="form-control" name="warehouse_slotCount" value="{{ $warehouse ? $warehouse->warehouse_slotCount : old('warehouse_slotCount') }}">
            {!!$errors->first('warehouse_slotCount', '<span class="control-label" style="color:red" for="warehouse_slotCount">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-12">
          <button type="submit" class="btn btn-block btn-success">
            <i class="fa fa-save"></i>{{$warehouse_id == 0 ? ' เพิ่ม คลังสินค้า':' แก้ไข คลังสินค้า'}}</button>
          <a href="{{url('warehouse_form_submit')}}" style="visibility: hidden"><i class="fa fa-user-md"></i>New User</a>
        </div>
      </div>

    </form>
  </div>
  </div>
</div>
@stop
