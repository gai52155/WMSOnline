@extends('admin.layouts.template') @section('content')
<div class="row page-header">
    <a class="btn btn-default" href="{{url('goods_detail/'.$goods_id)}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
</div>
<!-- /.row -->
<div class="col-md-8 mx-auto">
<div class="card">
  <div class="card-header">
    <i class="fa fa-edit"></i> {{$goods_period != null ? 'แก้ไขข้อมูลการนำเข้า' : 'เพิ่มข้อมูลการนำเข้า'}} {{$goods_id}}
  </div>
  <div class="card-body">
    <form class="form-horizontal" role="form" method="POST" action="{{ url('goods_detail_form_submit') }}">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">

      <input type="hidden" name="goods_id" value="{{ $goods_id }}">
      <input type="hidden" name="goods_period" value="{{ $goods_period }}">

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <label for="goods_amount">จำนวนสินค้า</label>
            <input type="number" class="form-control" name="goods_amount" value="{{ $goods_detail ? $goods_detail->goods_amount : old('goods_amount') }}"> {!!$errors->first('goods_amount', '<span class="control-label" style="color:red" for="goods_amount">*:message</span>')!!}
          </div>

          <div class="col-md-6">
            <label for="goods_waste">จำนวนสินค้าเสีย</label>
            <input type="number" class="form-control" name="goods_waste" value="{{ $goods_detail ? $goods_detail->goods_waste : old('goods_waste') }}"> {!!$errors->first('goods_waste', '<span class="control-label" style="color:red" for="goods_waste">*:message</span>')!!}
          </div>

        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-6">
            <label for="selectCarco">เลือกโกดังที่ต้องการเก็บสินค้า</label>
            <select class="form-control" name="selectCarco" id="selectCarco">
              <option value="" selected>เลือกโกดังเก็บสินค้า</option>
          </select>
          {!!$errors->first('selectCarco', '<span class="control-label" style="color:red" for="selectCarco">*:message</span>')!!}
          </div>
          
          <div class="col-md-6" id="setLocation">
            <label for="selectLocation">เลือกพื้นที่ที่ต้องการเก็บสินค้า</label>
            <select class="form-control" name="selectLocation" id="selectLocation">
            </select>
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="form-row">
          <div class="col-md-12">
            <label for="goods_import_from">บริษัทที่นำเข้า</label>
            <input type="text" class="form-control" name="goods_import_from" value="{{ $goods_detail ? $goods_detail->goods_import_from : old('goods_import_from') }}">
            {!!$errors->first('goods_import_from', '<span class="control-label" style="color:red" for="goods_import_from">*:message</span>')!!}
          </div>
        </div>
      </div>

      <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
          <button type="submit" class="btn btn-success">
            <i class="fa fa-save"></i>{{$goods_period == 0 ? ' เพิ่มข้อมูลการนำเข้าสินค้า':' แก้ไขข้อมูลการนำเข้าสินค้า'}}</button>
          <a href="{{url('goods_detail_form_submit')}}" style="visibility: hidden"><i class="fa fa-customer-md"></i>New customer</a>
        </div>
      </div>
    </form>
  </div>
  </div>
</div>
@stop
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $("#setLocation").hide();
    var storage;
    var form = $(this);
    $.ajax({
      type: "GET",
      url: "/getStorageData",
      data: form.serialize(),
      dataType: "json",
      success: function(data) {
        if (data.length > 0) {
          storage = data;
          for (var x = 0; x < storage.length; x++) {
            $("#selectCarco").append("<option value='" + storage[x].warehouse_id + "'>" + storage[x].warehouse_id + "</option>");
          }
        } else {
          console.log('ไม่มีคลังสินค้า');
        }
      },
      error: function(data){
        console.log(data);
      },
    }, "json");

    $('#selectCarco').on('change', function() {
      $('#setLocation').find('option').remove().end();
      if (this.value == "") {
        $("#setLocation").hide();
      } else {
        $("#setLocation").show();
        $.ajax({
          type: "GET",
          url: "/getLocationData",
          data: form.serialize(),
          dataType: "json",
          success: function(data) {
            if (data.length > 0) {
              storage = data;
              for (var x = 0; x < storage.length; x++) {
                $("#selectLocation").append("<option value='" + storage[x].storage_index + "|" + storage[x].floor_index + "|" + storage[x].slot_index +"'> ชั้นวางที่ : " + storage[x].storage_index + " ชั้นที่ : "+ storage[x].floor_index + " ช่องที่ : "+ storage[x].slot_index +"</option>");
              }
            } else {
              console.log('ไม่มีคลังสินค้า');
            }
          }
        }, "json");
      }
    })

  });
</script>
