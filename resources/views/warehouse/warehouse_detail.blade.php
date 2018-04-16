@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-7 mx-auto">
    <div class="row page-header">
      <a class="btn btn-default" href="{{url('warehouse')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>
    </div>
    <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> รายละเอียดคลังสินค้า {{$warehouse_id}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('warehouse_form')}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มคลังสินค้า</a>
        </div>
      </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-sm table-hover">
            <thead>
              <tr>
                <th>ที่เก็บสินค้า</th>
                <th>หมายเลขสินค้า</th>
                <th>จำนวนสินค้า</th>
                <th>วันที่เก็บสินค้า</th>

                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              @foreach($warehouse as $u)
              <tr>
                <td>
                  ชั้นวางที่ : <B>{{$u->storage_index}}</B> ชั้นที่ : <B>{{$u->floor_index}}</B> ช่องที่ : <B>{{$u->slot_index}}</B>
                </td>
                <td>@if ($u->goods_id)
                  <a href="{{url('goods_detail/'.$u->goods_id)}}">{{$u->goods_id}}</a>
                  @else
                    ว่าง
                  @endif
                </td>
                <td>@if ($u->goods_amount)
                  {{$u->goods_amount}}
                  @else
                    ว่าง
                  @endif
                </td>
                <td>{{$u->goods_period}}</td>

                <td>
                  @if($u->goods_id)
                  <a href="" class="edit" id="goodsMove" data-toggle="modal" data-target="#moveModal" onclick="getValue({{$u->warehouse_id}}, {{$u->goods_amount}}, {{$u->goods_id}}, {{$u->goods_period}}, {{$u->storage_index}}, {{$u->floor_index}}, 
                  {{$u->slot_index}})">ย้าย <i class="fa fa-cubes"></i></a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
  <div class="modal fade" id="moveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">ย้ายสินค้าหมายเลข : <a id=moveGoodsId></a></h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12 mx-auto">
              <h5>ย้ายจากชั้นวางที่ : <a id="storageId"></a> ชั้นที่ : <a id="floorId"></a> ช่องที่ : <a id="slotId"></a>
              </h5>
            </div>
            <div class="col-md-8 mx-auto">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/warehouseGoodsMove') }}">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-12">

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <input type="hidden" id="oldwarehouse_id" name="oldwarehouse_id">
                <input type="hidden" id="goods_id" name="goods_id">
                <input type="hidden" id="goods_period" name="goods_period">
                <input type="hidden" id="goods_amount" name="goods_amount">

                <label for="selectCarco">เลือกโกดังที่ต้องการเก็บสินค้า</label>
                <select class="form-control" name="selectCarco" id="selectCarco">
                  <option value="" selected>เลือกโกดังเก็บสินค้า</option>
                </select>
                {!!$errors->first('selectCarco', '<span class="control-label" style="color:red" for="selectCarco">*:message</span>')!!}
                </div>
                
                <div class="col-md-12" id="setLocation">
                  <label for="selectLocation">เลือกพื้นที่ที่ต้องการเก็บสินค้า</label>
                  <select class="form-control" name="selectLocation" id="selectLocation">
                  </select>
                </div>
              </div>
            </div>
              
            </div>
          </div>
          <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <input type="submit" class="btn btn-success" href="" value="ย้ายสินค้า">
        </div>
        </form>
      </div>
    </div>
  </div>

<script>
  function getValue(warehouse_id, goods_amount, goodsid, period, storage, floor, slot){
    $('#moveGoodsId').text(goodsid);
    $('#moveGoodPeriod').text(period);
    $('#storageId').text(storage);
    $('#floorId').text(floor);
    $('#slotId').text(slot);

    $('#oldwarehouse_id').val(warehouse_id);
    $('#goods_id').val(goodsid);
    $('#goods_amount').val(goods_amount);
    $('#goods_period').val(period);
  }

  $("th").addClass("text-center");
  $("td").addClass("text-center");

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
      var cargo = $('#selectCarco').find(":selected").text();
      $('#setLocation').find('option').remove().end();
      if (this.value == "") {
        $("#setLocation").hide();
      } else {
        $("#setLocation").show();
        $.ajax({
          type: "GET",
          url: "/getLocationData/"+cargo,
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
@stop
