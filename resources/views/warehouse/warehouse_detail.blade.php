@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
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
                <th>หมายเลขคลังสินค้า</th>
                <th>ชั้นวางสินค้าที่</th>
                <th>ชั้นที่เก็บสินค้า</th>
                <th>ช่องเก็บของ</th>
                <th>หมายเลขสินค้า</th>
                <th>วันที่เก็บสินค้า</th>
              </tr>
            </thead>
            <tbody>
              @foreach($warehouse as $u)
              <tr>
                <td>{{$u->warehouse_id}}</td>
                <td>{{$u->storage_index}}</td>
                <td>{{$u->floor_index}}</td>
                <td>{{$u->slot_index}}</td>
                <td>@if ($u->goods_id)
                  <a href="{{url('goods_detail/'.$u->goods_id)}}">{{$u->goods_id}}</a>
                  @else
                    ว่าง
                  @endif
                </td>
                <td>{{$u->goods_period}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
